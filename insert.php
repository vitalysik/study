<?php
  session_start();
  include("bd.php");
  $title = strip_tags($_POST['title']);
  $uid = $_SESSION['user']->uid;
  $fullnews = strip_tags($_POST['fullnews']);
  $res = $db->prepare("INSERT INTO `news` (uid, title, fullnews)
  VALUES (:uid, :title,:fullnews)");
  $res->bindParam(':uid', $uid);
  $res->bindParam(':title', $title);
  $res->bindParam(':fullnews', $fullnews);
  $res->execute();
  if ($res && ($id = $db->lastInsertId())) {
    header("Location: view.php?id=" . $id);
  }
?>
