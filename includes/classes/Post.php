<?php
class Post {
  private $user_obj;
  private $con;

  public function __construct($con, $user) {
    $this->con = $con;
    $this->user_obj = new User($con, $user);
  }

  public function submitPost($body, $user_to) {
    $body = strip_tags($body); // Enlever balises html
    $body = mysqli_real_escape_string($this->con, $body);
    $check_empty = preg_replace('/\s+/','', $body);

    if($check_empty != "") {

      // Date et heure
      $date_added = date("Y-m-d H:i:s");

      // Get username
      $added_by = $this->user_obj->getUsername();

      // Si l'utilisateur n'est pas sur son profil il n'y a pas de user_to
      if($user_to == $added_by) {
        $user_to = "none";
      }

      // Faire un post
      $query = mysqli_query($this->con, "INSERT INTO posts VALUES('', '$body', '$added_by', '$user_to', '$date_added', 'no', 'no', '0')");
      $returned_id = mysqli_insert_id($this->con);

      //Update le post
      $num_posts = $this->user_obj->getNumPosts();
      $num_posts++;
      $update_query = mysqli_query($this->con, "UPDATE users SET num_posts='$num_posts' WHERE username='$added_by'");
    }
  }

  // Afficher les posts !!
  public function loadPostsFriends() {
    $str = ""; // Pour retourner une string
    $data = mysqli_query($this->con, "SELECT * FROM posts WHERE deleted='no' ORDER BY id DESC");

    while($row = mysqli_fetch_array($data)) {
      $id = $row['id'];
      $body = $row['body'];
      $added_by = $row['added_by'];
      $date_time = $row['date_added'];

      // user_to
      if($row['user_to'] == "none") {
        $user_to = "";
      } else {
        $user_to_obj = new User($con, $row['user_to']);
        $user_to_name = $user_to_obj->getFirstAndLastName();
        $user_to = "à <a href='" . $row['user_to'] ."'>" . $user_to_name . "</a>";
      }

      // Vérifiez que l'utilisateur qui a posté n'a pas sa session expirée
      $added_by_obj = new User($this->con, $added_by);
      if($added_by_obj->isClosed()) {
        continue;
      }

      $user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
      $user_row = mysqli_fetch_array($user_details_query);
      $first_name = $user_row['first_name'];
      $last_name = $user_row['last_name'];
      $profile_pic = $user_row['profile_pic'];

      // Ajout depuis combien de temps la publication a été publiée
      $date_time_now = date("Y-m-d H:i:s");
      $start_date = new DateTime($date_time);
      $end_date = new DateTime($date_time_now);
      $interval = $start_date->diff($end_date);
      if($interval->y >= 1) {
        if($interval == 1)
          $time_message = $interval->y . " an";
        else
          $time_message = $interval->y . " ans";
      }
      else if($interval-> m >= 1) {
        if($interval->d == 0) {
          $days = " ago";
        }
        else if($interval->d == 1) {
          $days = $interval->d . " jour";
        }
        else {
          $days = $interval->d . " jours";
        }

        if($interval->m == 1) {
          $time_message = $interval->m . " mois" . $days;
        }
        else {
          $time_message = $interval->m . " mois" . $days;
        }
      }
      else if($interval->d >= 1) {
        if($interval->d == 1) {
          $time_message = "Hier";
        }
        else {
          $time_message = $interval->d . " jours";
        }
      }
      else if($interval->h >= 1) {
        if($interval->h == 1) {
          $time_message = $interval->h . " heure";
        }
        else {
          $time_message = $interval->h . " heures";
        }
      }
      else if($interval->i >= 1) {
        if($interval->i == 1) {
          $time_message = $interval->i . " minute";
        }
        else {
          $time_message = $interval->i . " minutes";
        }
      }
      else {
        if($interval->s < 30) {
          $time_message = "À l'instant";
        }
        else {
          $time_message = $interval->s . " secondes";
        }
      }

      $str .= "<div class='status_post'>
                <div class='post_profile_pic'>
                  <img src='$profile_pic' width='50'>
                </div>
                <div class='posted_by' style='color: #B3B3B3;'>
                  <a href='$added_by'> $first_name $last_name </a> $user_to &nbsp;&nbsp;&nbsp;&nbsp;$time_message
                </div>
                <div id='post_body'>
                  $body
                  <br>
                </div>

              </div>
              <hr>";
    }
    echo $str;
  }

}

?>