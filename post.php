<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
        <!-- Navigation -->
        <?php include "includes/navigation.php"; ?>
        <!-- Page Content -->
        <div class="container">
            <div class="row">
                <!-- Blog Entries Column-->
                <div class="col-md-8">
                    
                    <?php
                    if(isset($_GET['p_id'])) {
                        $the_post_id = $_GET['p_id'];
                        $view_query = "update posts set post_view_count = post_view_count + 1 where post_id = $the_post_id";
                        $send_query= mysqli_query($connection, $view_query);
                        if(!$send_query) {
                            die('Query Failed. ' . mysqli_error($connection));
                        }
                        
                        if($_SESSION['user_role'] && $_SESSION['user_role'] == 'Admin') {
                            $query = "select * from posts where post_id = $the_post_id";
                        } else {
                            $query = "select * from posts where post_id = $the_post_id and post_status = 'Published'";
                        }
                        $select_post_query = mysqli_query($connection, $query);
                        
                        if(mysqli_num_rows($select_post_query) < 1) {
                            echo "<h1 class='text-center'>There is no post here.</h1>";
                        } else {
                            
                            if(!$select_post_query) {
                                die('Query FAILED' . mysqli_error($select_post_query));
                            }
                            while($row = mysqli_fetch_assoc($select_post_query)) {
                                $post_title = $row['post_title'];
                                $post_author = $row['post_author'];
                                $post_date = $row['post_date'];
                                $post_image = $row['post_image'];
                                $post_content = $row['post_content'];
                            ?>
                            <!-- First Blog Post-->
                            <h2>
                                <?php echo $post_title ?>
                            </h2>
                            <p class="lead">by
                                <a href="index.php"><?php echo $post_author ?></a>
                            </p>
                            <p>
                                <span class="glyphicon glyphicon-time"></span>Posted on <?php echo $post_date ?>
                            </p>
                            <hr>
                            <img class="img-responsive" src="images/<?php echo $post_image;?>" alt="">
                            <hr>
                            <p><?php echo $post_content ?></p>                    
                            <hr>
                            <?php
                            }
                            ?>
                            <!-- Comments Form -->
                            <?php
                            if(isset($_POST['create_comment'])) {
                                $the_post_id = $_GET['p_id'];
                                $comment_author = $_POST['comment_author'];
                                $comment_email = $_POST['comment_email'];
                                $comment_content = $_POST['comment_content'];
                                if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                                    $query = "insert into comments(comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date)";
                                    $query .= "values($the_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now())";

                                    $create_comment_query = mysqli_query($connection, $query);

                                    if(!$create_comment_query) {
                                        die('Query FAILED.' . mysqli_error($connection));
                                    }
                                    $query = "update posts set post_comment_count = post_comment_count + 1 ";
                                    $query .= "where post_id = $the_post_id ";
                                    $increament_comment_count = mysqli_query($connection, $query);

                                    if(!$increament_comment_count) {
                                        die('Query FAILED.' . mysqli_error($connection));
                                    }
                                } else {
                                    echo "<script>alert('Fields cannot be empty.')</script>";
                                }
                            }
                            ?>
                            <div class="well">
                                <h4>Leave a Comment:</h4>
                                <form action="#" method="post" role="form">

                                    <div class="form-group">
                                        <label for="Author">Author</label>
                                        <input type="text" name="comment_author" class="form-control" name="comment_author">
                                    </div>

                                    <div class="form-group">
                                        <label for="Author">Email</label>
                                        <input type="email" name="comment_email" class="form-control" name="comment_email">
                                    </div>

                                    <div class="form-group">
                                        <label for="comment">Your Comment</label>
                                        <textarea name="comment_content" class="form-control" rows="3"></textarea>
                                    </div>

                                    <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                                </form>
                            </div>

                            <hr>

                            <!-- Posted Comments -->
                            <?php
                            $query = "select * from comments where comment_post_id = $the_post_id ";
                            $query .= "and comment_status = 'Approved' ";
                            $query .= "order by comment_id desc";

                            $select_comment_query = mysqli_query($connection, $query);
                            if(!$select_comment_query) {
                                die('Qıery FAILED' . mysqli_error($connection));
                            }
                            while($row = mysqli_fetch_array($select_comment_query)) {
                                $comment_date = $row['comment_date'];
                                $comment_content = $row['comment_content'];
                                $comment_author = $row['comment_author'];
                            ?>
                            <!-- Comment -->
                            <div class="media">
                                <a href="#" class="pull-left">
                                    <img src="http://placehold.it/64x64" alt="" class="media-object">
                                </a>
                                <div class="media-body">
                                    <h4 class="media-heading"><?php echo $comment_author;?>
                                        <small><?php echo $comment_date;?></small>
                                    </h4><?php echo $comment_content; ?>
                                </div>
                            </div>
                            <?php
                            }
                        } 
                    } else {
                        header("Location: index.php");
                    }
                    ?>
                </div>
                
                <!-- Blog Sidebar Widgets Column -->
                <?php include "includes/sidebar.php"; ?>
                
            </div>
            <!-- /.row -->
            
        <hr>
<?php include "includes/footer.php"; ?>