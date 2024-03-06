<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Home</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

   <link rel="icon" type="image/x-icon" href="../images/favicon.ico">
</head>
<body>


<?php include '../components/user_header.php'; ?>

<?php

$select_likes = pg_prepare($conn, "select_likes_query", 'SELECT * FROM likes WHERE student_id = $1');
$select_likes_result = pg_execute($conn, "select_likes_query", array($student_id));
$total_likes = pg_num_rows($select_likes_result);

$select_comments = pg_prepare($conn, "select_comments_query", 'SELECT * FROM comments WHERE student_id = $1');
$select_comments_result = pg_execute($conn, "select_comments_query", array($student_id));
$total_comments = pg_num_rows($select_comments_result);

$select_bookmark = pg_prepare($conn, "select_bookmark_query", 'SELECT * FROM bookmarks WHERE student_id = $1');
$select_bookmark_result = pg_execute($conn, "select_bookmark_query", array($student_id));
$total_bookmarked = pg_num_rows($select_bookmark_result);

?>

<!-- quick select section starts  -->

<section class="quick-select">

   <h1 class="heading">quick options</h1>

   <div class="box-container">

      <?php
         if($user_id != ''){
      ?>
      <div class="box">
         <h3 class="title">Likes and Comments</h3>
         <p>Likes: <span><?= $total_likes; ?></span></p>
         <a href="likes.php" class="inline-btn">view likes</a>
         <p>Comments: <span><?= $total_comments; ?></span></p>
         <a href="comments.php" class="inline-btn">view comments</a>
         <p>Bookmarked Courses: <span><?= $total_bookmarked; ?></span></p>
         <a href="bookmark.php" class="inline-btn">view bookmarks</a>
      </div>
      <?php
         }else{ 
      ?>
      <!-- <div class="box" style="text-align: center;">
         <h3 class="title">Please Login or Register</h3>
          <div class="flex-btn" style="padding-top: .5rem;">
            <a href="login.php" class="option-btn">login</a>
            <a href="register.php" class="option-btn">register</a>
         </div>
      </div> -->
      <?php
      }
      ?>

      <div class="box">
         <h3 class="title">Top Categories</h3>
         <div class="flex">
            <form action="search_course.php" method="POST">
               <input type="hidden" name="search_course" value="Development">
               <button type="submit"><i class="fas fa-code"></i><span>development</span></button>
            </form>
            <a href="#"><i class="fas fa-chart-simple"></i><span>business</span></a>
            <a href="#"><i class="fas fa-pen"></i><span>design</span></a>
            <a href="#"><i class="fas fa-chart-line"></i><span>marketing</span></a>
            <a href="#"><i class="fas fa-music"></i><span>music</span></a>
            <a href="#"><i class="fas fa-camera"></i><span>photography</span></a>
            <a href="#"><i class="fas fa-cog"></i><span>software</span></a>
            <a href="#"><i class="fas fa-vial"></i><span>science</span></a>
         </div>
      </div>

      <div class="box">
         <h3 class="title">Popular Topics</h3>
         <div class="flex">
            <a href="#"><i class="fab fa-html5"></i><span>HTML</span></a>
            <a href="#"><i class="fab fa-css3"></i><span>CSS</span></a>
            <a href="#"><i class="fab fa-js"></i><span>javascript</span></a>
            <a href="#"><i class="fab fa-react"></i><span>react</span></a>
            <a href="#"><i class="fab fa-php"></i><span>PHP</span></a>
            <a href="#"><i class="fab fa-bootstrap"></i><span>bootstrap</span></a>
         </div>
      </div>

      <div class="box tutor">
         <h3 class="title">Become a Tutor</h3>
         <p>Be a tutor and teach thousands of students who want to learn online!</p>
         <a href="../admin/register.php" class="inline-btn">get started</a>
      </div>

   </div>

</section>

<!-- quick select section ends -->

<!-- courses section starts  -->

<section class="courses">

   <h1 class="heading">Latest Courses</h1>

   <div class="box-container">

      <?php
         $select_courses = pg_prepare($conn, "select_courses_query", 'SELECT * FROM courses WHERE status = $1 ORDER BY date DESC LIMIT 6');
         $select_courses_result = pg_execute($conn, "select_courses_query", array('Active'));
         
         $select_tutor = pg_prepare($conn, "select_tutor_query", 'SELECT * FROM tutors WHERE tutor_id = $1');
         if (pg_num_rows($select_courses_result) > 0) {
             while ($fetch_course = pg_fetch_assoc($select_courses_result)) {
                 $course_id = $fetch_course['course_id'];
         
                 $select_tutor_result = pg_execute($conn, "select_tutor_query", array($fetch_course['tutor_id']));
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
         echo '<p class="empty">No courses added yet!</p>';
      }
      ?>

   </div>

   <div class="more-btn">
      <a href="courses.php" class="inline-option-btn">View All Courses</a>
   </div>

</section>

<!-- courses section ends -->




<!-- custom js file link  -->
<script src="../js/script.js"></script>
   
</body>
</html>