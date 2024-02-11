<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Playlist</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

   
<?php
include '../components/admin_header.php';

if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('location:dashboard.php');
}

if(isset($_POST['submit'])){

   $title = $_POST['title'];
   $title = filter_var($title, FILTER_SANITIZE_STRING);
   $description = $_POST['description'];
   $description = filter_var($description, FILTER_SANITIZE_STRING);
   $status = $_POST['status'];
   $status = filter_var($status, FILTER_SANITIZE_STRING);

   $update_course = pg_prepare($conn, "update_course_query", "UPDATE courses SET title = $1, description = $2, status = $3 WHERE course_id = $4");
   pg_execute($conn, "update_course_query", array($title, $description, $status, $get_id));

   $old_image = $_POST['old_image'];
   $old_image = filter_var($old_image, FILTER_SANITIZE_STRING);
   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = unique_id().'.'.$ext;
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_files/'.$rename;

   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $update_image = pg_prepare($conn, "update_image_query", "UPDATE courses SET thumb = $1 WHERE course_id = $2");
         pg_execute($conn, "update_image_query", array($rename, $get_id));
         move_uploaded_file($image_tmp_name, $image_folder);
         if($old_image != '' AND $old_image != $rename){
            unlink('../uploaded_files/'.$old_image);
         }
      }
   } 

   $message[] = 'Course updated!';  

}

if(isset($_POST['delete'])){
   $delete_id = $_POST['course_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
   
   // Fetch the course thumb to delete
   $delete_course_thumb = pg_prepare($conn, "delete_course_thumb_query", "SELECT thumbnail FROM courses WHERE course_id = $1 LIMIT 1");
   $delete_course_thumb_result = pg_execute($conn, "delete_course_thumb_query", array($delete_id));
   $fetch_thumb = pg_fetch_assoc($delete_course_thumb_result);
   unlink('../uploaded_files/'.$fetch_thumb['thumb']);
   
   // Delete associated bookmarks
   $delete_bookmark = pg_prepare($conn, "delete_bookmark_query", "DELETE FROM bookmarks WHERE course_id = $1");
   pg_execute($conn, "delete_bookmark_query", array($delete_id));
   
   // Delete the course
   $delete_course = pg_prepare($conn, "delete_course_query", "DELETE FROM courses WHERE course_id = $1");
   pg_execute($conn, "delete_course_query", array($delete_id));
   
   header('location:playlists.php');
}

?>


<section class="playlist-form">

   <h1 class="heading">update course</h1>

   <?php
      $select_course = pg_prepare($conn, "select_course_query", "SELECT * FROM courses WHERE course_id = $1");
      $select_course_result = pg_execute($conn, "select_course_query", array($get_id));

      if (pg_num_rows($select_course_result) > 0) {
         while ($fetch_course = pg_fetch_assoc($select_course_result)) {
            $course_id = $fetch_course['course_id'];
            
            $count_videos = pg_prepare($conn, "count_videos_query", "SELECT * FROM content WHERE course_id = $1");
            pg_execute($conn, "count_videos_query", array($course_id));
            $count_videos_result = pg_execute($conn, "count_videos_query", array($course_id));
            $total_videos = pg_num_rows($count_videos);
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="old_image" value="<?= $fetch_course['thumbnail']; ?>">
      <p>Status <span>*</span></p>
      <select name="status" class="box" required>
         <option value="<?= $fetch_course['status']; ?>" selected><?= $fetch_course['status']; ?></option>
         <option value="Active">Active</option>
         <option value="Inactive">Inactive</option>
      </select>
      <p>Title <span>*</span></p>
      <input type="text" name="title" maxlength="100" required placeholder="enter course title" value="<?= $fetch_course['title']; ?>" class="box">
      <p>Description <span>*</span></p>
      <textarea name="description" class="box" required placeholder="write description" maxlength="1000" cols="30" rows="10"><?= $fetch_course['description']; ?></textarea>
      <p>Thumbnail <span>*</span></p>
      <div class="thumb">
         <span><?= $total_videos; ?></span>
         <img src="../uploaded_files/<?= $fetch_course['thumbnail']; ?>" alt="">
      </div>
      <input type="file" name="image" accept="image/*" class="box">
      <input type="submit" value="update course" name="submit" class="btn">
      <div class="flex-btn">
         <input type="submit" value="delete" class="delete-btn" onclick="return confirm('delete this course?');" name="delete">
         <a href="view_playlist.php?get_id=<?= $course_id; ?>" class="option-btn">view course</a>
      </div>
   </form>
   <?php
      } 
   }else{
      echo '<p class="empty">No course added yet!</p>';
   }
   ?>

</section>


<script src="../js/admin_script.js"></script>

</body>
</html>