<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Liked Videos</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

   <link rel="icon" type="image/x-icon" href="../images/favicon.ico">
</head>
<body>

<?php

include '../components/user_header.php';


if(isset($_POST['remove'])) {
   if(!empty($user_id)) {
       $content_id = $_POST['content_id'];
       $content_id = filter_var($content_id, FILTER_SANITIZE_STRING);

       $verify_likes = pg_prepare($conn, "verify_likes_query", "SELECT * FROM likes WHERE user_id = $1 AND content_id = $2");
       $verify_likes_result = pg_execute($conn, "verify_likes_query", array($user_id, $content_id));

       if(pg_num_rows($verify_likes_result) > 0) {
           $remove_likes = pg_prepare($conn, "remove_likes_query", "DELETE FROM likes WHERE user_id = $1 AND content_id = $2");
           pg_execute($conn, "remove_likes_query", array($user_id, $content_id));
           $message[] = 'Removed from likes!';
       }
   } else {
       $message[] = 'Please login first!';
   }
}

?>


<!-- courses section starts  -->

<section class="liked-videos">

   <h1 class="heading">liked videos</h1>

   <div class="box-container">

   <?php
      $select_likes_query = pg_prepare($conn, "select_likes_query", "SELECT * FROM likes WHERE user_id = $1");
      $select_likes_result = pg_execute($conn, "select_likes_query", array($user_id));

      $select_contents_query = pg_prepare($conn, "select_contents_query", "SELECT * FROM content WHERE content_id = $1 ORDER BY date DESC");
      if(pg_num_rows($select_likes_result) > 0) {
         $select_tutors_query = pg_prepare($conn, "select_tutors_query", "SELECT * FROM tutors WHERE tutor_id = $1");
         while($fetch_likes = pg_fetch_assoc($select_likes_result)) {
            $select_contents_result = pg_execute($conn, "select_contents_query", array($fetch_likes['content_id']));

            if(pg_num_rows($select_contents_result) > 0) {
                  while($fetch_contents = pg_fetch_assoc($select_contents_result)) {
                     
                     $select_tutors_result = pg_execute($conn, "select_tutors_query", array($fetch_contents['tutor_id']));
                     $fetch_tutor = pg_fetch_assoc($select_tutors_result);
   ?>
   <div class="box">
      <div class="tutor">
         <img src="../uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
         <div>
            <h3><?= $fetch_tutor['name']; ?></h3>
            <span><?= $fetch_contents['date']; ?></span>
         </div>
      </div>
      <img src="../uploaded_files/<?= $fetch_contents['thumbnail']; ?>" alt="" class="thumb">
      <h3 class="title"><?= $fetch_contents['title']; ?></h3>
      <form action="" method="post" class="flex-btn">
         <input type="hidden" name="content_id" value="<?= $fetch_contents['content_id']; ?>">
         <a href="watch_video.php?get_id=<?= $fetch_contents['content_id']; ?>" class="inline-btn">Watch Video</a>
         <input type="submit" value="remove" class="inline-delete-btn" name="remove">
      </form>
   </div>
   <?php
            }
         }else{
            echo '<p class="emtpy">Content was not found</p>';         
         }
      }
   }else{
      echo '<p class="empty">Nothing added to likes yet</p>';
   }
   ?>

   </div>

</section>


<!-- custom js file link  -->
<script src="../js/script.js"></script>
   
</body>
</html>