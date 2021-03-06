<?php
if(isset($_POST['create_user'])) {
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role = $_POST['user_role'];
    
//    $post_image = $_FILES['image']['name'];
//    $post_image_temp = $_FILES['image']['tmp_name'];
    
    $username = $_POST['username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    
//    move_uploaded_file($post_image_temp, "../images/$post_image");
    
    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));
    
    $query = "INSERT INTO users(user_firstname, user_lastname, user_role, username, user_email, user_password) ";         
    $query .= "VALUES('{$user_firstname}', '{$user_lastname}', '{$user_role}', '{$username}', '{$user_email}', '{$user_password}') "; 
    
    $create_user_query = mysqli_query($connection, $query);
    
    confirmQuery($create_user_query);
    $the_user_id = mysqli_insert_id($connection);
    echo "<p class='bg-success'>User Successfully Created. <a href='users.php'>View All Users.</a></p>";
}
?>
        <form action="" method="post" enctype="multipart/form-data">    
            <div class="form-group">
                <label for="title">First Name</label>
                <input type="text" class="form-control" name="user_firstname">
            </div>
            
            <div class="form-group">
                <label for="post_status">Lastname</label>
                <input type="text" class="form-control" name="user_lastname">
            </div>
            
            <div class="form-group">
                <label for="role">Role</label>
                <select name="user_role" id="">
                    <option value="Subscriber">Select Role</option>
                    <option value="Admin">Admin</option>
                    <option value="Subscriber">Subscriber</option>
                </select>
            </div>
<!--
            <div class="form-group">
                <label for="post_image">Post Image</label>
                <input type="file"  name="image">
            </div>
-->

            <div class="form-group">
                <label for="post_tags">Username</label>
                <input type="text" class="form-control" name="username">
            </div>
      
            <div class="form-group">
                <label for="post_content">E-Mail</label>
                <input type="email" class="form-control" name="user_email">
            </div>
            
            <div class="form-group">
                <label for="post_content">Password</label>
                <input type="password" class="form-control" name="user_password">
            </div>
            
            <div class="form-group">
                <input class="btn btn-primary" type="submit" name="create_user" value="Add User">
            </div>
            
        </form>
    