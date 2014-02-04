<?php
include "bd.php";
if(isset($_POST['submit'])){
  $query = $db->prepare("SELECT * FROM `users`  WHERE `login`= :login");
  $query->bindParam(':login',$_POST['login']);
  $query->execute();
  $row = $query->fetch();
  if(!preg_match("/[-a-zA-Z0-9]{3,15}/", $_POST['login'])){
  echo "Error";
  }
  elseif ($row > 0){
    echo "Error";
  }
  elseif($_POST['password'] != $_POST['password2']){
    echo "Error";
  }
  elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    echo "Error";
  }
  else {
    $login = $_POST['login'];
    $password = base64_encode($_POST['password']);
    $email = $_POST['email'];
    $insert = $db->prepare("INSERT INTO `users` (login ,password ,email) VALUES (:login, :password, :email)");
    $insert->bindParam(':login', $login);
    $insert->bindParam(':password', $password);
    $insert->bindParam(':email', $email);
    $insert->execute();
    if($insert == true){
      echo "Registration is complete";
      header('Refresh: 3; URL=index.php');
    }
    else {
      echo "Error";
    }
  }
}
?>
