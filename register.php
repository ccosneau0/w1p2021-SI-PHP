<?php
require 'config/config.php';
require 'includes/form/form.php';
require 'includes/form/login.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Welcome to trotter</title>
  <link rel="stylesheet" href="assets/css/styles.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
  <script src="assets/js/register.js"></script>
</head>
<body>

  <?php 
  if(isset($_POST['register_button'])) {
    echo '
    <script>
    $(document).ready(function() {
      $("#first").hide();
      $("#second").show();
    });
    </script>
    ';
  }
  ?>
  <div class="wrapper">
    <div class="login">
      <div class="header">
        <img class="logo" src="assets/images/register/logo.png" alt="logo">
        <h1>Partagez Aimez Roulez</h1>
      </div>

      <div id="first">
        <!-- FORMULAIRE CONNEXION -->
        <form action="register.php" method="POST">
          <input type="email" name="log_email" placeholder="Adresse e-mail" value="<?php 
          if(isset($_SESSION['log_email'])) {
            echo $_SESSION['log_email'];
          } 
          ?>" required>
          <br>
          <input type="password" name="log_password" placeholder="Mot de passe">
          <br>
          <?php if(in_array("Adresse ou mot de passe incorrect<br>", $error_array)) echo "Adresse ou mot de passe incorrect<br>"; ?>
          <input type="submit" name="login_button" value="Se connecter">
          <br>
          <a href="#" id="signup" class="signup">Vous n'avez pas encore de compte ? <strong>Inscrivez-vous !</strong></a>
        </form>
      </div>
      
      <div id="second">
        <!-- FORMULAIRE INSCRIPTION -->
        <form action="register.php" method="POST">
          <input type="text" name="reg_fname" placeholder="Prénom" value="<?php 
          if(isset($_SESSION['reg_fname'])) {
            echo $_SESSION['reg_fname'];
          } 
          ?>" required>
          <br>
          <?php if(in_array("Le prénom doit être compris entre 2 et 25 caractères<br>", $error_array)) echo "Le prénom doit être compris entre 2 et 25 caractères<br>"; ?>
          

          <input type="text" name="reg_lname" placeholder="Nom" value="<?php 
          if(isset($_SESSION['reg_lname'])) {
            echo $_SESSION['reg_lname'];
          } 
          ?>" required>
          <br>
          <?php if(in_array("Le nom doit être compris entre 2 et 25 caractères<br>", $error_array)) echo "Le nom doit être compris entre 2 et 25 caractères<br>"; ?>


          <input type="email" name="reg_email" placeholder="Adresse e-mail" value="<?php 
          if(isset($_SESSION['reg_email'])) {
            echo $_SESSION['reg_email'];
          } 
          ?>" required>
          <br>


          <input type="email" name="reg_email2" placeholder="Confirmer l'e-mail" value="<?php 
          if(isset($_SESSION['reg_email2'])) {
            echo $_SESSION['reg_email2'];
          } 
          ?>" required>
          <br>
          <?php if(in_array("Email déjà utilisé<br>", $error_array)) echo "Email déjà utilisé<br>";
          else if(in_array("Email non valide<br>", $error_array)) echo "Email non valide<br>";
          else if(in_array("Les adresses mails sont différentes<br>", $error_array)) echo "Les adresses mails sont différentes<br>"; ?>

          <input type="password" name="reg_password" placeholder="Mot de passe" required>
          <br>
          <input type="password" name="reg_password2" placeholder="Confirmer le mot de passe" required>
          <br>
          <?php if(in_array("Le mot de passe n'est pas identique<br>", $error_array)) echo "Le mot de passe n'est pas identique<br>";
          else if(in_array("Le mot de passe peut contenir des minuscules, majuscules et des chiffres<br>", $error_array)) echo "Le mot de passe peut contenir des minuscules, majuscules et des chiffres<br>";
          else if(in_array("Le mot de passe doit contenir entre 5 et 30 caractères<br>", $error_array)) echo "Le mot de passe doit contenir entre 5 et 30 caractères<br>"; ?>

          <input type="submit" name="register_button" value="S'inscrire">
          <br>

          <?php if(in_array("<span style='color: #14C800;'>Inscription réussie ! Vous pouvez vous connecter</span><br>", $error_array)) echo "<span style='color: #14C800;'>Inscription réussie ! Vous pouvez vous connecter</span><br>"; ?>
          <a href="#" id="signin" class="signin">Vous avez déjà un compte ? <strong>Connectez-vous !</strong></a>
        </form>
      </div>


    </div>
  </div>
</body>
</html>