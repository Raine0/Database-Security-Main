<?php


if(isset($_POST['submit'])){

   $name = $_POST['name']; 
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email']; 
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number']; 
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg']; 
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $select_contact = $conn->prepare("SELECT * FROM `contact` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_contact->execute([$name, $email, $number, $msg]);

   if($select_contact->rowCount() > 0){
      $message[] = 'message sent already!';
   }else{
      $insert_message = $conn->prepare("INSERT INTO `contact`(name, email, number, message) VALUES(?,?,?,?)");
      $insert_message->execute([$name, $email, $number, $msg]);
      $message[] = 'message sent successfully!';
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Contact Us</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <link rel="icon" type="image/x-icon" href="images/favicon.ico">
</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- contact section starts  -->

<section class="contact">

   <div class="row">

      <div class="image">
         <img src="images/contact-img.svg" alt="">
      </div>

      <form action="" method="post">
         <h3>Get in Touch</h3>
         <input type="text" placeholder="Name" required maxlength="100" name="name" class="box">
         <input type="email" placeholder="Email" required maxlength="100" name="email" class="box">
         <input type="number" min="0" max="9999999999" placeholder="Number" required maxlength="10" name="number" class="box">
         <textarea name="msg" class="box" placeholder="Message" required cols="30" rows="10" maxlength="1000"></textarea>
         <input type="submit" value="send message" class="inline-btn" name="submit">
      </form>

   </div>

   <div class="box-container">

      <div class="box">
         <i class="fas fa-phone"></i>
         <h3>Phone Number</h3>
         <a href="tel:1234567890">09076556908</a>
         <a href="tel:1112223333">09690182728</a>
      </div>

      <div class="box">
         <i class="fas fa-envelope"></i>
         <h3>Email Address</h3>
         <a href="mailto:ryanphilip.cataag@msugensan.edu.ph">ryanphilip.cataag@msugensan.edu.ph</a>
         <a href="mailto:cataagryanphilip@gmail.com">cataagryanphilip@gmail.com</a>
      </div>

      <div class="box">
         <i class="fas fa-map-marker-alt"></i>
         <h3>Office Address</h3>
         <a href="#">Mindanao State University - General Santos, Philippines, 9500</a>
      </div>


   </div>

</section>

<!-- contact section ends -->




<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>