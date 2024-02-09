<?php
include 'components/user_header.php';

$select_user = pg_prepare($conn, "select_user_query", '
    SELECT users.user_id, users.student_id, users.email, users.password, users.role,
           students.name, students.image
    FROM users
    INNER JOIN students ON users.student_id = students.student_id
    WHERE users.user_id = $1
');

$select_user_result = pg_execute($conn, "select_user_query", array($user_id));
$fetch_user = pg_fetch_assoc($select_user_result);

if(isset($_POST['submit'])){

   $prev_pass = $fetch_user['password'];
   $prev_image = $fetch_user['image'];

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   if (!empty($name)) {
      $update_name = pg_prepare($conn, "update_name_query", "UPDATE students SET name = $1 WHERE student_id = $2");
      pg_execute($conn, "update_name_query", array($name, $student_id));
      $message[] = 'Name updated successfully!';
   }

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);

   if (!empty($email)) {
      $select_email = pg_prepare($conn, "select_email_query", "SELECT email FROM users WHERE email = $1");
      pg_execute($conn, "select_email_query", array($email));
      if (pg_num_rows($select_email) > 0) {
          $message[] = 'Email already taken!';
      } else {
          $update_email = pg_prepare($conn, "update_email_query", "UPDATE users SET email = $1 WHERE user_id = $2");
          pg_execute($conn, "update_email_query", array($email, $user_id));
          $message[] = 'Email updated successfully!';
      }
   }

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = unique_id().'.'.$ext;
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = 'uploaded_files/'.$rename;

   if (!empty($image)) {
      if ($image_size > 2000000) {
         $message[] = 'Image size too large!';
      } else {
         $update_image = pg_prepare($conn, "update_image_query", "UPDATE students SET image = $1 WHERE student_id = $2");
         pg_execute($conn, "update_image_query", array($rename, $student_id));
         move_uploaded_file($image_tmp_name, $image_folder);

         if ($prev_image != '' && $prev_image != $rename) {
               unlink('uploaded_files/'.$prev_image);
         }

         $message[] = 'Image updated successfully!';
      }
   }

   $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
   $old_pass = sha1($_POST['old_pass']);
   $old_pass = filter_var($old_pass, FILTER_SANITIZE_STRING);
   $new_pass = sha1($_POST['new_pass']);
   $new_pass = filter_var($new_pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   if ($old_pass != $empty_pass) {
      if ($old_pass != $prev_pass) {
         $message[] = 'Old password not matched!';
      } elseif ($new_pass != $cpass) {
         $message[] = 'Confirm password not matched!';
      } else {
         if ($new_pass != $empty_pass) {
               $update_pass = pg_prepare($conn, "update_pass_query", "UPDATE users SET password = $1 WHERE user_id = $2");
               pg_execute($conn, "update_pass_query", array($cpass, $user_id));
               $message[] = 'Password updated successfully!';
         } else {
               $message[] = 'Please enter a new password!';
         }
      }
   }
   header('location:profile.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update Profile</title>
   <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <link rel="icon" type="image/x-icon" href="images/favicon.ico">
</head>
<body>

<section class="form-container" style="min-height: calc(100vh - 19rem);">

   <form action="" method="post" enctype="multipart/form-data">
      <h3>update profile</h3>
      <div class="flex">
         <div class="col">
            <p>Name</p>
            <input type="text" name="name" placeholder="<?= $fetch_user['name']; ?>" maxlength="100" class="box">
            <p>Email</p>
            <input type="email" name="email" placeholder="<?= $fetch_user['email']; ?>" maxlength="100" class="box">
            <p>New Profile Picture</p>
            <input type="file" name="image" accept="image/*" class="box">
         </div>
         <div class="col">
               <p>Old Password</p>
               <input type="password" name="old_pass" placeholder="Enter your old password" maxlength="50" class="box">
               <p>New Password</p>
               <input type="password" name="new_pass" placeholder="Enter your new password" maxlength="50" class="box">
               <p>Confirm Password</p>
               <input type="password" name="cpass" placeholder="Confirm your new password" maxlength="50" class="box">
         </div>
      </div>
      <input type="submit" name="submit" value="update profile" class="btn">
   </form>

</section>

<!-- update profile section ends -->







<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>