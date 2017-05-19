<?php
//SQL validation
function confirmQuery($result) {
    global $connection;
    if(!$result) {
        die('Query FAILED. ' . mysqli_error($connection) . ' ' . mysqli_errno($connection));
    }
}
//Protection for inputs
function escape($string) {
    global $connection;
    return mysqli_real_escape_string($connection, trim($string));
}

function usersOnline() {
    //Get request isset
    if(isset($_GET['onlineusers'])) {
        global $connection;
        if(!$connection) {
            session_start();
            include "../includes/db.php";
            $session = session_id();
            $time = time();
            //after 1 minute user will be offline
            $time_out_in_seconds = 05;
            $time_out = $time - $time_out_in_seconds;

            $query = "select * from users_online where session = '$session' ";
            $send_query = mysqli_query($connection, $query);
            confirmQuery($send_query);
            $count = mysqli_num_rows($send_query);

            //Nobody online then add the new user to online table
            if($count == NULL) {
                mysqli_query($connection, "insert into users_online(session, time) values('$session', '$time')");
            } else {
                mysqli_query($connection, "update users_online set time = '$time' where session = '$session' ");
            }
            $users_online_query = mysqli_query($connection, "select * from users_online where time > '$time_out' ");
            echo $count_user = mysqli_num_rows($users_online_query);
        }
    }
}
usersOnline();

function insertCategory() {
    global $connection;
    if(isset($_POST['submit'])) {
        $cat_title = $_POST['cat_title'];
        
        if($cat_title == "" || empty($cat_title)) {
            echo "This field should not be empty.";
        } else {
            $stmt = mysqli_prepare($connection, "INSERT INTO categories(cat_title) VALUES(?) ");
            mysqli_stmt_bind_param($stmt, "s", $cat_title);
            mysqli_stmt_execute($stmt);
            confirmQuery($stmt);
            mysqli_stmt_close($stmt);
        }
    }
}
//With Edit and Delete buttons.
function readCategories() {
    global $connection;
    
    $query = "select * from categories";
    $select_categories = mysqli_query($connection, $query);
    
    confirmQuery($select_categories);

    while($row = mysqli_fetch_assoc($select_categories)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];

        echo "<tr>";
        echo "<td>{$cat_id}</td>";
        echo "<td>{$cat_title}</td>";
        echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
        echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
        echo "</tr>";
    }
}

function updateCategory() {
    
}

function deleteCategories() {
    global $connection;
    if(isset($_GET['delete'])) {
        $delete_cat_id = $_GET['delete'];
        $query = "delete from categories where cat_id = {$delete_cat_id} ";

        $delete_query = mysqli_query($connection, $query);
        
        confirmQuery($delete_query);
        header("Location: categories.php");
    }
}
//General select SQL
function recordCount($table) {
    global $connection;
    
    $query = "select * from " . $table;
    $table_select= mysqli_query($connection, $query);
    confirmQuery($table_select);
    
    return mysqli_num_rows($table_select);
}

function checkStatus($table, $column, $status) {
    global $connection;
    
    $query = "select * from $table where $column = '$status' ";
    $send_query= mysqli_query($connection, $query);
    confirmQuery($send_query);
    
    return mysqli_num_rows($send_query);
}

function isAdmin($username = '') {
    global $connection;
    $stmt = mysqli_prepare($connection, "SELECT user_role FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $user_role);
    
    mysqli_stmt_fetch($stmt);
    if($user_role == 'Admin') {
        return true;
    } else {
        return false;
    }
}

function usernameExists($username) {
    global $connection;
    $query = "SELECT username FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    
    if(mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function emailExists($email) {
    global $connection;
    $query = "SELECT user_email FROM users WHERE user_email = '$email'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    
    if(mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function registerUser($username, $email, $password) {
    global $connection;
    //Check username 
    $username = escape($username);
    $email    = escape($email);
    $password = escape($password);

    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

    $query  = "insert into users (username, user_email, user_password, user_role) ";
    $query .= "values('{$username}', '{$email}', '{$password}', 'Subscriber' ) ";
    $register_user_query = mysqli_query($connection, $query);
    confirmQuery($register_user_query);
}

function loginUser($username, $password) {
    global $connection;
    $username = escape($username);
    $password = escape($password);
    
    $query = "select * from users where username = '{$username}' ";
    $select_user_query = mysqli_query($connection, $query);
    
    confirmQuery($select_user_query);
    
    while($row = mysqli_fetch_array($select_user_query)) {
        $db_user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_email = $row['user_email'];
        $db_user_role = $row['user_role'];
    }
    
    if(password_verify($password, $db_user_password)) {
        $_SESSION['username'] = $db_username;
        $_SESSION['firstname'] = $db_user_firstname;
        $_SESSION['lastname'] = $db_user_lastname;
        $_SESSION['user_role'] = $db_user_role;
        header("Location: ../admin/index.php");
    }  else {
        header("Location: ../index.php");
    }
}

?>