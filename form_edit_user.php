<?php
include("bd.php");
$uid = $_POST['uid'];
if (!empty($_POST['update'])){
  $name = htmlspecialchars($_POST['name']);
  $sename = htmlspecialchars($_POST['sename']);
  $is_error = FALSE;
  if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $is_error = TRUE;
  }
  else {
    $email = $_POST['email'];
    $res = $db->prepare("SELECT uid FROM `users` WHERE email = :email");
    $res->bindParam(':email', $email);
    $res->execute();

    $row = $res->fetch();
    if (!empty($row) && $row['uid'] != $uid) {
      $is_error = TRUE;
    }
  }
  if (!$is_error) {
    if (!empty($_POST['password'])) {
      $password = base64_encode($_POST['password']);
      $res = $db->prepare("UPDATE `users`
                           SET password = :password,
                               name = :name,
                               sename = :sename,
                               email = :email
                           WHERE uid = :uid");
      $res->bindParam(':password',$password);
    }
    else {
      $res = $db->prepare("UPDATE `users`
                           SET name = :name,
                               sename = :sename,
                               email = :email
                           WHERE uid = :uid");
    }
    $res->bindParam(':name',$name);
    $res->bindParam(':sename',$sename);
    $res->bindParam(':email',$email);
    $res->bindParam(':uid',$uid);
    $res->execute();
    if (!empty($_POST['role'])){
      $r = $db->prepare("UPDATE users SET rid = :rid WHERE uid = :uid");
      $r->bindParam(':rid', $_POST['role']);
      $r->bindParam(':uid', $uid);
      $r->execute();
    }
  }
  header("Location: user.php?id={$uid}");
}
elseif (!empty($_POST['delete'])){
  $del = $db->prepare("DELETE FROM `users` WHERE uid = :uid");
  $del->bindParam(':uid',$uid);
  $del->execute();
  if ($del){
    header("Location: index.php");
  }
}
