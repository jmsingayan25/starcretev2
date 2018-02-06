<?php
  include('includes/config.php');
  session_start();

  $user_check = $_SESSION['login_user'];
  $sql = "SELECT username, office FROM users WHERE username = '$user_check'";
  $result = mysqli_query($db, $sql);
  $row = mysqli_fetch_assoc($result);
  $login_session = $row['username'];

  if(!isset($_SESSION['login_user'])){
    header("location: index.php");
  }
?>
