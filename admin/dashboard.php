<?php

include '../components/connect.php';
// Check if user is logged in, then assign user id and role to these variables
if (isset($_SESSION['user_id']) && isset($_SESSION['user_role'])) {
   $user_id = $_SESSION['user_id'];
   $user_role = $_SESSION['user_role'];
   $tutor_id = $_SESSION['tutor_id'];

} else {
   // If not logged in, empty variables
   $user_id = '';
   $user_role = '';
   $tutor_id = '';
}

$select_contents = pg_prepare($conn, "select_contents_query", "SELECT * FROM content WHERE tutor_id = $1");
pg_execute($conn, "select_contents_query", array($tutor_id));
$total_contents = pg_num_rows($select_contents);

$select_courses = pg_prepare($conn, "select_courses_query", "SELECT * FROM courses WHERE tutor_id = $1");
pg_execute($conn, "select_courses_query", array($tutor_id));
$total_courses = pg_num_rows($select_courses);

$select_likes = pg_prepare($conn, "select_likes_query", "SELECT * FROM likes WHERE tutor_id = $1");
pg_execute($conn, "select_likes_query", array($tutor_id));
$total_likes = pg_num_rows($select_likes);

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
   <title>Dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>
   
<section class="dashboard">

   <h1 class="heading">Dashboard</h1>

   <div class="box-container">

      <div class="box">
         <h3>welcome!</h3>
         <p><?= $fetch_profile['name']; ?></p>
         <a href="profile.php" class="btn">view profile</a>
      </div>

      <div class="box">
         <h3><?= $total_contents; ?></h3>
         <p>total contents</p>
         <a href="add_content.php" class="btn">add new content</a>
      </div>

      <div class="box">
         <h3><?= $total_playlists; ?></h3>
         <p>total playlists</p>
         <a href="add_playlist.php" class="btn">add new playlist</a>
      </div>

      <div class="box">
         <h3><?= $total_likes; ?></h3>
         <p>total likes</p>
         <a href="contents.php" class="btn">view contents</a>
      </div>

      <div class="box">
         <h3><?= $total_comments; ?></h3>
         <p>total comments</p>
         <a href="comments.php" class="btn">view comments</a>
      </div>

      <div class="box">
         <h3>quick select</h3>
         <p>login or register</p>
         <div class="flex-btn">
            <a href="login.php" class="option-btn">login</a>
            <a href="register.php" class="option-btn">register</a>
         </div>
      </div>

   </div>

</section>















<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

</body>
</html>