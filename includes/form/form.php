<?php
// Déclarer les variables
$fname = "";
$lname = "";
$email = "";
$email2 = "";
$password = "";
$password2 = "";
$date = "";
$error_array = array();

if(isset($_POST['register_button'])) {
  // Enregistrer les valeurs du formulaire

  // Prénom
  $fname = strip_tags($_POST['reg_fname']); // Enlever html tags
  $fname = str_replace(' ', '', $fname); // Enlever espaces
  $fname = ucfirst(strtolower($fname)); // Première lettre en majuscule
  $_SESSION['reg_fname'] = $fname; // Stocker le prénom dans une variable session

  // Nom
  $lname = strip_tags($_POST['reg_lname']);
  $lname = str_replace(' ', '', $lname);
  $lname = ucfirst(strtolower($lname));
  $_SESSION['reg_lname'] = $lname;

  // Email
  $email = strip_tags($_POST['reg_email']);
  $email = str_replace(' ', '', $email);
  $email = ucfirst(strtolower($email));
  $_SESSION['reg_email'] = $email;

  // Email 2
  $email2 = strip_tags($_POST['reg_email2']);
  $email2 = str_replace(' ', '', $email2);
  $email2 = ucfirst(strtolower($email2));
  $_SESSION['reg_email2'] = $email2;

  // Mot de passe
  $password = strip_tags($_POST['reg_password']);

  // Mot de passe 2
  $password2 = strip_tags($_POST['reg_password2']);

  $date = date("Y-m-d");

  if($email == $email2) {
    // Vérifiez si l'email est valide
    if(filter_var($email, FILTER_VALIDATE_EMAIL)) {

      $email = filter_var($email, FILTER_VALIDATE_EMAIL);

      // Regarder si l'email existe déjà
      $e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$email'");

      // Compter le nombre de lignes retournées
      $num_rows = mysqli_num_rows($e_check);

      if($num_rows > 0) {
        array_push($error_array, "Email déjà utilisé<br>");
      }
      
    } else {
      array_push($error_array, "Email non valide<br>");
    }

  } else {
    array_push($error_array, "Les adresses mails sont différentes<br>");
  }

  if(strlen($fname) > 25 || strlen($fname) < 2) {
    array_push($error_array, "Le prénom doit être compris entre 2 et 25 caractères<br>");
  }
  if(strlen($lname) > 25 || strlen($lname) < 2) {
    array_push($error_array, "Le nom doit être compris entre 2 et 25 caractères<br>");
  }
  if($password != $password2) {
    array_push($error_array, "Le mot de passe n'est pas identique<br>");
  }
  else {
    if(preg_match('/[^A-Za-z0-9]/', $password)) {
      array_push($error_array, "Le mot de passe peut contenir des minuscules, majuscules et des chiffres<br>");
    }
  }
  if(strlen($password > 30 || strlen($password) < 5)) {
    array_push($error_array, "Le mot de passe doit contenir entre 5 et 30 caractères<br>");
  }

  if(empty($error_array)) {
    //Crypter mdp
    $password = md5($password);

    //Générer le nom de l'utilisateur
    $username = strtolower($fname . "_" . $lname);
    $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");

    $i = 0;
    // Si l'utilisateur existe, ajouter un nombre au nom de l'utilisateur
    while(mysqli_num_rows($check_username_query) != 0) {
      $i++;
      $username = $username . "_" . $i;
      $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
    }

    // Photo de profil
    $rand = rand(1, 6);

    if($rand == 1) {
      $profile_pic = "assets/images/profile_pics/defaults/picture01.jpg";
    }
    else if($rand == 2) {
      $profile_pic = "assets/images/profile_pics/defaults/picture02.jpg";
    }
    else if($rand == 3) {
      $profile_pic = "assets/images/profile_pics/defaults/picture03.jpg";
    }
    else if($rand == 4) {
      $profile_pic = "assets/images/profile_pics/defaults/picture04.jpg";
    }
    else if($rand == 5) {
      $profile_pic = "assets/images/profile_pics/defaults/picture05.jpg";
    }
    else {
      $profile_pic = "assets/images/profile_pics/defaults/picture06.jpg";
    }
    

      $query = mysqli_query($con, "INSERT INTO users VALUES ('', '$fname', '$lname', '$username', '$email', '$password', '$date', '$profile_pic', '0', '0', 'no', ',')");

      array_push($error_array, "<span style='color: #14C800;'>Inscription réussie ! Vous pouvez vous connecter</span><br>");

      //Vider les inputs du formulaire
      $_SESSION['reg_fname'] = "";
      $_SESSION['reg_lname'] = "";
      $_SESSION['reg_email'] = "";
      $_SESSION['reg_email2'] = "";
  }
}
?>