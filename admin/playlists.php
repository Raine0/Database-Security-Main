<?php
include '../components/admin_header.php';

if(isset($_POST['delete'])){
   $delete_id = $_POST['course_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   // Verify if the course exists and belongs to the current tutor
   $verify_course = pg_prepare($conn, "verify_course_query", "SELECT * FROM courses WHERE course_id = $1 AND tutor_id = $2 LIMIT 1");
   $verify_course_result = pg_execute($conn, "verify_course_query", array($delete_id, $tutor_id));
 
   if(pg_num_rows($verify_course_result) > 0){
      // Fetch course thumbnail to delete
      $delete_course_thumb = pg_prepare($conn, "delete_course_thumb_query", "SELECT * FROM courses WHERE course_id = $1 LIMIT 1");
      $delete_course_thumb_result = pg_execute($conn, "delete_course_thumb_query", array($delete_id));
      $fetch_thumb = pg_fetch_assoc($delete_course_thumb_result);
      unlink('../uploaded_files/'.$fetch_thumb['thumb']);
      
      // Delete associated bookmarks
      $delete_bookmark = pg_prepare($conn, "delete_bookmark_query", "DELETE FROM bookmark WHERE course_id = $1");
      pg_execute($conn, "delete_bookmark_query", array($delete_id));
      
      // Delete the course
      $delete_course = pg_prepare($conn, "delete_course_query", "DELETE FROM courses WHERE course_id = $1");
      pg_execute($conn, "delete_course_query", array($delete_id));

      $message[] = 'Course deleted!';
   } else {
      $message[] = 'Course already deleted!';
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Courses</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>


<section class="playlists">

   <h1 class="heading">Added Courses</h1>

   <div class="box-container">
   
      <!-- <div class="box" style="text-align: center;">
         <h3 class="title" style="margin-bottom: .5rem;">Create New Course</h3>
         <a href="add_playlist.php" class="btn">add Course</a>
      </div> -->

      <?php
         $select_course = pg_prepare($conn, "select_course_query", "SELECT * FROM courses WHERE tutor_id = $1 ORDER BY date DESC");
         $select_course_result = pg_execute($conn, "select_course_query", array($tutor_id));
         if (pg_num_rows($select_course_result) > 0) {
            while ($fetch_course = pg_fetch_assoc($select_course_result)) {
                $course_id = $fetch_course['course_id'];
        
                // Counting videos
                $count_videos = pg_prepare($conn, "count_videos_query", "SELECT COUNT(*) FROM content WHERE course_id = $1");
                $count_videos_result = pg_execute($conn, "count_videos_query", array($course_id));
                $total_videos = pg_fetch_result($count_videos_result, 0, 0);
      ?>
      <div class="box">
         <div class="flex">
            <div><i class="fas fa-circle-dot" style="<?php if($fetch_course['status'] == 'active'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"></i><span style="<?php if($fetch_course['status'] == 'active'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"><?= $fetch_course['status']; ?></span></div>
            <div><i class="fas fa-calendar"></i><span><?= $fetch_course['date']; ?></span></div>
         </div>
         <div class="thumb">
            <span><?= $total_videos; ?></span>
            <img src="../uploaded_files/<?= $fetch_course['thumbnail']; ?>" alt="">
         </div>
         <h3 class="title"><?= $fetch_course['title']; ?></h3>
         <p class="description"><?= $fetch_course['description']; ?></p>
         <form action="" method="post" class="flex-btn">
            <input type="hidden" name="playlist_id" value="<?= $course_id; ?>">
            <a href="update_playlist.php?get_id=<?= $course_id; ?>" class="option-btn">update</a>
            <input type="submit" value="delete" class="delete-btn" onclick="return confirm('delete this playlist?');" name="delete">
         </form>
         <a href="view_playlist.php?get_id=<?= $course_id; ?>" class="btn">view playlist</a>
      </div>
      <?php
         } 
      }else{
         echo '<p class="empty">No courses added yet!</p>';
      }
      ?>

   </div>

</section>


<script src="../js/admin_script.js"></script>

<script>
   document.querySelectorAll('.playlists .box-container .box .description').forEach(content => {
      if(content.innerHTML.length > 100) content.innerHTML = content.innerHTML.slice(0, 100);
   });
</script>

</body>
</html>