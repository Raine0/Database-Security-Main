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

   <link rel="icon" type="image/x-icon" href="../images/favicon.ico">
</head>
<body>


<?php
include '../components/admin_header.php';

$select_contents = pg_prepare($conn, "select_contents_query", "SELECT * FROM content WHERE tutor_id = $1");
$select_contents_result = pg_execute($conn, "select_contents_query", array($tutor_id));
$total_contents = pg_num_rows($select_contents_result);

$select_courses = pg_prepare($conn, "select_courses_query", "SELECT * FROM courses WHERE tutor_id = $1");
$select_courses_result = pg_execute($conn, "select_courses_query", array($tutor_id));
$total_courses = pg_num_rows($select_courses_result);

$select_likes = pg_prepare($conn, "select_likes_query", "SELECT * FROM likes WHERE tutor_id = $1");
$select_likes_result = pg_execute($conn, "select_likes_query", array($tutor_id));
$total_likes = pg_num_rows($select_likes_result);

$select_comments = pg_prepare($conn, "select_comments_query", "SELECT * FROM comments WHERE tutor_id = $1");
$select_comments_result = pg_execute($conn, "select_comments_query", array($tutor_id));
$total_comments = pg_num_rows($select_comments_result);

// Prepare the SELECT statement
$select_tutor = pg_prepare($conn, "select_tutor_query", "SELECT * FROM tutors WHERE tutor_id = $1");

// Execute the prepared statement
$select_tutor_result = pg_execute($conn, "select_tutor_query", array($tutor_id));

// Check if there are any rows returned
if (pg_num_rows($select_tutor_result) > 0) 
   // Fetch the tutor information as an associative array
   $fetch_tutor = pg_fetch_assoc($select_tutor_result);
   // Now you can access the tutor information using $fetch_tutor array
?>

<section class="dashboard">

   <h1 class="heading">Dashboard</h1>

   <div class="box-container">

      <div class="box">
         <h3>Welcome!</h3>
         <p><?= $fetch_tutor['name']; ?></p>
         <a href="profile.php" class="btn">view profile</a>
      </div>

      <div class="box">
         <h3><?= $total_contents; ?></h3>
         <p>Total Contents</p>
         <a href="add_content.php" class="btn">add new content</a>
      </div>

      <div class="box">
         <h3><?= $total_courses; ?></h3>
         <p>Total Courses</p>
         <a href="add_playlist.php" class="btn">add new course</a>
      </div>

      <div class="box">
         <h3><?= $total_likes; ?></h3>
         <p>Total Likes</p>
         <a href="contents.php" class="btn">view contents</a>
      </div>

      <div class="box">
         <h3><?= $total_comments; ?></h3>
         <p>Total Comments</p>
         <a href="comments.php" class="btn">view comments</a>
      </div>

      <!-- <div class="box">
         <h3>quick select</h3>
         <p>login or register</p>
         <div class="flex-btn">
            <a href="login.php" class="option-btn">login</a>
            <a href="register.php" class="option-btn">register</a>
         </div>
      </div> -->

   </div>

</section>




<script src="../js/admin_script.js"></script>

</body>
</html>