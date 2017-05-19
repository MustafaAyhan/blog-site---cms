<?php include "includes/admin_header.php"; ?>
        <div id="wrapper">
            <!-- Navigation -->
            <?php include "includes/admin_navigation.php" ?>
            <div id="page-wrapper">
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="row">
                        <div class="col-lg-12">
                            <h1 class="page-header">
                                Category Control Page
                                <small><?php echo $_SESSION['username'];?></small>
                            </h1>
                            <div class="col-xs-6">
                               <?php insertCategory(); ?>
                                <form action="" method="post">
                                    <div class="form-group">
                                        <label for="cat-title">Add Category </label>
                                        <input type="text" class="form-control" name="cat_title">
                                    </div>
                                    <div class="form-group">
                                        <input  class="btn btn-primary" type="submit" name="submit" value="Add Category">
                                    </div>
                                </form><!-- Add Category Form -->

                            <?php //UPDATE AND INCLUDE QUERY
                            if(isset($_GET['edit'])) {
                                $cat_id = $_GET['edit'];
                                include "includes/update_category.php";
                            }    
                            ?>    
                            </div>
                            
                            <div class="col-xs-6">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Category Title</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <?php readCategories(); ?>
                                            <?php deleteCategories(); ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <!-- /.row -->
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->
<?php include "includes/admin_footer.php"; ?>