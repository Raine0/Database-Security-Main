<?php

include '../components/admin_header.php';

// Prepare and execute query to get the total number of courses for the tutor
$select_courses = pg_prepare($conn, "select_courses_query", "SELECT * FROM courses WHERE tutor_id = $1");
pg_execute($conn, "select_courses_query", array($tutor_id));
$total_courses = pg_num_rows($select_courses);

// Prepare and execute query to get the total number of contents for the tutor
$select_contents = pg_prepare($conn, "select_contents_query", "SELECT * FROM content WHERE tutor_id = $1");
pg_execute($conn, "select_contents_query", array($tutor_id));
$total_contents = pg_num_rows($select_contents);

// Prepare and execute query to get the total number of likes for the tutor
$select_likes = pg_prepare($conn, "select_likes_query", "SELECT * FROM likes WHERE tutor_id = $1");
pg_execute($conn, "select_likes_query", array($tutor_id));
$total_likes = pg_num_rows($select_likes);

// Prepare and execute query to get the total number of comments for the tutor
$select_comments = pg_prepare($conn, "select_comments_query", "SELECT * FROM comments WHERE tutor_id = $1");
pg_execute($conn, "select_comments_query", array($tutor_id));
$total_comments = pg_num_rows($select_comments);

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Profile</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

   
<section class="tutor-profile" style="min-height: calc(100vh - 19rem);"> 

   <h1 class="heading">profile details</h1>

   <div class="details">
      <div class="tutor">
         <img src="../uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
         <h3><?= $fetch_profile['name']; ?></h3>
         <span><?= $fetch_profile['profession']; ?></span>
         <a href="update.php" class="inline-btn">update profile</a>
      </div>
      <div class="flex">
         <div class="box">
            <span><?= $total_courses; ?></span>
            <p>Total Courses</p>
            <a href="playlists.php" class="btn">view Courses</a>
         </div>
         <div class="box">
            <span><?= $total_contents; ?></span>
            <p>Total Videos</p>
            <a href="contents.php" class="btn">view contents</a>
         </div>
         <div class="box">
            <span><?= $total_likes; ?></span>
            <p>Total Likes</p>
            <a href="contents.php" class="btn">view Likes</a>
         </div>
         <div class="box">
            <span><?= $total_comments; ?></span>
            <p>Total Comments</p>
            <a href="comments.php" class="btn">view comments</a>
         </div>
      </div>
   </div>

</section>


<script src="../js/admin_script.js"></script>

</body>
</html>