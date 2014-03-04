<?php
session_start();
include "bd.php";
if(isset($_POST['submit'])) {
  $query = $db->prepare("SELECT * FROM `users`  WHERE `login`= :login");
  $query->bindParam(':login',$_POST['login']);
  $query->execute();
  $row = $query->fetch();
  if(!preg_match('/[a-zA-Zа-яА-Я]/', $_POST['login'])) {
    echo "The username contains an illegal character";
  }
  elseif ($row > 0) {
    echo "This login is already exists";
  }
  elseif($_POST['password'] != $_POST['password2']) {
    echo "Passwords do not match";
  }
  elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    echo "Error mail";
  }
  else {
    $login = strip_tags($_POST['login']);
    $password = base64_encode($_POST['password']);
    $email = $_POST['email'];
    $insert = $db->prepare("INSERT INTO `users` (login, password, email, created) VALUES (:login, :password, :email, :created)");
    $insert->bindParam(':login', $login);
    $insert->bindParam(':password', $password);
    $insert->bindParam(':email', $email);
    $insert->bindParam(':created', $created);
    $insert->execute();
    if ($insert) {
      $id = $db->lastInsertId();
      $query = $db->prepare("SELECT * FROM users WHERE `uid` = :uid");
      $query->bindParam(':uid', $id);
      $query->execute();
      $user = $query->fetchObject();
      $_SESSION['user'] = $user;
      header('Location: index.php');
    }
    else {
      echo "Error";
      header('Location: reg.php');
    }
  }
}
?>
