<?php
session_start();
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}

include '../components/connect.php';

// Check if user is logged in, then assign user id and role to these variables
if (isset($_SESSION['user_id']) && isset($_SESSION['user_role']) && isset($_SESSION['tutor_id'])) {
   $user_id = $_SESSION['user_id'];
   $user_role = $_SESSION['user_role'];
   $tutor_id = $_SESSION['tutor_id'];
   
} else {
   // If not logged in, empty variables
   $user_id = '';
   $user_role = '';
   $tutor_id = '';
}
?>

<header class="header">

   <section class="flex">

      <a href="dashboard.php" class="logo">Admin.</a>

      <form action="search_page.php" method="post" class="search-form">
         <input type="text" name="search" placeholder="search here..." required maxlength="100">
         <button type="submit" class="fas fa-search" name="search_btn"></button>
      </form>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="search-btn" class="fas fa-search"></div>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="toggle-btn" class="fas fa-sun"></div>
      </div>

      <div class="profile">
         <?php
         // Prepare the SELECT statement
         $select_profile = pg_prepare($conn, "select_profile_query", "SELECT * FROM tutors WHERE tutor_id = $1");

         // Execute the prepared statement
         $select_profile_result = pg_execute($conn, "select_profile_query", array($tutor_id));

         // Check if there are any rows returned
         if (pg_num_rows($select_profile_result) > 0) {
            // Fetch the profile information as an associative array
            $fetch_profile = pg_fetch_assoc($select_profile_result);
            // Now you can access the profile information using $fetch_profile array
         ?>
         <img src="../uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
         <h3><?= $fetch_profile['name']; ?></h3>
         <span><?= $fetch_profile['profession']; ?></span>
         <a href="profile.php" class="btn">view profile</a>
         <!-- <div class="flex-btn">
            <a href="login.php" class="option-btn">login</a>
            <a href="register.php" class="option-btn">register</a>
         </div> -->
         <a href="../components/admin_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">logout</a>
         <?php
            }else{
         ?>
         <h3>please login or register</h3>
          <div class="flex-btn">
            <a href="login.php" class="option-btn">login</a>
            <a href="register.php" class="option-btn">register</a>
         </div>
         <?php
            }
         ?>
      </div>

   </section>

</header>

<!-- header section ends -->

<!-- side bar section starts  -->

<div class="side-bar">

   <div class="close-side-bar">
      <i class="fas fa-times"></i>
   </div>

   <div class="profile">
         <?php
         // Prepare the SELECT statement
         $select_profile = pg_prepare($conn, "select_profile_query1", "SELECT * FROM tutors WHERE tutor_id = $1");

         // Execute the prepared statement
         $select_profile_result = pg_execute($conn, "select_profile_query1", array($tutor_id));

         // Check if there are any rows returned
         if (pg_num_rows($select_profile_result) > 0) {
            // Fetch the profile information as an associative array
            $fetch_profile = pg_fetch_assoc($select_profile_result);
            // Now you can access the profile information using $fetch_profile array
         ?>
         <img src="../uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
         <h3><?= $fetch_profile['name']; ?></h3>
         <span><?= $fetch_profile['profession']; ?></span>
         <a href="profile.php" class="btn">view profile</a>
         <?php
            }else{
         ?>
         <!-- <h3>please login or register</h3>
          <div class="flex-btn">
            <a href="login.php" class="option-btn">login</a>
            <a href="register.php" class="option-btn">register</a>
         </div> -->
         <?php
            }
         ?>
      </div>

   <nav class="navbar">
      <a href="dashboard.php"><i class="fas fa-home"></i><span>Home</span></a>
      <a href="playlists.php"><i class="fa-solid fa-bars-staggered"></i><span>Courses</span></a>
      <a href="contents.php"><i class="fas fa-graduation-cap"></i><span>Contents</span></a>
      <a href="comments.php"><i class="fas fa-comment"></i><span>Comments</span></a>
      <a href="../components/admin_logout.php" onclick="return confirm('logout from this website?');"><i class="fas fa-right-from-bracket"></i><span>Logout</span></a>
   </nav>

</div>

<!-- side bar section ends -->