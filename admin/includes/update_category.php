                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="cat-title">Edit Category </label>
                                    <?php 
                                    
                                    if(isset($_GET['edit'])) {
                                        $cat_id = $_GET['edit'];
                                        $query = "SELECT * FROM categories WHERE cat_id = $cat_id";
                                        $send = mysqli_query($connection, $query);
                                        confirmQuery($send);
                                        while($row = mysqli_fetch_assoc($send)) {
                                            $cat_id = $row['cat_id'];
                                            $cat_title = $row['cat_title'];
                                    ?>
                                    <input type="text" value="<?php if(isset($cat_title)){echo $cat_title;} ?>" class="form-control" name="cat_title">
                                    <?php
                                        }
                                    }
                                    ?>
                                    <?php
                                    //Update category
                                    
                                    if(isset($_POST['update_Category'])) {
                                        $cat_title = escape($_POST['cat_title']);
                                        $stmt = mysqli_prepare($connection, "UPDATE categories SET cat_title = ? WHERE cat_id = ? ");
                                        echo "asd";
                                        confirmQuery($stmt);
                                        echo "asd";                                        
                                        mysqli_stmt_bind_param($stmt, "si", $cat_title, $cat_id);
                                        mysqli_stmt_execute($stmt);
                                        mysqli_stmt_close($stmt);
                                        header("Location: categories.php");
                                    }
                                    ?>
                                </div>
                                <div class="form-group">
                                    <input  class="btn btn-primary" type="submit" name="update_Category" value="Update Category">
                                </div>
                            </form>