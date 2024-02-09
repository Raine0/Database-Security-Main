<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Tutors</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <link rel="icon" type="image/x-icon" href="images/favicon.ico">
</head>
<body>


<?php include 'components/user_header.php'; ?>

<!-- teachers section starts  -->

<section class="teachers">

   <h1 class="heading">Expert Tutors</h1>

   <form action="search_tutor.php" method="post" class="search-tutor">
      <input type="text" name="search_tutor" maxlength="100" placeholder="Search Tutors" required>
      <button type="submit" name="search_tutor_btn" class="fas fa-search"></button>
   </form>

   <div class="box-container">

      <!-- <div class="box offer">
         <h3>Become a Tutor</h3>
         <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Laborum, magnam!</p>
         <a href="admin/register.php" class="inline-btn">get started</a>
      </div> -->

      <?php
         // Prepare statements for counting courses, contents, likes, and comments
         $count_courses_query = pg_prepare($conn, "count_courses_query", 'SELECT * FROM courses WHERE tutor_id = $1');
         $count_contents_query = pg_prepare($conn, "count_contents_query", 'SELECT * FROM content WHERE tutor_id = $1');
         $count_likes_query = pg_prepare($conn, "count_likes_query", 'SELECT * FROM likes WHERE tutor_id = $1');
         $count_comments_query = pg_prepare($conn, "count_comments_query", 'SELECT * FROM comments WHERE tutor_id = $1');

         $select_tutors = pg_prepare($conn, "select_tutors_query", 'SELECT * FROM tutors');
         $select_tutors_result = pg_execute($conn, "select_tutors_query", array());
            
         if ($select_tutors_result) {
            while ($fetch_tutor = pg_fetch_assoc($select_tutors_result)) {
               // Execute the prepared statements inside the loop
               $count_playlists_result = pg_execute($conn, "count_courses_query", array($fetch_tutor['tutor_id']));
               $total_playlists = pg_num_rows($count_playlists_result);
   
               $count_contents_result = pg_execute($conn, "count_contents_query", array($fetch_tutor['tutor_id']));
               $total_contents = pg_num_rows($count_contents_result);
   
               $count_likes_result = pg_execute($conn, "count_likes_query", array($fetch_tutor['tutor_id']));
               $total_likes = pg_num_rows($count_likes_result);
   
               $count_comments_result = pg_execute($conn, "count_comments_query", array($fetch_tutor['tutor_id']));
               $total_comments = pg_num_rows($count_comments_result);
      ?>
      <div class="box">
         <div class="tutor">
            <img src="uploaded_files/<?= $fetch_tutor['image']; ?>" alt="">
            <div>
               <h3><?= $fetch_tutor['name']; ?></h3>
               <span><?= $fetch_tutor['profession']; ?></span>
            </div>
         </div>
         <p>Playlists : <span><?= $total_playlists; ?></span></p>
         <p>Total Videos : <span><?= $total_contents ?></span></p>
         <p>Total Likes : <span><?= $total_likes ?></span></p>
         <p>Total Comments : <span><?= $total_comments ?></span></p>
         <form action="tutor_profile.php" method="post">
            <input type="hidden" name="tutor_email" value="<?= $fetch_tutor['email']; ?>">
            <input type="submit" value="view profile" name="tutor_fetch" class="inline-btn">
         </form>
      </div>
      <?php
            }
         }else{
            echo '<p class="empty">No Tutors Found!</p>';
         }
      ?>

   </div>

</section>

<!-- teachers section ends -->

  

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>