<?php
require 'config/config.php';

if(isset($_SESSION['username'])) {
  $userLoggedIn = $_SESSION['username'];
  $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
  $user = mysqli_fetch_array($user_details_query);

} else {
  header("Location: register.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>trotter</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
  <div class="top_bar">
    <div class="nav_logo">
      <img src="assets/images/register/scooter.png" alt="scooter">
      <a href="index.php">trotter</a>
    </div>

    <nav>
      <a href="profile.php">Profil</a>
      <a href="#">Messagerie</a>
      <a href="includes/logout/logout.php">Déconnexion</a>
    </nav>

  </div>

  <div class="contain">