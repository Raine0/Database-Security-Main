<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>


<?php
include '../components/admin_header.php';

if(isset($_POST['submit'])){

   $id = unique_id();
   $status = $_POST['status'];
   $status = filter_var($status, FILTER_SANITIZE_STRING);
   $title = $_POST['title'];
   $title = filter_var($title, FILTER_SANITIZE_STRING);
   $description = $_POST['description'];
   $description = filter_var($description, FILTER_SANITIZE_STRING);
   $course = $_POST['course'];
   $course = filter_var($course, FILTER_SANITIZE_STRING);

   $thumb = $_FILES['thumb']['name'];
   $thumb = filter_var($thumb, FILTER_SANITIZE_STRING);
   $thumb_ext = pathinfo($thumb, PATHINFO_EXTENSION);
   $rename_thumb = unique_id().'.'.$thumb_ext;
   $thumb_size = $_FILES['thumb']['size'];
   $thumb_tmp_name = $_FILES['thumb']['tmp_name'];
   $thumb_folder = '../uploaded_files/'.$rename_thumb;

   $video = $_FILES['video']['name'];
   $video = filter_var($video, FILTER_SANITIZE_STRING);
   $video_ext = pathinfo($video, PATHINFO_EXTENSION);
   $rename_video = unique_id().'.'.$video_ext;
   $video_tmp_name = $_FILES['video']['tmp_name'];
   $video_folder = '../uploaded_files/'.$rename_video;

   if ($thumb_size > 2000000) {
      $message[] = 'image size is too large!';
   } else {
      $add_content = pg_prepare($conn, "add_content_query", "INSERT INTO content(content_id, tutor_id, course_id, title, description, video, thumbnail, status) VALUES($1, $2, $3, $4, $5, $6, $7, $8)");
      pg_execute($conn, "add_content_query", array($id, $tutor_id, $course, $title, $description, $rename_video, $rename_thumb, $status));
      move_uploaded_file($thumb_tmp_name, $thumb_folder);
      move_uploaded_file($video_tmp_name, $video_folder);
      $message[] = 'New course uploaded!';
   }
   header('location:playlists.php');
}
?>


<section class="video-form">

   <h1 class="heading">Upload Content</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <p>Status <span>*</span></p>
      <select name="status" class="box" required>
         <option value="" selected disabled>Select Status</option>
         <option value="Active">Active</option>
         <option value="Inactive">Inactive</option>
      </select>
      <p>Title <span>*</span></p>
      <input type="text" name="title" maxlength="100" required placeholder="Enter title" class="box">
      <p>Description <span>*</span></p>
      <textarea name="description" class="box" required placeholder="Write description" maxlength="1000" cols="30" rows="10"></textarea>
      <p>Playlist <span>*</span></p>
      <select name="course" class="box" required>
         <option value="" disabled selected>Select Course</option>
         <?php
         $select_courses = pg_prepare($conn, "select_courses_query", "SELECT * FROM courses WHERE tutor_id = $1");
         $select_courses_result = pg_execute($conn, "select_courses_query", array($tutor_id));
         if (pg_num_rows($select_courses_result) > 0) {
             while ($fetch_course = pg_fetch_assoc($select_courses_result)) {
         ?>
         <option value="<?= $fetch_course['course_id']; ?>"><?= $fetch_course['title']; ?></option>
         <?php
             }
         ?>
         <?php
         } else {
             echo '<option value="" disabled>No courses created yet!</option>';
         }
         ?>
      </select>
      <p>Select Thumbnail <span>*</span></p>
      <input type="file" name="thumb" accept="image/*" required class="box">
      <p>Upload Video <span>*</span></p>
      <input type="file" name="video" accept="video/*" required class="box">
      <input type="submit" value="upload video" name="submit" class="btn">
   </form>

</section>


<script src="../js/admin_script.js"></script>

</body>
</html>