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
                        $the_author_id = $_GET['author'];
                    }
                    $query = "select * from posts where post_user = '{$the_author_id}'";
                    $select_post_query = mysqli_query($connection, $query);
                    
                    if(!$select_post_query) {
                        die('Query FAILED' . mysqli_error($select_post_query));
                    }
                    
                    while($row = mysqli_fetch_assoc($select_post_query)) {
                        $post_title = $row['post_title'];
                        $post_user = $row['post_user'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                    ?>                    
                    <!-- First Blog Post-->
                    <h2>
                        <a href="#"><?php echo $post_title ?></a>
                    </h2>
                    <p class="lead">by
                        <a href="author_posts.php?author=<?php echo $post_author ?>"><?php echo $post_author ?></a>
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
                </div>
                
                <!-- Blog Sidebar Widgets Column -->
                <?php include "includes/sidebar.php"; ?>
                
            </div>
            <!-- /.row -->
            
        <hr>
<?php include "includes/footer.php"; ?>