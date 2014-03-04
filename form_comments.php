<?php
include "functions.php";
session_start();
  include("bd.php");
  if (!empty($_POST['add_comment'])) {
    $nid = $_POST['nid'];
    $uid = $_SESSION['user']->uid;
    $topic = htmlspecialchars($_POST['topic']);
    $text = htmlspecialchars($_POST['text']);
    $lang = current_language();
    $res = $db->prepare("INSERT INTO comments (topic, text, nid, uid, lang)
    VALUES (:topic, :text, :nid, :uid, :lang)");
    $res->bindParam(':topic', $topic);
    $res->bindParam(':text', $text);
    $res->bindParam(':nid', $nid);
    $res->bindParam(':uid', $uid);
    $res->bindParam(':lang', $lang);
    $res->execute();
    header("Location: view_materials.php?id=$nid");

}

