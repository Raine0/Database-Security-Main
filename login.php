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
   <link rel="stylesheet" href="css/style.css">

   <link rel="icon" type="image/x-icon" href="images/favicon.ico">
</head>
<body class="login-page">



<section class="form-container">

   <form action="check-login.php" method="post" enctype="multipart/form-data" class="login">
      <h3>LearnHub Login</h3>
      <p>Email <span>*</span></p>
      <input type="email" name="email" placeholder="Enter Your Email" maxlength="50" required class="box">
      <p>Password <span>*</span></p>
      <input type="password" name="pass" placeholder="Enter Your Password" maxlength="20" required class="box">
      <p class="link">Don't have an account? <a href="register.php">Register Now</a></p>
      <input type="submit" name="submit" value="login now" class="btn">
   </form>

</section>




<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>