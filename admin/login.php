<?php
session_start();
include '../components/connect.php';

if (isset($_POST['submit'])) {

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   // Use pg_prepare for prepared statements
   $select_tutor = pg_prepare($conn, "select_tutor_query", "SELECT * FROM users WHERE email = $1 AND password = $2 LIMIT 1");
   $select_tutor_result = pg_execute($conn, "select_tutor_query", array($email, $pass));

   // Fetch the result as an associative array
   $row = pg_fetch_assoc($select_tutor_result);

   if ($row) {
      $_SESSION['user_id'] = $row['user_id'];
      $_SESSION['tutor_id'] = $row['tutor_id'];
      header('location:dashboard.php');
   } else {
      $message[] = 'Incorrect email or password!';
   }
}

// Now you can use $user_role to determine if it was set properly
if (!empty($_SESSION['tutor_id'])) {
    // 'user_role' cookie is set
    echo 'User Role: ' . $_SESSION['tutor_id'];
    echo 'User ID: ' . $_SESSION['user_id'];
} else {
    echo "Not logged in";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>

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

   <form action="" method="post" enctype="multipart/form-data" class="login">
      <h3>Welcome back!</h3>
      <p>Email <span>*</span></p>
      <input type="email" name="email" placeholder="Enter your email" maxlength="50" required class="box">
      <p>Password <span>*</span></p>
      <input type="password" name="pass" placeholder="Enter your password" maxlength="20" required class="box">
      <p class="link">Don't have an account? <a href="register.php">register new</a></p>
      <input type="submit" name="submit" value="login now" class="btn">
   </form>

</section>

<!-- registe section ends -->














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