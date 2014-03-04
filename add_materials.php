<?php
session_start();
include "functions.php";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php print t('Add materials') ?></title>
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
    <?php if (!user_access('add own article')){page_access_denied();}?>
      <div>
        <form action="form_materials.php" method="POST">
          Title: <br><input type="text" name="title" required><br><br>
          Text: <br><textarea name="fullnews" cols=40 rows=7 required></textarea><br><br>
          Заголовок: <br><input type="text" name="title_ua" required><br><br>
          Текст: <br><textarea name="fullnews_ua" cols=40 rows=7 required></textarea><br><br>
          <input type="submit" value=<?php print t('Add materials')?>>
        </form>
      </div>
    </main>
  </div>
  <footer class="footer">

  </footer>
</body>
</html>
