<?php
if(isset($_GET['p_id'])) {
    $the_post_id = $_GET['p_id'];
}
$query = "select * from posts where post_id = $the_post_id";
$select_post_by_id = mysqli_query($connection, $query);

confirmQuery($select_post_by_id);

while($row = mysqli_fetch_assoc($select_post_by_id)) {
    $post_id = $row['post_id'];
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

if(isset($_POST['update_post'])) {
    $post_title = $_POST['title'];
    $post_user = $_POST['post_user'];
    $post_category_id = $_POST['post_category'];
    $post_status = $_POST['post_status'];
    
    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];
    
    $post_tags = $_POST['post_tags'];
    $post_content = $_POST['post_content'];
    $post_content = escape($post_content);
    
    move_uploaded_file($post_image_temp, "../images/$post_image");
    
    if(empty($post_image)) {
        $query = "select * from posts where post_id = $the_post_id";
        $select_image = mysqli_query($connection, $query);
        
        while($row = mysqli_fetch_array($select_image)) {
            $post_image = $row['post_image'];
        }
    }
    
    $query = "UPDATE posts SET ";
    $query .="post_title  = '{$post_title}', ";
    $query .="post_user  = '{$post_user}', ";
    $query .="post_category_id = '{$post_category_id}', ";
    $query .="post_date   =  now(), ";
    $query .="post_status = '{$post_status}', ";
    $query .="post_tags   = '{$post_tags}', ";
    $query .="post_content = '{$post_content}', ";
    $query .="post_image  = '{$post_image}' ";
    $query .= "WHERE post_id = {$the_post_id} ";
    
    $update_post = mysqli_query($connection, $query);
    
    confirmQuery($update_post);
    
    echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id={$the_post_id}'>View Post</a> or <a href='posts.php'>Edit More Posts</a></p>";
}
?>
        <form action="" method="post" enctype="multipart/form-data">    
            <!-- Title -->
            <div class="form-group">
                <label for="title">Post Title</label>
                <input value="<?php echo $post_title; ?>" type="text" class="form-control" name="title">
            </div><!-- ./Title -->
            <!-- Category -->
            <div class="form-group">
                <label for="title">Post Category</label>
                <select name="post_category" id="">
                    <?php
                    $query = "select * from categories";
                    $select_categories = mysqli_query($connection, $query);

                    confirmQuery($select_categories);
                    while($row = mysqli_fetch_assoc($select_categories)) {
                        $cat_id = $row['cat_id'];
                        $cat_title = $row['cat_title'];
                        if($cat_id == $post_category_id) {
                            echo "<option selected value='$cat_id'>$cat_title</option>";
                        } else {
                            echo "<option value='$cat_id'>$cat_title</option>";
                        }
                    }
                    ?>
                </select>
            </div><!-- ./Category -->
            <!-- User -->
            <div class="form-group">
                <label for="users">Users</label>
                <select name="post_user" id="">
                <?php
                $user_query = "SELECT * FROM users";
                $select_users = mysqli_query($connection,$user_query);
                confirmQuery($select_users);
                    
                while($row = mysqli_fetch_assoc($select_users)) {
                    $user_id = $row['user_id'];
                    $username = $row['username'];
                    if($username == $post_user) {
                        echo "<option selected value='$username'>{$username}</option>";  
                    } else {
                        echo "<option value='$username'>{$username}</option>";
                    }
                        
                }
                ?>
                </select>
            </div><!-- ./User -->
            <!-- Status -->
            <div class="form-group">
                <label for="post_status">Post Status</label>
                <select name="post_status" id="">
                    <option value="<?php echo $post_status;?>"><?php echo $post_status;?></option>
                    <?php
                    if($post_status == 'Published') {
                        echo "<option value='Draft'>Draft</option>";
                    } else {
                        echo "<option value='Published'>Published</option>";
                    }
                    ?>
                </select>
            </div><!-- ./Status -->
            <!-- Image -->
            <div class="form-group">
                <img src="../images/<?php echo $post_image;?>" alt="" width="100">
                <input type="file"  name="image">
            </div><!-- ./Image -->
            <!-- Tags -->
            <div class="form-group">
                <label for="post_tags">Post Tags</label>
                <input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags">
            </div><!-- ./Tags -->
            <!-- Content -->
            <div class="form-group">
                <label for="post_content">Post Content</label>
                <textarea class="form-control" name="post_content" id="" cols="30" rows="10">
                <?php echo str_replace('\r\n','</br>',$post_content); ?>
                </textarea>
            </div><!-- ./Content -->
            
            <div class="form-group">
                <input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
            </div>
            
        </form>