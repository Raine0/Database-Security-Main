<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php
include '../components/admin_header.php';

if ($tutor_id == ''){
   header('location:login.php');
}

if(isset($_POST['delete_comment'])){
   $delete_id = $_POST['comment_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   // Prepare the SELECT statement to verify the existence of the comment
   $verify_comment = pg_prepare($conn, "verify_comment_query", "SELECT * FROM comments WHERE comment_id = $1");
   // Execute the prepared statement
   $verify_comment_result = pg_execute($conn, "verify_comment_query", array($delete_id));

   // Check if the comment exists
   if(pg_num_rows($verify_comment_result) > 0){
      // Prepare the DELETE statement to delete the comment
      $delete_comment = pg_prepare($conn, "delete_comment_query", "DELETE FROM comments WHERE comment_id = $1");
      // Execute the prepared statement to delete the comment
      pg_execute($conn, "delete_comment_query", array($delete_id));
      $message[] = 'Comment deleted successfully!';
   }else{
      $message[] = 'Comment already deleted!';
   }
}
?>

<section class="comments">

   <h1 class="heading">user comments</h1>

   
   <div class="show-comments">
      <?php
      $select_comments = pg_prepare($conn, "select_comments_query", "SELECT * FROM comments WHERE tutor_id = $1");
      $result_select_comments = pg_execute($conn, "select_comments_query", array($tutor_id));

      if(pg_num_rows($result_select_comments) > 0){
         $select_content = pg_prepare($conn, "select_content_query", "SELECT * FROM content WHERE content_id = $1");
         while($fetch_comment = pg_fetch_assoc($result_select_comments)){
            
            $result_select_content = pg_execute($conn, "select_content_query", array($fetch_comment['content_id']));
            $fetch_content = pg_fetch_assoc($result_select_content);
      ?>
      <div class="box" style="<?php if($fetch_comment['tutor_id'] == $tutor_id){echo 'order:-1;';} ?>">
         <div class="content"><span><?= $fetch_comment['date']; ?></span><p> - <?= $fetch_content['title']; ?> - </p><a href="view_content.php?get_id=<?= $fetch_content['content_id']; ?>">View Content</a></div>
         <p class="text"><?= $fetch_comment['comment']; ?></p>
         <form action="" method="post">
            <input type="hidden" name="comment_id" value="<?= $fetch_comment['comment_id']; ?>">
            <button type="submit" name="delete_comment" class="inline-delete-btn" onclick="return confirm('delete this comment?');">Delete Comment</button>
         </form>
      </div>
      <?php
       }
      }else{
         echo '<p class="empty">No comments added yet</p>';
      }
      ?>
   </div>
   
</section>


<script src="../js/admin_script.js"></script>

</body>
</html>