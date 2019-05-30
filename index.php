<?php
include("includes/header.php");
include("includes/classes/User.php");
include("includes/classes/Post.php");
//session_destroy();

if(isset($_POST['post'])) {
  $post = new Post($con, $userLoggedIn);
  $post->submitPost($_POST['post_text'], 'none');
}

?>
  <div class="user_details column">
    <a href="#"> <img src="<?php echo $user['profile_pic']; ?>"> </a>

    <div class="user_details_left_right">
      <a href="<?php echo $userLoggedIn; ?>">
      <?php
      echo $user['first_name'] . " " . $user['last_name']. "<br>";
      ?>
      </a>
      <br>
      <?php echo "Publications : " . $user['num_posts']. "<br>";
      echo "Likes : " . $user['num_likes'];
      ?>
    </div>

  </div>

  <div class="main_column column">
    <form class="post_form" action="index.php" method="POST">
      <textarea name="post_text" id="post_text" placeholder="Quelque chose à partager ?"></textarea>
      <br>
      <input type="submit" name="post" id="post_button" value="Publier">
      <br>
    </form>

    <?php
    $post = new Post($con, $userLoggedIn);
    $post->loadPostsFriends();
    ?>
  </div>



  </div>
</body>
</html>