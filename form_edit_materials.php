<?php
include("bd.php");
$id = $_GET['id'];
if (!empty($_POST['update'])){
  $title = htmlspecialchars($_POST['title']);
  $fullnews = htmlspecialchars($_POST['fullnews']);
  $title_ua = htmlspecialchars($_POST['title_ua']);
  $fullnews_ua = htmlspecialchars($_POST['fullnews_ua']);
  $result = $db->prepare("
                          UPDATE news SET title = :title,
                          fullnews = :fullnews,
                          title_ua = :title_ua,
                          fullnews_ua = :fullnews_ua
                          WHERE id = :id
                        ");
  $result->bindParam(':title',$title);
  $result->bindParam(':title_ua',$title_ua);
  $result->bindParam(':fullnews',$fullnews);
  $result->bindParam(':fullnews_ua',$fullnews_ua);
  $result->bindParam(':id',$id);
  $result->execute();
  if ($result){
    header("Location: view_materials.php?id={$id}");
  }
}
elseif (!empty($_POST['delete'])){
  $dell = $db->prepare("DELETE FROM `news` WHERE id = :id");
  $dell->bindParam(':id',$id);
  $dell->execute();
  if ($dell){
    header("Location: materials.php");
    }
}
