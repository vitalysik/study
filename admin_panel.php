<?php include "bd.php";
session_start();
include "form_aut.php";
include "functions.php";?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php print t('Admin panel')?></title>
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
    <p>
    <a href="lang-edit.php"><?php print t('Translation editing elements of the site') ?></a>
      </p>
      <p> <?php print t('Users') ?> :</p>
      <?php
      include "bd.php";
      $query = $db->prepare("
                            SELECT `u`.`uid`, `u`.`login`
                            FROM users AS `u`
                            ORDER BY `u`.`uid` DESC
                            ");
      $query->execute();
      ?>
      <?php while ($row = $query->fetch()): ?>
        <?php if (user_access('admin panel')) : ?>
          <ul>
            <li>
              <?php print $row['login']; ?>
                <a
                  href="user_edit.php?id=<?php print $row['uid']; ?>"><?php print t('Edit user')?>
                </a>
            </li>
          </ul>
        <?php else: ?>
          <?php page_access_denied() ?>
        <?php endif; ?>
        <?php endwhile; ?>
    </main>
  </div>
  <footer class="footer">

  </footer>
</body>
</html>
