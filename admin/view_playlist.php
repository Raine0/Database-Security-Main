<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Course Details</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

   <link rel="icon" type="image/x-icon" href="../images/favicon.ico">
</head>
<body>

   
<?php
include '../components/admin_header.php';

if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('location:playlist.php');
}

if(isset($_POST['delete_course'])){
   $delete_id = $_POST['course_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
   $delete_course_thumb = pg_prepare($conn, "delete_course_thumb_query", "SELECT * FROM courses WHERE course_id = $1 LIMIT 1");
   pg_execute($conn, "delete_course_thumb_query", array($delete_id));
   $fetch_thumb = pg_fetch_assoc($delete_course_thumb);
   unlink('../uploaded_files/'.$fetch_thumb['thumb']);
   $delete_bookmark = pg_prepare($conn, "delete_bookmark_query", "DELETE FROM bookmarks WHERE course_id = $1");
   pg_execute($conn, "delete_bookmark_query", array($delete_id));
   $delete_course = pg_prepare($conn, "delete_course_query", "DELETE FROM courses WHERE course_id = $1");
   pg_execute($conn, "delete_course_query", array($delete_id));
   header('location:courses.php');
}


if(isset($_POST['delete_video'])){
   $delete_id = $_POST['video_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
   $verify_video = pg_prepare($conn, "verify_video_query", "SELECT * FROM content WHERE content_id = $1 LIMIT 1");
   pg_execute($conn, "verify_video_query", array($delete_id));
   if(pg_num_rows($verify_video) > 0){
      $delete_video_thumb = pg_prepare($conn, "delete_video_thumb_query", "SELECT * FROM content WHERE content_id = $1 LIMIT 1");
      pg_execute($conn, "delete_video_thumb_query", array($delete_id));
      $fetch_thumb = pg_fetch_assoc($delete_video_thumb);
      unlink('../uploaded_files/'.$fetch_thumb['thumb']);
      $delete_video = pg_prepare($conn, "delete_video_query", "DELETE FROM content WHERE content_id = $1");
      pg_execute($conn, "delete_video_query", array($delete_id));
      $fetch_video = pg_fetch_assoc($delete_video);
      unlink('../uploaded_files/'.$fetch_video['video']);
      $delete_likes = pg_prepare($conn, "delete_likes_query", "DELETE FROM likes WHERE content_id = $1");
      pg_execute($conn, "delete_likes_query", array($delete_id));
      $delete_comments = pg_prepare($conn, "delete_comments_query", "DELETE FROM comments WHERE content_id = $1");
      pg_execute($conn, "delete_comments_query", array($delete_id));
      $message[] = 'Video deleted!';
   }else{
      $message[] = 'Video already deleted!';
   }
}
?>


<section class="playlist-details">

   <h1 class="heading">Course Details</h1>

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
   <div class="row">
      <div class="thumb">
         <span><?= $total_videos; ?></span>
         <img src="../uploaded_files/<?= $fetch_course['thumbnail']; ?>" alt="">
      </div>
      <div class="details">
         <h3 class="title"><?= $fetch_course['title']; ?></h3>
         <div class="date"><i class="fas fa-calendar"></i><span><?= $fetch_course['date']; ?></span></div>
         <div class="description"><?= $fetch_course['description']; ?></div>
         <form action="" method="post" class="flex-btn">
            <input type="hidden" name="playlist_id" value="<?= $get_id; ?>">
            <a href="update_playlist.php?get_id=<?= $get_id; ?>" class="option-btn">Update Playlist</a>
            <input type="submit" value="delete playlist" class="delete-btn" onclick="return confirm('delete this playlist?');" name="delete">
         </form>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">No course found!</p>';
      }
   ?>

</section>

<section class="contents">

   <h1 class="heading">Course Videos</h1>

   <div class="box-container">

   <?php
      $select_videos = pg_prepare($conn, "select_videos_query", "SELECT * FROM content WHERE tutor_id = $1 AND course_id = $2");
      $select_videos_result = pg_execute($conn, "select_videos_query", array($tutor_id, $get_id));
/*       $select_videos_result = pg_get_result($conn); // Retrieve the result resource */

      if (pg_num_rows($select_videos_result) > 0) {
         while ($fetch_videos = pg_fetch_assoc($select_videos_result)) {
            $video_id = $fetch_videos['content_id'];
   ?>
      <div class="box">
         <div class="flex">
            <div><i class="fas fa-dot-circle" style="<?php if($fetch_videos['status'] == 'Active'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"></i><span style="<?php if($fetch_videos['status'] == 'Active'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"><?= $fetch_videos['status']; ?></span></div>
            <div><i class="fas fa-calendar"></i><span><?= $fetch_videos['date']; ?></span></div>
         </div>
         <img src="../uploaded_files/<?= $fetch_videos['thumbnail']; ?>" class="thumb" alt="">
         <h3 class="title"><?= $fetch_videos['title']; ?></h3>
         <form action="" method="post" class="flex-btn">
            <input type="hidden" name="video_id" value="<?= $video_id; ?>">
            <a href="update_content.php?get_id=<?= $video_id; ?>" class="option-btn">update</a>
            <input type="submit" value="delete" class="delete-btn" onclick="return confirm('delete this video?');" name="delete_video">
         </form>
         <a href="view_content.php?get_id=<?= $video_id; ?>" class="btn">watch video</a>
      </div>
   <?php
         }
      }else{
         echo '<p class="empty">No videos added yet! <a href="add_content.php" class="btn" style="margin-top: 1.5rem;">add videos</a></p>';
      }
   ?>

   </div>

</section>


<script src="../js/admin_script.js"></script>

</body>
</html>