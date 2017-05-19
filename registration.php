<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = escape($_POST['username']);
    $email    = escape($_POST['email']);
    $password = escape($_POST['password']);
    
    $error = ['username' => '', 'email' => '', 'password' => ''];
    
    if($username == '') {
        $error['username'] = "Username cannot be empty.";
    } elseif(strlen($username) < 3) {
        $error['username'] = "Username needs to be longer than 3 characters.";
    }  elseif(usernameExists($username)) {
        $error['username'] = "This username is taken by someone(!) else.";
    }
    
    if($email == '') {
        $error['email'] = "email cannot be empty.";
    } elseif(emailExists($email)) {
        $error['email'] = "This email is taken by someone(!) else. <a href='index.php'>Please login in.</a>'";
    }
    
    if($password == '') {
        $error['password'] = "Password cannot be empty.";
    }elseif(strlen($password) < 3) {
        $error['password'] = "Password needs to be longer than 3 characters.";
    }
    
    foreach($error as $key => $value) {
        if(empty($value)) {
            unset($error[$key]);
        }
    }
    
    if(empty($error)) {
        registerUser($username, $email, $password);
        loginUser($username, $password);
    }
}
?>
    <!-- Navigation -->
    <?php  include "includes/navigation.php"; ?>
    <!-- Page Content -->
    <div class="container"> 
        <section id="login">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-xs-offset-3">
                        <div class="form-wrap">
                        <h1>Register</h1>
                            <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                                <div class="form-group">
                                    <label for="username" class="sr-only">Username</label>
                                    <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" autocomplete="on" value="<?php echo isset($username) ? $username : '';?>">
                                    <p><?php echo isset($error['username']) ? $error['username'] : '';?></p>
                                </div>
                                 <div class="form-group">
                                    <label for="email" class="sr-only">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" autocomplete="on" value="<?php echo isset($email) ? $email : '';?>">
                                    <p><?php echo isset($error['email']) ? $error['email'] : '';?></p>                                    
                                </div>
                                 <div class="form-group">
                                    <label for="password" class="sr-only">Password</label>
                                    <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                                    <p><?php echo isset($error['password']) ? $error['password'] : '';?></p>                        
                                </div>

                                <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                            </form>

                        </div>
                    </div> <!-- /.col-xs-12 -->
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </section>
        <hr>
<?php include "includes/footer.php";?>
