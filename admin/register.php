<?php

include '../components/connect.php';

if(isset($_POST['submit'])){

   $id = unique_id();
   $tutor_id = unique_id();
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $profession = $_POST['profession'];
   $profession = filter_var($profession, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $ext = pathinfo($image, PATHINFO_EXTENSION);
   $rename = unique_id().'.'.$ext;
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_files/'.$rename;

   // Use pg_prepare for prepared statements
   $select_tutor = pg_prepare($conn, "select_tutor_query", "SELECT * FROM tutors WHERE email = $1");
   pg_execute($conn, "select_tutor_query", array($email));
   
   if (pg_num_rows($select_tutor) > 0) {
         $message[] = 'Email already taken!';
   } else {
         if ($pass != $cpass) {
            $message[] = 'Confirm password not matched!';
         } else {
            // Use pg_prepare for prepared statements
            $insert_tutor = pg_prepare($conn, "insert_tutor_query", "INSERT INTO tutors(tutor_id, name, profession, email, password, image) VALUES($1, $2, $3, $4, $5, $6)");
            pg_execute($conn, "insert_tutor_query", array($tutor_id, $name, $profession, $email, $cpass, $rename));

            $insert_user = pg_prepare($conn, "insert_user_query", 'INSERT INTO users("user_id", tutor_id, email, password, role) VALUES($1, $2, $3, $4, $5)');
            $insert_user_result = pg_execute($conn, "insert_user_query", array($id, $tutor_id, $email, $cpass, 'Tutor'));
   
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'New tutor registered! Please login now.';
            header('location:login.php');
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
   <title>register</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body style="padding-left: 0;">

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message form">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<!-- register section starts  -->

<section class="form-container">

   <form class="register" action="" method="post" enctype="multipart/form-data">
      <h3>Tutor Registration</h3>
      <div class="flex">
         <div class="col">
            <p>Name <span>*</span></p>
            <input type="text" name="name" placeholder="Full Name" maxlength="50" required class="box">
            <p>Profession <span>*</span></p>
            <select name="profession" class="box" required>
               <option value="" disabled selected>Select your profession</option>
               <option value="Developer">Developer</option>
               <option value="Desginer">Desginer</option>
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
            <p>Email <span>*</span></p>
            <input type="email" name="email" placeholder="Enter your email" maxlength="50" required class="box">
         </div>
         <div class="col">
            <p>Password <span>*</span></p>
            <input type="password" name="pass" placeholder="Enter your password" maxlength="50" required class="box">
            <p>Confirm Password <span>*</span></p>
            <input type="password" name="cpass" placeholder="Confirm your password" maxlength="50" required class="box">
            <p>Select Profile Picture <span>*</span></p>
            <input type="file" name="image" accept="image/*" required class="box">
         </div>
      </div>
      <p class="link">Already have an account? <a href="login.php">Login now</a></p>
      <input type="submit" name="submit" value="register now" class="btn">
   </form>

</section>

<!-- register section ends -->












<script>

let darkMode = localStorage.getItem('dark-mode');
let body = document.body;

const enabelDarkMode = () =>{
   body.classList.add('dark');
   localStorage.setItem('dark-mode', 'enabled');
}

const disableDarkMode = () =>{
   body.classList.remove('dark');
   localStorage.setItem('dark-mode', 'disabled');
}

if(darkMode === 'enabled'){
   enabelDarkMode();
}else{
   disableDarkMode();
}

</script>
   
</body>
</html>