<?php
include '../components/admin_header.php';

$select_user = pg_prepare($conn, "select_user_query", "SELECT * from users WHERE user_id = $1");
$select_user_result = pg_execute($conn, "select_user_query", array($user_id));
$fetch_user = pg_fetch_assoc($select_user_result);

$select_tutor = pg_prepare($conn, "select_tutor_query", "SELECT * from tutors WHERE tutor_id = $1");
$select_tutor_result = pg_execute($conn, "select_tutor_query", array($tutor_id));
$fetch_tutor = pg_fetch_assoc($select_tutor_result);

if(isset($_POST['submit'])){

   $prev_pass = $fetch_tutor['password'];
   $prev_image = $fetch_tutor['image'];

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   if (!empty($name)) {
      $update_name = pg_prepare($conn, "update_name_query", "UPDATE tutors SET name = $1 WHERE tutor_id = $2");
      pg_execute($conn, "update_name_query", array($name, $tutor_id));
      $message[] = 'Name updated successfully!';
   }

   $profession = $_POST['profession'];
   $profession = filter_var($profession, FILTER_SANITIZE_STRING);

   if (!empty($profession)) {
      $update_profession = pg_prepare($conn, "update_profession_query", "UPDATE tutors SET profession = $1 WHERE tutor_id = $2");
      pg_execute($conn, "update_profession_query", array($profession, $tutor_id));
      $message[] = 'Profession updated successfully!';
   }   

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);

   if (!empty($email)) {
      $select_email = pg_prepare($conn, "select_email_query", "SELECT email FROM users WHERE user_id = $1 AND email = $2");
      pg_execute($conn, "select_email_query", array($user_id, $email));
      if (pg_num_rows($select_email) > 0) {
         $message[] = 'Email already taken!';
      } else {
         $update_email = pg_prepare($conn, "update_email_query", "UPDATE users SET email = $1 WHERE user_id = $2");
         pg_execute($conn, "update_email_query", array($email, $user_id));
         $message[] = 'Email updated successfully!';
      }
   }

   // if(!empty($name)){
   //    $update_name = $conn->prepare("UPDATE `tutors` SET name = ? WHERE id = ?");
   //    $update_name->execute([$name, $tutor_id]);
   //    $message[] = 'username updated successfully!';
   // }

   // if(!empty($profession)){
   //    $update_profession = $conn->prepare("UPDATE `tutors` SET profession = ? WHERE id = ?");
   //    $update_profession->execute([$profession, $tutor_id]);
   //    $message[] = 'profession updated successfully!';
   // }

   // if(!empty($email)){
   //    $select_email = $conn->prepare("SELECT email FROM `tutors` WHERE id = ? AND email = ?");
   //    $select_email->execute([$tutor_id, $email]);
   //    if($select_email->rowCount() > 0){
   //       $message[] = 'email already taken!';
   //    }else{
   //       $update_email = $conn->prepare("UPDATE `tutors` SET email = ? WHERE id = ?");
   //       $update_email->execute([$email, $tutor_id]);
   //       $message[] = 'email updated successfully!';
   //    }
   // }

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = unique_id().'.'.$ext;
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_files/'.$rename;

   // if(!empty($image)){
   //    if($image_size > 2000000){
   //       $message[] = 'image size too large!';
   //    }else{
   //       $update_image = $conn->prepare("UPDATE `tutors` SET `image` = ? WHERE id = ?");
   //       $update_image->execute([$rename, $tutor_id]);
   //       move_uploaded_file($image_tmp_name, $image_folder);
   //       if($prev_image != '' AND $prev_image != $rename){
   //          unlink('../uploaded_files/'.$prev_image);
   //       }
   //       $message[] = 'image updated successfully!';
   //    }
   // }

   if (!empty($image)) {
      if ($image_size > 2000000) {
         $message[] = 'Image size too large!';
      } else {
         $update_image = pg_prepare($conn, "update_image_query", "UPDATE tutors SET image = $1 WHERE tutor_id = $2");
         pg_execute($conn, "update_image_query", array($rename, $tutor_id));
         move_uploaded_file($image_tmp_name, $image_folder);
         if ($prev_image != '' && $prev_image != $rename) {
            unlink('../uploaded_files/'.$prev_image);
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

   // if($old_pass != $empty_pass){
   //    if($old_pass != $prev_pass){
   //       $message[] = 'old password not matched!';
   //    }elseif($new_pass != $cpass){
   //       $message[] = 'confirm password not matched!';
   //    }else{
   //       if($new_pass != $empty_pass){
   //          $update_pass = $conn->prepare("UPDATE `tutors` SET password = ? WHERE id = ?");
   //          $update_pass->execute([$cpass, $tutor_id]);
   //          $message[] = 'password updated successfully!';
   //       }else{
   //          $message[] = 'please enter a new password!';
   //       }
   //    }
   // }

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

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>


<!-- register section starts  -->

<section class="form-container" style="min-height: calc(100vh - 19rem);">

   <form class="register" action="" method="post" enctype="multipart/form-data">
      <h3>update profile</h3>
      <div class="flex">
         <div class="col">
            <p>Full Name </p>
            <input type="text" name="name" placeholder="<?= $fetch_tutor['name']; ?>" maxlength="50"  class="box">
            <p>Profession </p>
            <select name="profession" class="box">
               <option value="" selected><?= $fetch_tutor['profession']; ?></option>
               <option value="Developer">Developer</option>
               <option value="Desginer">Designer</option>
               <option value="Musician">Musician</option>
               <option value="Biologist">Biologist</option>
               <option value="Teacher">Teacher</option>
               <option value="Engineer">Engineer</option>
               <option value="Lawyer">Lawyer</option>
               <option value="Accountant">Accountant</option>
               <option value="Doctor">Doctor</option>
               <option value="Journalist">Journalist</option>
               <option value="Photographer">Photographer</option>
            </select>
            <p>Email </p>
            <input type="email" name="email" placeholder="<?= $fetch_tutor['email']; ?>" maxlength="20"  class="box">
         </div>
         <div class="col">
            <p>Old password :</p>
            <input type="password" name="old_pass" placeholder="enter your old password" maxlength="20"  class="box">
            <p>New password :</p>
            <input type="password" name="new_pass" placeholder="enter your new password" maxlength="20"  class="box">
            <p>Confirm Password :</p>
            <input type="password" name="cpass" placeholder="confirm your new password" maxlength="20"  class="box">
         </div>
      </div>
      <p>Update Picture:</p>
      <input type="file" name="image" accept="image/*"  class="box">
      <input type="submit" name="submit" value="update now" class="btn">
   </form>

</section>

<!-- update section ends -->


<script src="../js/admin_script.js"></script>
   
</body>
</html>