<?php

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
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
   <link rel="stylesheet" href="css/style.css">

   <link rel="icon" type="image/x-icon" href="images/favicon.ico">
</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- courses section starts  -->

<section class="courses">

   <h1 class="heading">all courses</h1>

   <div class="box-container">

      <?php
         $select_courses = pg_prepare($conn, "select_courses_query", 'SELECT * FROM courses WHERE status = $1 ORDER BY date DESC');
         $select_courses_result = pg_execute($conn, "select_courses_query", array('active'));

         /* if($select_courses->rowCount() > 0){
            while($fetch_course = $select_courses->fetch(PDO::FETCH_ASSOC)){
               $course_id = $fetch_course['id'];

               $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
               $select_tutor->execute([$fetch_course['tutor_id']]);
               $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC); */
         
         if (pg_num_rows($select_courses_result) > 0) {
            while ($fetch_course = pg_fetch_assoc($select_courses_result)) {
                  $course_id = $fetch_course['course_id'];
         
                  $select_tutor = pg_prepare($conn, "select_tutor_query", 'SELECT * FROM tutors WHERE course_id = $1');
                  $select_tutor_result = pg_execute($conn, "select_tutor_query", array($fetch_course['tutor_id']));
                  $fetch_tutor = pg_fetch_assoc($select_tutor_result);       
      ?>
      <div class="box">
         <div class="tutor">
            <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_tutor['name']; ?></h3>
               <span><?= $fetch_course['date']; ?></span>
            </div>
         </div>
         <img src="uploaded_files/<?= $fetch_course['thumb']; ?>" class="thumb" alt="">
         <h3 class="title"><?= $fetch_course['title']; ?></h3>
         <a href="playlist.php?get_id=<?= $course_id; ?>" class="inline-btn">View playlist</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">No courses added yet!</p>';
      }
      ?>

   </div>

</section>

<!-- courses section ends -->




<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>