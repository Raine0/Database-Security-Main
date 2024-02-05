<?php

   // Mysql Connection
   // $db_name = 'mysql:host=localhost;dbname=db_security';
   // $user_name = 'root';
   // $user_password = '';

   // $conn = new PDO($db_name, $user_name, $user_password);


   // PostgreSQL Connection
   $db_name = 'dbsecurity';
   $user_name = 'postgres';
   $user_password = '123';
   $host = `localhost`;

   $conn = pg_connect("host=localhost dbname=dbsecurity user=postgres password=123");
   if (!$conn) {
      echo "An error occurred.<br>";
      exit;
   } 
   /* else {
      echo "Successfully connected to PostgreSQL!<br>";
   } */

   function unique_id() {
      $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
      $rand = array();
      $length = strlen($str) - 1;
      for ($i = 0; $i < 20; $i++) {
          $n = mt_rand(0, $length);
          $rand[] = $str[$n];
      }
      return implode($rand);
   }

?>