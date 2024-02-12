<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>User Comments</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/style.css">

   <link rel="icon" type="image/x-icon" href="../images/favicon.ico">
</head>
<body>


<?php
include '../components/user_header.php';

if(isset($_POST['delete_comment'])) {
   $delete_id = $_POST['comment_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);

   $verify_comment_query = pg_prepare($conn, "verify_comment_query", "SELECT * FROM comments WHERE comment_id = $1");
   $verify_comment_result = pg_execute($conn, "verify_comment_query", array($delete_id));

   if(pg_num_rows($verify_comment_result) > 0) {
       $delete_comment_query = pg_prepare($conn, "delete_comment_query", "DELETE FROM comments WHERE comment_id = $1");
       $delete_comment_result = pg_execute($conn, "delete_comment_query", array($delete_id));
       $message[] = 'Comment deleted successfully';
   } else {
       $message[] = 'Comment already deleted';
   }
}

if(isset($_POST['update_now'])) {
   $update_id = $_POST['update_id'];
   $update_id = filter_var($update_id, FILTER_SANITIZE_STRING);
   $update_box = $_POST['update_box'];
   $update_box = filter_var($update_box, FILTER_SANITIZE_STRING);

   $verify_comment_query = pg_prepare($conn, "verify_comment_query", "SELECT * FROM comments WHERE comment_id = $1 AND comment = $2 ORDER BY date DESC");
   $verify_comment_result = pg_execute($conn, "verify_comment_query", array($update_id, $update_box));

   if(pg_num_rows($verify_comment_result) > 0) {
       $message[] = 'Comment already added';
   } else {
       $update_comment_query = pg_prepare($conn, "update_comment_query", "UPDATE comments SET comment = $1 WHERE comment_id = $2");
       $update_comment_result = pg_execute($conn, "update_comment_query", array($update_box, $update_id));
       $message[] = 'Comment edited successfully';
   }
}
?>


<?php
   if(isset($_POST['edit_comment'])) {
      $edit_id = $_POST['comment_id'];
      $edit_id = filter_var($edit_id, FILTER_SANITIZE_STRING);

      $verify_comment = pg_prepare($conn, "verify_comment_query", "SELECT * FROM comments WHERE comment_id = $1 LIMIT 1");
      $verify_comment_result = pg_execute($conn, "verify_comment_query", array($edit_id));

      if(pg_num_rows($verify_comment_result) > 0) {
         $fetch_edit_comment = pg_fetch_assoc($verify_comment_result);
?>
<section class="edit-comment">
   <h1 class="heading">Edit Comment</h1>
   <form action="" method="post">
      <input type="hidden" name="update_id" value="<?= $fetch_edit_comment['comment_id']; ?>">
      <textarea name="update_box" class="box" maxlength="1000" required placeholder="please enter your comment" cols="30" rows="10"><?= $fetch_edit_comment['comment']; ?></textarea>
      <div class="flex">
         <a href="comments.php" class="inline-option-btn">cancel edit</a>
         <input type="submit" value="update now" name="update_now" class="inline-btn">
      </div>
   </form>
</section>
<?php
   }else{
      $message[] = 'Comment was not found';
   }
}
?>

<section class="comments">

   <h1 class="heading">Your Comments</h1>

   
   <div class="show-comments">
      <?php
         $select_comments = pg_prepare($conn, "select_comments_query", "SELECT * FROM comments WHERE user_id = $1");
         $select_comments_result = pg_execute($conn, "select_comments_query", array($user_id));

         if(pg_num_rows($select_comments_result) > 0) {
            $select_content = pg_prepare($conn, "select_content_query", "SELECT * FROM content WHERE content_id = $1");
            while($fetch_comment = pg_fetch_assoc($select_comments_result)) {
               
               $select_content_result = pg_execute($conn, "select_content_query", array($fetch_comment['content_id']));
               $fetch_content = pg_fetch_assoc($select_content_result);
      ?>
      <div class="box" style="<?php if($fetch_comment['user_id'] == $user_id){echo 'order:-1;';} ?>">
         <div class="content"><p> <?= $fetch_content['title']; ?> </p><span> <?= $fetch_comment['date']; ?> </span>  <a href="watch_video.php?get_id=<?= $fetch_content['content_id']; ?>">View Content</a></div>
         <p class="text"><?= $fetch_comment['comment']; ?></p> 
         <?php
            if($fetch_comment['user_id'] == $user_id){ 
         ?>
         <form action="" method="post" class="flex-btn">
            <input type="hidden" name="comment_id" value="<?= $fetch_comment['comment_id']; ?>">
            <button type="submit" name="edit_comment" class="inline-option-btn">Edit Comment</button>
            <button type="submit" name="delete_comment" class="inline-delete-btn" onclick="return confirm('delete this comment?');">Delete Comment</button>
         </form>
         <?php
         }
         ?>
      </div>
      <?php
       }
      }else{
         echo '<p class="empty">No comments added yet</p>';
      }
      ?>
      </div>
   
</section>

<!-- comments section ends -->


<!-- custom js file link  -->
<script src="../js/script.js"></script>
   
</body>
</html>