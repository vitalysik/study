<?php
include "bd.php";
$nid = $_GET['nid'];
$cid = $_GET['id'];
$dell = $db->prepare("DELETE FROM `comments` WHERE cid = :cid");
$dell->bindParam(':cid',$cid);
$dell->execute();
if ($dell) {
  header("Location: view_materials.php?id={$nid}");
}

