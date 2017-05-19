<?php
include("delete_modal.php");
if(isset($_POST['checkBoxArray'])) {
    foreach($_POST['checkBoxArray'] as $postValueId) {
        $bulk_option = $_POST['bulk_options'];
        switch($bulk_option) {
            case 'Published':
                $query = "update posts set post_status = '{$bulk_option}' where post_id = {$postValueId} ";
                $update_to_Published_status = mysqli_query($connection, $query);
                confirmQuery($update_to_Published_status);
                break;
            case 'Draft':
                $query = "update posts set post_status = '{$bulk_option}' where post_id = {$postValueId} ";
                $update_to_Draft_status = mysqli_query($connection, $query);
                confirmQuery($update_to_Draft_status);
                break;
            case 'Clone':
                $query = "select * from posts where post_id = {$postValueId}";
                $select_post_query = mysqli_query($connection, $query);
                confirmQuery($select_post_query);
                while($row = mysqli_fetch_array($select_post_query)) {
                    $post_id = $row['post_id'];
                    $post_author = $row['post_author'];
                    $post_user = $row['post_user'];
                    $post_title = $row['post_title'];
                    $post_category_id = $row['post_category_id'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_comment_count = $row['post_comment_count'];
                    $post_date = $row['post_date'];
                    $post_content = $row['post_content'];
                    
                }
                $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_user, post_date, post_image, post_content, post_tags, post_status) ";         
                $query .= "VALUES({$post_category_id}, '{$post_title}', '{$post_author}', '{$post_user}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}') "; 

                $clone_post_query = mysqli_query($connection, $query);

                confirmQuery($clone_post_query);
                break;
            case 'Delete':
                $query = "delete from posts where post_id = {$postValueId} ";
                $delete_post_query = mysqli_query($connection, $query);
                confirmQuery($delete_post_query);
                break;
            default:
                echo "Olmadı" . "." . $bulk_option. "." . " asdad";
                break;
        }
    }
}
?>               
                <form action="" method="post">
                    <table class="table table-bordered table-hover">
                       
                        <div id="bulkOptionsContainer" class="col-xs-4">
                            <select class="form-control" name="bulk_options" id="">
                                <option value="">Select Options</option>
                                <option value="Published">Publish</option>
                                <option value="Draft">Draft</option>
                                <option value="Clone">Clone</option>
                                <option value="Delete">Delete</option>
                            </select>
                        </div>
                        
                        <div class="col-xs-4" id="option">
                            <input type="submit" name="submit" class="btn btn-success" value="Apply">
                            <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
                        </div>
                        
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="selectAllBoxes">All</th>
                                <th>Id</th>
                                <th>User</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Viewed</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th>Tags</th>
                                <th>Comments</th>
                                <th>Date</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            <tr>
                               <?php
                                $query = "select posts.post_id, posts.post_author, posts.post_user, posts.post_user, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, ";
                                $query .= "posts.post_tags, posts.post_comment_count, posts.post_date, posts.post_view_count, categories.cat_id, categories.cat_title ";
                                $query .= "from posts ";
                                $query .= "left join categories on posts.post_category_id=categories.cat_id order by posts.post_id desc";
                                $select_posts = mysqli_query($connection, $query);
                                
                                confirmQuery($select_posts);
                                while($row = mysqli_fetch_assoc($select_posts)) {
                                    $post_id            = $row['post_id'];
                                    $post_author        = $row['post_author'];
                                    $post_user          = $row['post_user'];
                                    $post_title         = $row['post_title'];
                                    $post_category_id   = $row['post_category_id'];
                                    $post_status        = $row['post_status'];
                                    $post_image         = $row['post_image'];
                                    $post_tags          = $row['post_tags'];
                                    $post_comment_count = $row['post_comment_count'];
                                    $post_date          = $row['post_date'];
                                    $post_view_count    = $row['post_view_count'];
                                    $cat_id             = $row['cat_id'];
                                    $cat_title          = $row['cat_title'];
                                    
                                    echo "<tr>";
                                    ?>
                                    <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>
                                    <?php
                                    echo "<td>{$post_id}</td>";
                                    if(!empty($post_author)) {
                                        echo "<td>{$post_author}</td>";
                                    } elseif(!empty($post_user)) {
                                        echo "<td>{$post_user}</td>";
                                    }
                                    echo "<td><a class='btn btn-default' href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";
                                    echo "<td>$cat_title</td>";
                                    echo "<td><a onClick=\"javascript:return confirm('Are you sure you want to reset view count?'); \" href='posts.php?reset={$post_id}'>{$post_view_count}</a></td>";
                                    echo "<td>{$post_status}</td>";
                                    echo "<td><img src='../images/$post_image' width='100' alt='image'></img></td>";
                                    echo "<td>{$post_tags}</td>";
                                    
                                    $query = "select * from comments where comment_post_id = $post_id";
                                    $send_comment_query = mysqli_query($connection, $query);
                                    $row = mysqli_fetch_array($send_comment_query);
                                    $comment_id = $row['comment_id'];
                                    $count_comments = mysqli_num_rows($send_comment_query);
                                    echo "<td><a href='post_comments.php?id={$post_id}'>{$count_comments}</a></td>";
                                    
                                    echo "<td>{$post_date}</td>";
                                    echo "<td><a class='btn btn-info' href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
                                    ?>
                                    <form method="post">
                                        <input type="hidden" name="post_id" value="<?php echo $post_id?>">
                                        <?php
                                            echo "<td><input class='btn btn-danger' type='submit' name='delete' value='Delete'></td>";
//                                            <a href='javascript:void(0)' rel='$post_id' class='delete_link'>Delete</a>
                                        ?>
                                    </form>
                                    <?php
                                    echo "</tr>";
                                }
                                ?>
                            </tr>
                        </tbody>
                    </table>
                </form>
                    <?php
                    if(isset($_POST['delete'])) {
                        $the_post_id = $_POST['post_id'];
                        $query = "delete from posts where post_id = {$the_post_id} ";
                        $delete_query = mysqli_query($connection, $query);
                        if($comment_count != 0) {
                            $query = "delete from comments where comment_post_id = {$the_post_id} ";
                            $delete_query = mysqli_query($connection, $query);
                            confirmQuery($delete_query);
                        }
                        confirmQuery($delete_query);
                        header("Location: /cms/admin/posts.php");
                    }
                    if(isset($_GET['reset'])) {
                        $the_post_id = $_GET['reset'];
                        $query = "update posts set post_view_count = 0 where post_id =" . mysqli_real_escape_string($connection, $_GET['reset']) . " ";
                        $reset_query = mysqli_query($connection, $query);
                        
                        confirmQuery($reset_query);
                        header("Location: /cms/admin/posts.php");
                    }
                    ?>
                    <script>
                    $(document).ready(function(){
                        $(".delete_link").on('click', function(){
                            var id = $(this).attr("rel");
                            var delete_url = "posts.php?delete=" + id + " ";
                            $(".delete_modal_link").attr("href", delete_url);
                            $("#myModal").modal('show');
                        });
                    });
                    </script>