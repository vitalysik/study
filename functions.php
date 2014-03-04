<?php

/**
 * @file
 * Functions list.
 */

/**
 * Render page not found.
 */
function page_not_found() {
  header('Location: error-404.php');
}

/**
 * Render page access denied.
 */
function page_access_denied() {
  header('Location: error-403.php');
}
/**
 * Reader page user is blocked.
 */
function page_user_blocked() {
  header('Location: user-blocked.php');
}

/**
 * Check user id.
 */
function check_user($uid) {
  include "bd.php";
  $query = $db->prepare("SELECT * FROM users WHERE uid = :uid");
  $query->bindParam('uid',$uid);
  $query->execute();
  $row = $query->fetch();
  return empty($row);
}

/**
 * Check materials id.
 */
function check_materials($id) {
  include "bd.php";
  $query = $db->prepare("SELECT * FROM news WHERE id = :id");
  $query->bindParam('id',$id);
  $query->execute();
  $row = $query->fetch();
  return empty($row);
}

/**
 * Check permission in current user.
 */
function user_access($permission) {
  include "bd.php";
  if (empty($_SESSION['user']->uid)) {
    $rid = 1;
    $query = $db->prepare("SELECT `rp`.`pid` FROM role AS `r`
                          INNER JOIN role_permission AS `rp` ON `rp`.`rid` = `r`.`rid`
                          WHERE `r`.`rid` = :rid AND `rp`.`name` = :permission");
    $query->bindParam(':rid', $rid);
    $query->bindParam(':permission', $permission);
    $query->execute();
    $row = $query->fetch();
  }
  else {
    $uid = $_SESSION['user']->uid;
    $query = $db->prepare("SELECT `rp`.`pid` FROM users AS `u`
                          INNER JOIN role AS `r` ON `r`.`rid` = `u`.`rid`
                          INNER JOIN role_permission AS `rp` ON `rp`.`rid` = `r`.`rid`
                          WHERE `u`.`uid` = :uid AND `rp`.`name` = :permission");
    $query->bindParam(':uid', $uid);
    $query->bindParam(':permission', $permission);
    $query->execute();
    $row = $query->fetch();
  }
  return !empty($row['pid']);
}

/**
 * Translate text.
 */
function t($str = '') {
  include "bd.php";
  $lang = empty($_SESSION['lang']) ? 'en' : $_SESSION['lang'];
  $query = $db->prepare("SELECT * FROM lang WHERE en = :en");
  $query->bindParam(':en', $str);
  $query->execute();
  $res = $query->fetch();

  return empty($res[$lang]) ? '' : $res[$lang];
}

/**
 * Get current language.
 */
function current_language() {
  return empty($_SESSION['lang']) ? 'en' : $_SESSION['lang'];
}

/**
 * Voting.
 */
function insert_vote(){
  include "bd.php";
  if (!empty($_POST['voted'])) {
  $uid = $_SESSION['user']->uid;
  $nid = $_GET['id'];
  $rating = $_POST['vote'];
  $query = $db->prepare("INSERT INTO vote (uid, nid, rating) VALUES (:uid, :nid, :rating)");
  $query->bindParam(':uid', $uid);
  $query->bindParam(':nid', $nid);
  $query->bindParam(':rating', $rating);
  $query->execute();
  }
  header("Refresh:1");
}
/**
 * My rating.
 */
function my_rating($uid, $nid){
  include "bd.php";
  $query = $db->prepare("SELECT rating FROM vote WHERE uid = :uid AND nid = :nid");
  $query->bindParam(':uid', $uid);
  $query->bindParam(':nid', $nid);
  $query->execute();
  $row = $query->fetchColumn();
  return $row;
}
/**
 * AVG vote.
 */
function avg_rating($nid){
  include "bd.php";
  $query = $db->prepare("SELECT AVG(`rating`) AS `rating` FROM `vote` WHERE `nid` = :nid");
  $query->bindParam(':nid', $nid);
  $query->execute();
  $row = $query->fetch();
  return round($row['rating'], 2);
}
/**
 * Count vote.
 */
function count_rating($nid){
  include "bd.php";
  $query = $db->prepare("SELECT COUNT(`rating`) AS `rating` FROM `vote` WHERE `nid` = :nid");
  $query->bindParam(':nid', $nid);
  $query->execute();
  $row = $query->fetch();
  return $row['rating'];
}
/**
 * Delete my rating.
 */
function delete_rating($uid, $nid){
  include "bd.php";
  if (!empty($_POST['delete'])) {
  $query = $db->prepare("DELETE FROM vote WHERE uid = :uid AND nid = :nid");
  $query->bindParam(':uid', $uid);
  $query->bindParam(':nid', $nid);
  $query->execute();
  }
}
/**
 * Delete all rating.
 */
function delete_all_rating($nid){
  include "bd.php";
  if (!empty($_POST['deleteall'])) {
  $query = $db->prepare("DELETE FROM vote WHERE nid = :nid");
  $query->bindParam(':nid', $nid);
  $query->execute();
  }
}

