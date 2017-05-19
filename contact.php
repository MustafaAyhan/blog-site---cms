<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php
// the message



$to = "usah_mustafa@hotmail.com";

// send email
//mail("mustafa.ayhan95@gmail.com", "My subject" ,$msg);

if(isset($_POST['submit'])) {
    $subject = wordwrap($_POST['subject'], 70);
    $body = $_POST['body'];
    $headers =  'MIME-Version: 1.0' . "\r\n"; 
    $headers .= "From: M.Ayhan <". $_POST['email'] . "> \r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
    
    mail($to, $subject, $body, $headers);
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
                        <h1>Contact</h1>
                            <form role="form" action="contact.php" method="post" id="login-form" autocomplete="off">
                                            
                                <div class="form-group">
                                    <label for="email" class="sr-only">Email</label>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter your E-mail">
                                </div>
                                
                                <div class="form-group">
                                    <label for="subject" class="sr-only">Subject</label>
                                    <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter your subject">
                                </div>
                                
                                 <div class="form-group">
                                    <textarea name="body" class="form-control" cols="10" rows="10" id=""></textarea>
                                </div>

                                <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Send">
                            </form>

                        </div>
                    </div> <!-- /.col-xs-12 -->
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </section>
        <hr>
<?php include "includes/footer.php";?>
