<?php
if (isset($_POST['submit'])) {
  $login = $_POST['login'];
  $password = base64_encode($_POST['password']);
  $query = $db->prepare("SELECT * FROM users WHERE `login` = :login AND `password` = :password");
  $query->bindParam(':login', $login);
  $query->bindParam(':password', $password);
  $query->execute();
  $user = $query->fetchObject();
  if (!empty($user) && $user->login == $login) {
    $_SESSION['user'] = $user;
  }
  else {
   echo "Error";
  }
}
