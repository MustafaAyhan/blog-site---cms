<?php include "includes/admin_header.php"; ?>
        <div id="wrapper">
            <!-- Navigation -->
            <?php include "includes/admin_navigation.php"; ?>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">
                                Welcome To Admin Panel
                                <small><?php echo " " . $_SESSION['username']; ?></small>
                            </h1>
                        </div>
                    </div>
                    <!-- /.row -->
                    
                    <div class="row">
                        <!-- Post square-->
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-primary">
                               
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-file-text fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                             <div class='huge'><?php echo $post_count = recordCount('posts'); ?></div>
                                            <div>Posts</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <a href="posts.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                                
                            </div>
                        </div><!-- ./Post square-->
                        <!-- Comment square-->
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-green">
                               
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-comments fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class='huge'><?php echo $comment_count = recordCount('comments'); ?></div>
                                            <div>Comments</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <a href="comments.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                                
                            </div>
                        </div><!-- ./Comment square-->
                        <!-- User square-->
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-yellow">
                               
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-user fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class='huge'><?php echo $user_count = recordCount('users'); ?></div>
                                            <div> Users</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <a href="users.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                                
                            </div>
                        </div><!-- ./User square-->
                        <!-- Category square-->
                        <div class="col-lg-3 col-md-6">
                            <div class="panel panel-red">
                               
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <i class="fa fa-list fa-5x"></i>
                                        </div>
                                        <div class="col-xs-9 text-right">
                                            <div class='huge'><?php echo $category_count = recordCount('categories'); ?></div>
                                            <div>Categories</div>
                                        </div>
                                    </div>
                                </div>
                                
                                <a href="categories.php">
                                    <div class="panel-footer">
                                        <span class="pull-left">View Details</span>
                                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                        <div class="clearfix"></div>
                                    </div>
                                </a>
                                
                            </div>
                        </div><!-- ./Category square-->
                    </div>
                    <!-- /.row -->
                    <?php
                    $post_published_count = checkStatus('posts', 'post_status', 'Published');
                    $post_draft_count = checkStatus('posts', 'post_status', 'Draft');
                    $unappraoved_comment_count = checkStatus('comments', 'comment_status', 'Unapproved');
                    $subscriber_sount = checkStatus('users', 'user_role', 'Subscriber');
                    ?>
                    <?php include "includes/bar_chart.php";?>  
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.page-wrapper -->
<?php include "includes/admin_footer.php"; ?>