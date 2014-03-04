<?php session_start();
include "functions.php";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php print t('Edit materials')?></title>
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
      <div class="edit_news">
      <?php if (!user_access('add own article')){page_access_denied();}?>
      <?php if (user_access('add own article')): ?>
      <?php
      include "bd.php";
      $id = $_GET['id'];
      $result = $db->prepare("SELECT * FROM news WHERE id = :id");
      $result->bindParam(':id', $id);
      $result->execute();
      $myraa = $result->fetch();
      ?>
        <form action="form_edit_materials.php?id=<?php print $myraa['id']; ?>" method="POST">
        Title: <br><input type="text" name="title" value="<?php print $myraa['title']; ?>" required><br><br>
        Text: <br><textarea name="fullnews" cols="40" rows="7" required><?php print $myraa['fullnews'];?></textarea><br><br>
        Заголовок: <br><input type="text" name="title_ua" value="<?php print $myraa['title_ua']; ?>" required><br><br>
        Текст: <br><textarea name="fullnews_ua" cols="40" rows="7" required><?php print $myraa['fullnews_ua'];?></textarea><br><br>
        <input type="submit" name="update" value="<?php print t('Save')?>">
        <input type="submit" name="delete" value="<?php print t('Delete')?>">
      <?php endif; ?>
      </div>
    </main>
  </div>
  <footer class="footer">

  </footer>
</body>
</html>
