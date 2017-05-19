<?php
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
                    $post_title = $row['post_title'];
                    $post_category_id = $row['post_category_id'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_comment_count = $row['post_comment_count'];
                    $post_date = $row['post_date'];
                    $post_content = $row['post_content'];
                }
                $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) ";         
                $query .= "VALUES({$post_category_id}, '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}') "; 

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
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">Id</th>
                                <th class="text-center">Author</th>
                                <th class="text-center">Comment</th>
                                <th class="text-center">E-mail</th>
                                <th class="text-center">Post Title</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                               <?php
                                $query = "select * from comments";
                                $select_comments = mysqli_query($connection, $query);
                                
                                confirmQuery($select_comments);
                                while($row = mysqli_fetch_assoc($select_comments)) {
                                    $comment_id = $row['comment_id'];
                                    $comment_post_id = $row['comment_post_id'];
                                    $comment_author = $row['comment_author'];
                                    $comment_email = $row['comment_email'];
                                    $comment_content = $row['comment_content'];
                                    $comment_status = $row['comment_status'];
                                    $comment_date = $row['comment_date'];
                                    
                                    echo "<tr>";
                                    echo "<td>{$comment_id}</td>";
                                    echo "<td>{$comment_author}</td>";
                                    echo "<td>{$comment_content}</td>";                                    
                                    echo "<td>{$comment_email}</td>";
                                    $query = "select * from posts where post_id = $comment_post_id";
                                    $select_post_id_query = mysqli_query($connection, $query);
                                    confirmQuery($select_post_id_query);
                                    while($row = mysqli_fetch_assoc($select_post_id_query)) {
                                        $post_id = $row['post_id'];
                                        $post_title = $row['post_title'];
                                        echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
                                    }
                                    echo "<td>{$comment_date}</td>";
                                    if($comment_status == 'Approved') {
                                        echo "<td><a href='comments.php?unapprove={$comment_id}'>Approve</a></td>";
                                    } else {
                                        echo "<td><a href='comments.php?approve={$comment_id}'>Unapprove</a></td>";
                                    }                                    
                                    echo "<td><a href='comments.php?post_id={$comment_post_id}&delete={$comment_id}'>Delete</a></td>";                                    
                                    echo "</tr>";
                                }
                                ?>
                            </tr>
                        </tbody>
                    </table>
                    <?php

                    if(isset($_GET['approve'])) {
                        $the_comment_id = $_GET['approve'];
                        $query = "update comments set comment_status = 'Approved' where comment_id = {$the_comment_id} ";
                        $approve_comment_query = mysqli_query($connection, $query);
                        
                        confirmQuery($approve_comment_query);
                        header("Location: comments.php");
                    }

                    if(isset($_GET['unapprove'])) {
                        $the_comment_id = $_GET['unapprove'];
                        $query = "update comments set comment_status = 'Unapproved' where comment_id = {$the_comment_id} ";
                        $unapprove_comment_query = mysqli_query($connection, $query);
                        
                        confirmQuery($unapprove_comment_query);
                        header("Location: comments.php");
                    }

                    if(isset($_GET['delete'])) {
                        $the_comment_id = $_GET['delete'];
                        $query = "delete from comments where comment_id = {$the_comment_id} ";
                        $delete_query = mysqli_query($connection, $query);
                        
                        confirmQuery($delete_query);
                        
                        $the_post_id = $_GET['post_id'];
                        $query = "update posts set post_comment_count = post_comment_count - 1 where post_id = {$the_post_id} ";
                        $increase_comment_count = mysqli_query($connection, $query);
                        
                        confirmQuery($increase_comment_count);
                        header("Location: comments.php");
                    }
                    ?>