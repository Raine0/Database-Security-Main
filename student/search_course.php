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
   <link rel="stylesheet" href="../css/style.css">

</head>
<body>

<?php include '../components/user_header.php'; ?>

<!-- courses section starts  -->

<section class="courses">

   <h1 class="heading">search results</h1>

   <div class="box-container">

      <?php
         if(isset($_POST['search_course']) || isset($_POST['search_course_btn'])) {
            $search_course = $_POST['search_course'];
            // Prepare the SQL query to select courses along with their tutors and categories
            $select_courses_query = "
               SELECT courses.*, tutors.name AS tutor_name
               FROM courses
               INNER JOIN tutors ON courses.tutor_id = tutors.tutor_id
               WHERE courses.title LIKE $1
               AND courses.status = $2
               OR courses.category LIKE $1
            ";

            // Prepare and execute the query
            $select_courses = pg_prepare($conn, "select_courses_query", $select_courses_query);
            $select_courses_result = pg_execute($conn, "select_courses_query", array("%$search_course%", 'Active'));

            
            $select_tutor = pg_prepare($conn, "select_tutor_query", "SELECT * FROM tutors WHERE tutor_id = $1");
            if(pg_num_rows($select_courses_result) > 0) {
               while($fetch_course = pg_fetch_assoc($select_courses_result)) {
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
         <a href="playlist.php?get_id=<?= $course_id; ?>" class="inline-btn">view playlist</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">No courses found.</p>';
      }
      }else{
         echo '<p class="empty">Please enter your search.</p>';
      }
      ?>

   </div>

</section>

<!-- courses section ends -->


<!-- custom js file link  -->
<script src="../js/script.js"></script>
   
</body>
</html>