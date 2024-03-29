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

   <link rel="icon" type="image/x-icon" href="../images/favicon.ico">
</head>
<body>

   
<?php
include '../components/admin_header.php';

if(isset($_POST['delete_video'])){
   $delete_id = $_POST['video_id'];
   $delete_id = filter_var($delete_id, FILTER_SANITIZE_STRING);
   $verify_video = $conn->prepare("SELECT * FROM `content` WHERE id = ? LIMIT 1");
   $verify_video->execute([$delete_id]);
   if($verify_video->rowCount() > 0){
      $delete_video_thumb = $conn->prepare("SELECT * FROM `content` WHERE id = ? LIMIT 1");
      $delete_video_thumb->execute([$delete_id]);
      $fetch_thumb = $delete_video_thumb->fetch(PDO::FETCH_ASSOC);
      unlink('../uploaded_files/'.$fetch_thumb['thumb']);
      $delete_video = $conn->prepare("SELECT * FROM `content` WHERE id = ? LIMIT 1");
      $delete_video->execute([$delete_id]);
      $fetch_video = $delete_video->fetch(PDO::FETCH_ASSOC);
      unlink('../uploaded_files/'.$fetch_video['video']);
      $delete_likes = $conn->prepare("DELETE FROM `likes` WHERE content_id = ?");
      $delete_likes->execute([$delete_id]);
      $delete_comments = $conn->prepare("DELETE FROM `comments` WHERE content_id = ?");
      $delete_comments->execute([$delete_id]);
      $delete_content = $conn->prepare("DELETE FROM `content` WHERE id = ?");
      $delete_content->execute([$delete_id]);
      $message[] = 'Video deleted!';
   }else{
      $message[] = 'Video already deleted!';
   }
}
?>


<section class="contents">

   <h1 class="heading">your contents</h1>

   <div class="box-container">

   <!-- <div class="box" style="text-align: center;">
      <h3 class="title" style="margin-bottom: .5rem;">create new content</h3>
      <a href="add_content.php" class="btn">add content</a>
   </div> -->

   <?php
      $select_videos = pg_prepare($conn, "select_videos_query", "SELECT * FROM content WHERE tutor_id = $1 ORDER BY date DESC");
      $select_videos_result = pg_execute($conn, "select_videos_query", array($tutor_id));

      if (pg_num_rows($select_videos_result) > 0) {
         while ($fetch_videos = pg_fetch_assoc($select_videos_result)) {
            $video_id = $fetch_videos['content_id'];
   ?>
      <div class="box">
         <div class="flex">
            <div><i class="fas fa-dot-circle" style="<?php if($fetch_videos['status'] == 'Active'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"></i><span style="<?php if($fetch_videos['status'] == 'Active'){echo 'color:limegreen'; }else{echo 'color:red';} ?>"><?= $fetch_videos['status']; ?></span></div>
            <div><i class="fas fa-calendar"></i><span><?= $fetch_videos['date']; ?></span></div>
         </div>
         <img src="../uploaded_files/<?= $fetch_videos['thumbnail']; ?>" class="thumb" alt="">
         <h3 class="title"><?= $fetch_videos['title']; ?></h3>
         <form action="" method="post" class="flex-btn">
            <input type="hidden" name="video_id" value="<?= $video_id; ?>">
            <a href="update_content.php?get_id=<?= $video_id; ?>" class="option-btn">update</a>
            <input type="submit" value="delete" class="delete-btn" onclick="return confirm('delete this video?');" name="delete_video">
         </form>
         <a href="view_content.php?get_id=<?= $video_id; ?>" class="btn">view content</a>
      </div>
   <?php
         }
      }else{
         echo '<p class="empty">No contents added yet!</p>';
      }
   ?>

   </div>

</section>


<script src="../js/admin_script.js"></script>

</body>
</html>