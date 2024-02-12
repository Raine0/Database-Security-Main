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
   <link rel="stylesheet" href="../css/style.css">

   <link rel="icon" type="image/x-icon" href="../images/favicon.ico">
</head>
<body>


<?php
include '../components/user_header.php';

// Select likes
$select_likes = pg_prepare($conn, "select_likes_query", "SELECT * FROM likes WHERE student_id = $1");
$result_likes = pg_execute($conn, "select_likes_query", array($student_id));
$total_likes = pg_num_rows($result_likes);

// Select comments
$select_comments = pg_prepare($conn, "select_comments_query", "SELECT * FROM comments WHERE student_id = $1");
$result_comments = pg_execute($conn, "select_comments_query", array($student_id));
$total_comments = pg_num_rows($result_comments);

// Select bookmarks
$select_bookmark = pg_prepare($conn, "select_bookmark_query", "SELECT * FROM bookmarks WHERE student_id = $1");
$result_bookmark = pg_execute($conn, "select_bookmark_query", array($student_id));
$total_bookmarked = pg_num_rows($result_bookmark);
?>

<section class="profile">

   <h1 class="heading">Profile Details</h1>

   <div class="details">

      <div class="user">
         <img src="../uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
         <h3><?= $fetch_profile['name']; ?></h3>
         <p>Student</p>
         <a href="update.php" class="inline-btn">Update Profile</a>
      </div>

      <div class="box-container">

         <div class="box">
            <div class="flex">
               <i class="fas fa-bookmark"></i>
               <div>
                  <h3><?= $total_bookmarked; ?></h3>
                  <span>Saved Playlists</span>
               </div>
            </div>
            <a href="#" class="inline-btn">View Playlists</a>
         </div>

         <div class="box">
            <div class="flex">
               <i class="fas fa-heart"></i>
               <div>
                  <h3><?= $total_likes; ?></h3>
                  <span>Liked Tutorials</span>
               </div>
            </div>
            <a href="#" class="inline-btn">View Liked Tutorials</a>
         </div>

         <div class="box">
            <div class="flex">
               <i class="fas fa-comment"></i>
               <div>
                  <h3><?= $total_comments; ?></h3>
                  <span>Video Comments</span>
               </div>
            </div>
            <a href="#" class="inline-btn">View Comments</a>
         </div>

      </div>

   </div>

</section>

<!-- profile section ends -->



<!-- custom js file link  -->
<script src="../js/script.js"></script>
   
</body>
</html>