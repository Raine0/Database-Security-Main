<?php
session_start();
include '../components/connect.php';

if(isset($_POST['submit'])){

    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = sha1($_POST['pass']);
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
 
    // Use pg_prepare for prepared statements
    $select_user = pg_prepare($conn, "select_user_query", 'SELECT * FROM users WHERE email = $1 AND password = $2 LIMIT 1');
    $select_user_result = pg_execute($conn, "select_user_query", array($email, $pass));
 
    // Fetch the result as an associative array
    $row = pg_fetch_assoc($select_user_result);
 
    if ($row) {
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['user_role'] = $row['role'];
        $_SESSION['tutor_id'] = $row['tutor_id'];
        header('location:dashboard.php');
    } else {
        $message[] = 'Incorrect email or password!';
    }
}

// Now you can use $user_role to determine if it was set properly
// if (!empty($_SESSION['user_id'])) {
//     // 'user_role' cookie is set
//     echo 'User Role: ' . $_SESSION['user_role'];
//     echo 'User ID: ' . $_SESSION['user_id'];
//     echo 'Tutor ID: ' . $_SESSION['tutor_id'];
// } else {
//     echo $user_role;
// }
?>