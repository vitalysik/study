<?php
include "bd.php";
session_start();
include "form_aut.php";
include_once "functions.php";
if (empty($_GET['id']) || check_materials($_GET['id'])){
  page_not_found();
}
?>
<?php if (user_access('blocked')) page_user_blocked(); ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php print t('View Material')?></title>
  <link href="style.css" rel="stylesheet">
</head>
<body>
  <div class="wrapper">
    <header class="header">
  <div class="aut">
    <?php include "header_login.php"; ?>
  </div>
    </header>
  <div class="menu">
    <?php include "menu.php"; ?>
  </div>
    <main class="content">
  <div>
  <?php
    include("bd.php");
    $id = $_GET['id'];
    $query = $db->prepare("
                          SELECT `n`.`id`, `n`.`title`, `n`.`fullnews`,
                          `n`.`title_ua`, `n`.`fullnews_ua`, `n`.`date_news`,
                          `u`.`login`, `u`.`uid`
                          FROM news AS `n`
                          INNER JOIN users AS `u` ON
                            `u`.`uid` = `n`.`uid`
                          WHERE id = :id
                          ORDER BY `n`.`date_news` DESC
                          ");
    $query->bindParam('id',$id);
    $query->execute();
  ?>
  <?php while ($row = $query->fetch()): ?>
    <?php if (user_access('edit own profile')) : ?>
    <?php delete_rating($_SESSION['user']->uid, $id); ?>
    <?php delete_all_rating($id); ?>
    <?php endif; ?>
    <h2><?php print current_language() == 'ua' ? $row['title_ua'] : $row['title'];?></h2>
    <?php if (empty(count_rating($id))): ?>
      <p><h5><?php print t('For this material has no vote.')?></h5>
    <?php else: ?>
    <div>
      <p><?php print t('Average rating')?>: <?php print avg_rating($id) ?>
    </div>
    <div>
      <p><?php print t('Total number of evaluations')?>: <?php print count_rating($id) ?>
    </div>
    <?php endif; ?>
    <div>
      <label><?php print t('Date')?>:</label>
      <span><?php print $row['date_news']; ?></span>
    </div>
    <div>
      <label><?php print t('Author')?>:</label>
      <span>
        <a href="user.php?id=<?php print $row['uid']; ?>">
        <?php print $row['login']; ?>
        </a>
      </span>
    </div>
    <p><?php print current_language() == 'ua' ? $row['fullnews_ua'] : $row['fullnews']; ?></p>
    <?php if (user_access('edit own article')
    && $row['uid'] == $_SESSION['user']->uid
    || user_access('edit any article')) : ?>
    <p><a href="edit_materials.php?id=<?php print $row['id'] ?>"><?php print t('Edit/Delete')?></a></p>
      <hr>
    <?php endif; ?>
    <?php if (user_access('edit own profile')) : ?>
    <?php if (empty(my_rating($_SESSION['user']->uid, $id))): ?>
    <?php if(!empty($_POST['voted'])) : ?>
      <?php insert_vote() ?>
      <p><?php print t('Thank you for your feedback')?></p>
    <?php else: ?>
     <form action=""  method="POST" >
        <p><b>Оцінка:</b>
         <input type="radio" name="vote" value="1">1
         <input type="radio" name="vote" value="2">2
         <input type="radio" name="vote" value="3">3
         <input type="radio" name="vote" value="4">4
         <input type="radio" name="vote" value="5">5
         <input type="submit" value="Vote" name="voted">
       </form>
    <?php endif; ?>
    <?php else: ?>
      <p><?php print t('Your assessment of the material')?>: <?php print my_rating($_SESSION['user']->uid, $id); ?></p>
      <form action="" method="POST">
        <input type="submit" value="<?php print t('Revote')?>" name="delete">
      </form>
      <?php if (user_access('delete user')) : ?>
      <form action="" method="POST">
        <input type="submit" value="<?php print t('Delete all votes')?>" name="deleteall">
      </form>
      <?php endif; ?>
    <?php endif; ?>
    <?php endif; ?>
  <?php endwhile; ?>
  <hr>
  </div>
  <h2><?php print t('Comments')?></h2>
  <div class="comments">
  <?php
    include("bd.php");
    $lim = 10;
    $page = 1;
    $lang = current_language();
    if (!empty($_GET['page'])) {
      $page = $_GET['page'];
    }
    $res = $db->prepare("SELECT COUNT(*) FROM comments WHERE lang = :lang AND nid = :id");
    $res->bindParam(':id',$id);
    $res->bindParam(':lang',$lang);
    $res->execute();
    $row = $res->fetch();
    $posts = $row[0];
    $str = ceil($posts/$lim);
    if ($page > $str && $str) {
      $page = $str;
    }
    $start = $page * $lim - $lim;
    $query = $db->prepare("
                          SELECT `c`.`cid`, `c`.`nid`, `c`.`uid`,
                          `c`.`topic`, `c`.`text`, `c`.`created`, `c`.`lang`, `u`.`login`
                          FROM comments AS `c`
                          INNER JOIN users AS `u` ON
                          `u`.`uid` = `c`.`uid`
                          INNER JOIN news AS `n` ON
                          `n`.`id` = `c`.`nid`
                          WHERE `n`.`id` = :id and `c`.`lang`= :lang
                          ORDER BY `c`.`created` DESC
                          LIMIT $start, $lim
                          ");
    $query->bindParam(':lang',$lang);
    $query->bindParam(':id',$id);
    $query->execute();
    ?>
    <?php while ($row = $query->fetch()): ?>
        <a id="comment-<?php print $row['cid']; ?>"></a>
        <div>
          <label><?php print t('Date')?>:</label>
          <span><?php print $row['created']; ?></span>
        </div>
        <div>
          <label><?php print t('Author')?>:</label>
          <span>
            <a href="user.php?id=<?php print $row['uid']; ?>">
            <?php print $row['login']; ?>
            </a>
          </span>
        </div>
        <?php
          $arr = explode('<br>', wordwrap($row['text'], 15, '<br>', false));
          $body = $arr[0];
        ?>
        <?php if (empty($row['topic'])) :?>
          <h3><?php print $body; ?></h3>
        <?php else: ?>
          <h3><?php print $row['topic']; ?></h3>
        <?php endif; ?>
        <p><?php print $row['text']; ?></p>
        <?php if (user_access('edit any article')) : ?>
          <p><a href="delete_comment.php?id=<?php print $row['cid']; ?>&nid=<?php print $id; ?>"><?php print t('Delete')?></a></p>
        <?php endif; ?>
      <hr>
    <?php endwhile; ?>
    <ul class="pager">
      <?php if ($page > 1): ?>
        <li><a href="?id=<?php print $id; ?>&page=<?php print $page - 1; ?>"><?php print t('Previous')?></a></li>
      <?php endif; ?>
      <?php if ($str > 1): ?>
        <?php for ($i = 1; $i <= $str; $i++): ?>
          <?php if ($i == $page) : ?>
            <li><strong><a href="?id=<?php print $id; ?>&page=<?php print $i; ?>"><?php print $i; ?></a></strong></li>
          <?php else : ?>
            <li><a href="?id=<?php print $id; ?>&page=<?php print $i; ?>"><?php print $i; ?></a></li>
          <?php endif; ?>
        <?php endfor; ?>
        <?php if ($page < $str) : ?>
          <a href="?id=<?php print $id; ?>&page=<?php print $page + 1; ?>"><?php print t('Next')?></a>
        <?php endif; ?>
      <?php endif; ?>
    </ul>
    <?php if (user_access('edit own profile')) : ?>
      <form action="form_comments.php" method="POST">
        Topic:<div><input type="text" name="topic"></div>
        <input type="hidden" name="nid" value="<?php print $id; ?>">
        Text:<div><textarea name="text" cols="50" rows="10" required></textarea></div>
        <input type="submit" value="<?php print t('Add comment') ?>" name="add_comment">
      </form>
      <?php endif;?>
      </div>
    </main>
  </div>
  <footer class="footer">

  </footer>
</body>
</html>
