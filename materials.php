<?php include "bd.php";
session_start();
include "form_aut.php";
include "functions.php";
?>
<?php if (user_access('blocked')) {
  page_user_blocked();} ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php print t('Materials')?></title>
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
        $lim = 10;
        $page = 1;
        if (!empty($_GET['page'])) {
          $page = $_GET['page'];
        }
        $res = $db->prepare("SELECT COUNT(*) FROM news");
        $res->execute();
        $row = $res->fetch();
        $posts = $row[0];
        $str = ceil($posts/$lim);
        if ($page > $str) {
          $page = $str;
        }
        $start = $page * $lim - $lim;
        $query = $db->prepare("
          SELECT `n`.`id`, `n`.`title`, `n`.`fullnews`,
          `n`.`title_ua`, `n`.`fullnews_ua`,
          `n`.`date_news`, `u`.`login`, `u`.`uid`
          FROM news AS `n`
          INNER JOIN users AS `u` ON
            `u`.`uid` = `n`.`uid`
          ORDER BY `n`.`date_news` DESC
          LIMIT $start, $lim");
        $query->execute();
        ?>
        <!-- View article. -->
        <?php while ($row = $query->fetch()): ?>
        <?php if (user_access('edit own article')
         || user_access('edit any article')
         || user_access('access article')
         || !user_access('access article')) : ?>
            <h2>
            <a href="view_materials.php?id=<?php print $row['id']; ?>">
              <?php print current_language() == 'ua' ? $row['title_ua'] : $row['title']; ?>
            </a>
          </h2>
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
            <?php
              $text = current_language() == 'ua' ? $row['fullnews_ua'] : $row['fullnews'];
              $lenght = 150;
              $body = mb_substr($text, 0, $lenght);
              if (mb_strlen($text) > $lenght) {
                $body .= '...<a href="view_materials.php?id=' . $row['id'] . '">' . t('Read more') . '</a>';
              }
            ?>
            <p><?php print $body; ?></p>
          <hr>
        <?php endwhile; ?>
        <!-- Build pager.  -->
        <ul class="pager">
          <?php if ($page > 1): ?>
            <li><a href="?page=<?php print $page - 1; ?>"><?php print t('Previous')?></a></li>
          <?php endif; ?>
          <?php for ($i = 1; $i <= $str; $i++): ?>
            <?php if ($i == $page) : ?>
              <li><strong><a href="?page=<?php print $i; ?>"><?php print $i; ?></a></strong></li>
            <?php else : ?>
              <li><a href="?page=<?php print $i; ?>"><?php print $i; ?></a></li>
            <?php endif; ?>
          <?php endfor; ?>
          <?php if ($page < $str) : ?>
            <a href="?page=<?php print $page + 1; ?>"><?php print t('Next')?></a>
          <?php endif; ?>
        </ul>
      </div>
    </main>
  </div>
  <footer class="footer">

  </footer>
</body>
</html>
