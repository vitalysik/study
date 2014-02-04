<?php
include("bd.php");
$id = $_GET['id'];
if (!empty($_POST['update'])){
$title = strip_tags($_POST['title']);
$fullnews = strip_tags($_POST['fullnews']);
$result = $db->prepare("UPDATE news SET title = :title,fullnews = :fullnews WHERE id = :id");
$result->bindParam(':title',$title);
$result->bindParam(':fullnews',$fullnews);
$result->bindParam(':id',$id);
$result->execute();
if ($result)  {
header("Location: view.php?id={$id}");
  }
}
elseif (!empty($_POST['delete'])){
$dell = $db->prepare("DELETE FROM `news` WHERE id = :id");
$dell->bindParam(':id',$id);
$dell->execute();
if ($dell){
header("Location: news.php");
  }
}
