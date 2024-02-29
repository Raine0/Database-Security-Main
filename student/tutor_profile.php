<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>tutor's profile</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>

<?php

include '../components/user_header.php';

if(isset($_POST['tutor_fetch'])) {
   $tutor_email = $_POST['tutor_email'];
   $tutor_email = filter_var($tutor_email, FILTER_SANITIZE_STRING);
   
   $select_tutor = pg_prepare($conn, "select_tutor_query", "SELECT * FROM tutors WHERE email = $1");
   $select_tutor_result = pg_execute($conn, "select_tutor_query", array($tutor_email));
   
   $fetch_tutor = pg_fetch_assoc($select_tutor_result);
   $tutor_id = $fetch_tutor['tutor_id'];

   $count_courses = pg_prepare($conn, "count_courses_query", "SELECT * FROM courses WHERE tutor_id = $1");
   $count_courses_result = pg_execute($conn, "count_courses_query", array($tutor_id));
   $total_courses = pg_num_rows($count_courses_result);

   $count_contents = pg_prepare($conn, "count_contents_query", "SELECT * FROM content WHERE tutor_id = $1");
   $count_contents_result = pg_execute($conn, "count_contents_query", array($tutor_id));
   $total_contents = pg_num_rows($count_contents_result);

   $count_likes = pg_prepare($conn, "count_likes_query", "SELECT * FROM likes WHERE tutor_id = $1");
   $count_likes_result = pg_execute($conn, "count_likes_query", array($tutor_id));
   $total_likes = pg_num_rows($count_likes_result);

   $count_comments = pg_prepare($conn, "count_comments_query", "SELECT * FROM comments WHERE tutor_id = $1");
   $count_comments_result = pg_execute($conn, "count_comments_query", array($tutor_id));
   $total_comments = pg_num_rows($count_comments_result);
} else {
   header('location:tutors.php');
}


?>


<!-- teachers profile section starts  -->

<section class="tutor-profile">

   <h1 class="heading">Profile Details</h1>

   <div class="details">
      <div class="tutor">
         <img src="../uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
         <h3><?= $fetch_tutor['name']; ?></h3>
         <span><?= $fetch_tutor['profession']; ?></span>
      </div>
      <div class="flex">
         <p>Courses: <span><?= $total_courses; ?></span></p>
         <p>Videos: <span><?= $total_contents; ?></span></p>
         <p>Likes : <span><?= $total_likes; ?></span></p>
         <p>Comments : <span><?= $total_comments; ?></span></p>
      </div>
   </div>

</section>

<!-- teachers profile section ends -->

<section class="courses">

   <h1 class="heading">Latest Courses</h1>

   <div class="box-container">

      <?php
         $select_courses = pg_prepare($conn, "select_courses_query", "SELECT * FROM courses WHERE tutor_id = $1 AND status = $2");
         $select_courses_result = pg_execute($conn, "select_courses_query", array($tutor_id, 'Active'));

         $select_tutor = pg_prepare($conn, "select_tutor_query1", "SELECT * FROM tutors WHERE tutor_id = $1");
         if(pg_num_rows($select_courses_result) > 0) {
            while($fetch_course = pg_fetch_assoc($select_courses_result)) {
               $course_id = $fetch_course['course_id'];

               $select_tutor_result = pg_execute($conn, "select_tutor_query1", array($fetch_course['tutor_id']));
               $fetch_tutor = pg_fetch_assoc($select_tutor_result);
      ?>
      <div class="box">
         <div class="tutor">
            <img src="../uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_tutor['name']; ?></h3>
               <span><?= $fetch_course['date']; ?></span>
            </div>
         </div>
         <img src="../uploaded_files/<?= $fetch_course['thumbnail']; ?>" class="thumb" alt="">
         <h3 class="title"><?= $fetch_course['title']; ?></h3>
         <a href="course.php?get_id=<?= $course_id; ?>" class="inline-btn">View Course</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">No courses added yet.</p>';
      }
      ?>

   </div>

</section>

<!-- courses section ends -->


<!-- custom js file link  -->
<script src="../js/script.js"></script>
   
</body>
</html>