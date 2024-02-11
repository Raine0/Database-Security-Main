<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Course</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

   <link rel="icon" type="image/x-icon" href="../images/favicon.ico">
</head>
<body>


<?php
include '../components/user_header.php';

if(isset($_GET['get_id'])){
   $get_id = $_GET['get_id'];
}else{
   $get_id = '';
   header('location:home.php');
}

if(isset($_POST['save_list'])){
   if($user_id != ''){
       $list_id = $_POST['list_id'];
       $list_id = filter_var($list_id, FILTER_SANITIZE_STRING);

       $select_list = pg_prepare($conn, "select_list_query", "SELECT * FROM bookmarks WHERE student_id = $1 AND course_id = $2");
       $select_list_result = pg_execute($conn, "select_list_query", array($student_id, $list_id));

       if(pg_num_rows($select_list_result) > 0){
           $remove_bookmark = pg_prepare($conn, "remove_bookmark_query", "DELETE FROM bookmarks WHERE student_id = $1 AND course_id = $2");
           pg_execute($conn, "remove_bookmark_query", array($student_id, $list_id));
           $message[] = 'Course removed!';
       }else{
           $insert_bookmark = pg_prepare($conn, "insert_bookmark_query", "INSERT INTO bookmarks(student_id, course_id) VALUES($1,$2)");
           pg_execute($conn, "insert_bookmark_query", array($student_id, $list_id));
           $message[] = 'Course saved!';
       }
   }else{
       $message[] = 'Please login first!';
   }
}
?>

<!-- playlist section starts  -->

<section class="playlist">

   <h1 class="heading">playlist details</h1>

   <div class="row">

      <?php
         // $select_playlist = $conn->prepare("SELECT * FROM `playlist` WHERE id = ? and status = ? LIMIT 1");
         // $select_playlist->execute([$get_id, 'active']);
         // if($select_playlist->rowCount() > 0){
         //    $fetch_playlist = $select_playlist->fetch(PDO::FETCH_ASSOC);

         //    $playlist_id = $fetch_playlist['id'];

         //    $count_videos = $conn->prepare("SELECT * FROM `content` WHERE playlist_id = ?");
         //    $count_videos->execute([$playlist_id]);
         //    $total_videos = $count_videos->rowCount();

         //    $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ? LIMIT 1");
         //    $select_tutor->execute([$fetch_playlist['tutor_id']]);
         //    $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);

         //    $select_bookmark = $conn->prepare("SELECT * FROM `bookmark` WHERE user_id = ? AND playlist_id = ?");
         //    $select_bookmark->execute([$user_id, $playlist_id]);

         $select_course = pg_prepare($conn, "select_course_query", "SELECT * FROM courses WHERE course_id = $1 AND status = $2 LIMIT 1");
         $select_course_result = pg_execute($conn, "select_course_query", array($get_id, 'Active'));
         if(pg_num_rows($select_course_result) > 0){
            $fetch_course = pg_fetch_assoc($select_course_result);

            $course_id = $fetch_course['course_id'];

            $count_videos = pg_prepare($conn, "count_videos_query", "SELECT * FROM content WHERE course_id = $1");
            $count_videos_result = pg_execute($conn, "count_videos_query", array($course_id));
            $total_videos = pg_num_rows($count_videos_result);

            $select_tutor = pg_prepare($conn, "select_tutor_query", "SELECT * FROM tutors WHERE tutor_id = $1 LIMIT 1");
            $select_tutor_result = pg_execute($conn, "select_tutor_query", array($fetch_course['tutor_id']));
            $fetch_tutor = pg_fetch_assoc($select_tutor_result);

            $select_bookmark = pg_prepare($conn, "select_bookmark_query", "SELECT * FROM bookmarks WHERE student_id = $1 AND course_id = $2");
            $select_bookmark_result = pg_execute($conn, "select_bookmark_query", array($student_id, $course_id));
      ?>

      <div class="col">
         <form action="" method="post" class="save-list">
            <input type="hidden" name="list_id" value="<?= $course_id; ?>">
            <?php
               if(pg_num_rows($select_bookmark_result) > 0){
            ?>
            <button type="submit" name="save_list"><i class="fas fa-bookmark"></i><span>Saved</span></button>
            <?php
               }else{
            ?>
               <button type="submit" name="save_list"><i class="far fa-bookmark"></i><span>Save Course</span></button>
            <?php
               }
            ?>
         </form>
         <div class="thumb">
            <span><?= $total_videos; ?> Videos</span>
            <img src="../uploaded_files/<?= $fetch_course['thumbnail']; ?>" alt="">
         </div>
      </div>

      <div class="col">
         <div class="tutor">
            <img src="../uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_tutor['name']; ?></h3>
               <span><?= $fetch_tutor['profession']; ?></span>
            </div>
         </div>
         <div class="details">
            <h3><?= $fetch_course['title']; ?></h3>
            <p><?= $fetch_course['description']; ?></p>
            <div class="date"><i class="fas fa-calendar"></i><span><?= $fetch_course['date']; ?></span></div>
         </div>
      </div>

      <?php
         }else{
            echo '<p class="empty">This course was not found!</p>';
         }  
      ?>

   </div>

</section>

<!-- course section ends -->

<!-- videos container section starts  -->

<section class="videos-container">
   <h1 class="heading">Course Videos</h1>
   <div class="box-container">
      <?php
         $select_content = pg_prepare($conn, "select_content_query", "SELECT * FROM content WHERE course_id = $1 AND status = $2 ORDER BY date DESC");
         $select_content_result = pg_execute($conn, "select_content_query", array($get_id, 'Active'));

         if (pg_num_rows($select_content_result) > 0) {
            while ($fetch_content = pg_fetch_assoc($select_content_result)) {  
         ?>
            <a href="watch_video.php?get_id=<?= $fetch_content['content_id']; ?>" class="box">
               <i class="fas fa-play"></i>
               <img src="../uploaded_files/<?= $fetch_content['thumbnail']; ?>" alt="">
               <h3><?= $fetch_content['title']; ?></h3>
            </a>
         <?php
            }
         } else {
            echo '<p class="empty">No videos added yet!</p>';
         }
      ?>
   </div>
</section>

<!-- videos container section ends -->


<!-- custom js file link  -->
<script src="../js/script.js"></script>
   
</body>
</html>