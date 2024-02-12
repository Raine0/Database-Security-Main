<?php

include 'components/connect.php';

if (isset($_POST['submit'])) {

   $user_id = unique_id();
   $student_id = unique_id();
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = unique_id() . '.' . $ext;
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_files/' . $rename;

   $select_user = pg_prepare($conn, "select_user_query", 'SELECT * FROM users WHERE email = $1');
   $select_user_result = pg_execute($conn, "select_user_query", array($email));

   if (pg_num_rows($select_user_result) > 0) {
      $message[] = 'Email already taken!';
   } else {
      if ($pass != $cpass) {
         $message[] = 'Password does not match!';
      } else {
         $insert_student = pg_prepare($conn, "insert_student_query", 'INSERT INTO students(student_id, name, image) VALUES($1, $2, $3)');
         $insert_student_result = pg_execute($conn, "insert_student_query", array($student_id, $name, $rename));
         move_uploaded_file($image_tmp_name, $image_folder);

         $insert_user = pg_prepare($conn, "insert_user_query", 'INSERT INTO users("user_id", student_id, email, password, role) VALUES($1, $2, $3, $4, $5)');
         $insert_user_result = pg_execute($conn, "insert_user_query", array($user_id, $student_id, $email, $cpass, 'Student'));

         $verify_user = pg_prepare($conn, "verify_user_query", 'SELECT * FROM users WHERE email = $1 AND password = $2 LIMIT 1');
         $verify_user_result = pg_execute($conn, "verify_user_query", array($email, $pass));
         $row = pg_fetch_assoc($verify_user_result);

         if (pg_num_rows($verify_user_result) > 0) {
            setcookie('user_id', $row['student_id'], time() + 60 * 60 * 24 * 30, '/');
            header('location:home.php');
            echo "User created successfully";
         }
      }
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <link rel="icon" type="image/x-icon" href="images/favicon.ico">
</head>
<body class="login-page">



<section class="form-container">

   <form class="register" action="" method="post" enctype="multipart/form-data">
      <h3>create account</h3>
      <div class="flex">
         <div class="col">
            <p>Full Name <span>*</span></p>
            <input type="text" name="name" placeholder="Enter your name" maxlength="50" required class="box">
            <p>Email <span>*</span></p>
            <input type="email" name="email" placeholder="Enter your email" maxlength="50" required class="box">
         </div>
         <div class="col">
            <p>Password <span>*</span></p>
            <input type="password" name="pass" placeholder="Enter your password" maxlength="20" required class="box">
            <p>Confirm Password <span>*</span></p>
            <input type="password" name="cpass" placeholder="Confirm your password" maxlength="20" required class="box">
         </div>
      </div>
      <p>Select Picture <span>*</span></p>
      <input type="file" name="image" accept="image/*" required class="box">
      <p class="link">Already Have an Account? <a href="login.php">Login Now</a></p>
      <input type="submit" name="submit" value="register now" class="btn">
   </form>

</section>


<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>