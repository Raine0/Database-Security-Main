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

include 'components/connect.php';

// Check if user is logged in, then assign user id and role to these variables
if (isset($_SESSION['user_id']) && isset($_SESSION['user_role']) && isset($_SESSION['student_id'])) {
   $user_id = $_SESSION['user_id'];
   $user_role = $_SESSION['user_role'];
   $student_id = $_SESSION['student_id'];

} else {
   // If not logged in, empty variables
   $user_id = '';
   $user_role = '';
   $student_id = '';
}
?>

<header class="header">

   <section class="flex">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap">

      <!-- <a href="home.php" class="logo">LearnHub</a> -->
      <a href="home.php" class="logo" style="color: #8e44ad; font-family: 'Roboto', sans-serif; font-size: 28px;">LearnHub</a>

      <form action="search_course.php" method="post" class="search-form">
         <input type="text" name="search_course" placeholder="Search Courses" required maxlength="100">
         <button type="submit" class="fas fa-search" name="search_course_btn"></button>
      </form>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="search-btn" class="fas fa-search"></div>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="toggle-btn" class="fas fa-sun"></div>
      </div>

      <div class="profile">
         <?php
            // Use pg_prepare for prepared statements
            // $select_profile = pg_prepare($conn, "select_profile_query", 'SELECT * FROM students WHERE student_id = $1');
            $select_profile = pg_prepare($conn, "select_profile_query", '
               SELECT students.*, users.user_id
               FROM students
               INNER JOIN users ON students.student_id = users.student_id
               WHERE users.user_id = $1
            ');

            // Use pg_execute to execute the prepared statement
            $select_profile_result = pg_execute($conn, "select_profile_query", array($user_id));
            
            // Fetch the result as an associative array
            $fetch_profile = pg_fetch_assoc($select_profile_result);

            if ($fetch_profile) {
         ?>
         <img src="uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
         <h3><?= $fetch_profile['name']; ?></h3>
         <span>Student</span>
         <a href="profile.php" class="btn">View Profile</a>
         <!-- <div class="flex-btn">
            <a href="login.php" class="option-btn">login</a>
            <a href="register.php" class="option-btn">register</a>
         </div> -->
         <a href="components/user_logout.php" onclick="return confirm('logout from this website?');" class="delete-btn">Logout</a>
         <?php
            }else{
         ?>
         <h3>Login or Register</h3>
          <div class="flex-btn">
            <a href="login.php" class="option-btn">Login</a>
            <a href="register.php" class="option-btn">Register</a>
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
            // Use pg_prepare for prepared statements
            // $select_profile = pg_prepare($conn, "select_profile_query1", 'SELECT * FROM students WHERE student_id = $1');
            $select_profile = pg_prepare($conn, "select_profile_query1", '
               SELECT students.*, users.user_id
               FROM students
               INNER JOIN users ON students.student_id = users.student_id
               WHERE users.user_id = $1
            ');

            // Use pg_execute to execute the prepared statement
            $select_profile_result = pg_execute($conn, "select_profile_query1", array($user_id));
            
            // Fetch the result as an associative array
            $fetch_profile = pg_fetch_assoc($select_profile_result);

            if ($fetch_profile) {
         ?>
         <img src="uploaded_files/<?= $fetch_profile['image']; ?>" alt="">
         <h3><?= $fetch_profile['name']; ?></h3>
         <span>Student</span>
         <a href="profile.php" class="btn">View Profile</a>
         <?php
            }else{
         ?>
         <!-- <h3>Please Login or Register</h3>
          <div class="flex-btn" style="padding-top: .5rem;">
            <a href="login.php" class="option-btn">Login</a>
            <a href="register.php" class="option-btn">Register</a>
         </div> -->
         <?php
            }
         ?>
      </div>

      <?php
      // Assuming $user_role is defined and contains the role value

      if ($user_role == "Student") {
         // Display the navigation for students
         echo '
         <nav class="navbar">
            <a href="home.php"><i class="fas fa-home"></i><span>Home</span></a>
            <a href="courses.php"><i class="fas fa-graduation-cap"></i><span>Courses</span></a>
            <a href="tutors.php"><i class="fas fa-chalkboard-user"></i><span>Tutors</span></a>
            <a href="about.php"><i class="fas fa-question"></i><span>About Us</span></a>
            <a href="contact.php"><i class="fas fa-headset"></i><span>Contact Us</span></a>
         </nav>';
      } else {
         // Display an alternative navigation or handle other cases
         echo '<p>Navigation for other roles or a default navigation</p>', $user_role;
      }
      ?>
</div>

<!-- side bar section ends -->