<?php
  session_start();
  include("bd.php");
  $uid = $_SESSION['user']->uid;
  $title = htmlspecialchars($_POST['title']);
  $fullnews = htmlspecialchars($_POST['fullnews']);
  $title_ua = htmlspecialchars($_POST['title_ua']);
  $fullnews_ua = htmlspecialchars($_POST['fullnews_ua']);
  $res = $db->prepare("INSERT INTO `news` (uid, title, fullnews, title_ua, fullnews_ua)
  VALUES (:uid, :title, :fullnews, :title_ua, :fullnews_ua)");
  $res->bindParam(':uid', $uid);
  $res->bindParam(':title', $title);
  $res->bindParam(':fullnews', $fullnews);
  $res->bindParam(':title_ua', $title_ua);
  $res->bindParam(':fullnews_ua', $fullnews_ua);
  $res->execute();
  if ($res && ($id = $db->lastInsertId())) {
    header("Location: view_materials.php?id=" . $id);
  }
?>
