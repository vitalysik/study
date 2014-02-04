<?php session_start()?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit materials</title>
  <link href="style.css" rel="stylesheet">
</head>
<body>
  <div class="wrapper">
    <header class="header">
    <div class="aut">
        <?php include "login.php"; ?>
      </div>
    </header>
      <div class="menu">
      <?php include "menu.php"; ?>
      </div>
    <main class="content">
      <div class="edit_news">
      <?php if (empty($_SESSION['user'])) : ?>
        <div class="no_aut_edit">
          <span><?php header('Refresh: 3; URL=index.php');?>Oops! Edit material can only registered users!
          <h5>Now you will be redirected to the home page</h5></span>
        </div>
      <?php endif; ?>
      <?php if (!empty($_SESSION['user'])): ?>
      <?php
      include "bd.php";
      $id = $_GET['id'];
      $result = $db->prepare("SELECT * FROM news WHERE id = :id");
      $result->bindParam(':id', $id);
      $result->execute();
      $myraa = $result->fetch();
      ?>
        <form action="update.php?id=<?php print $myraa['id']; ?>" method="POST">
        Title: <br><input type="text" name="title" value="<?php print $myraa['title']; ?>" required><br><br>
        Text: <br><textarea name="fullnews" cols="40" rows="7" required><?php print $myraa['fullnews'];?></textarea><br><br>
        <input type="submit" name="update" value="Save material">
        <input type="submit" name="delete" value="Delete material">
        </form>
      <?php endif; ?>
      </div>
    </main>
  </div>
  <footer class="footer">

  </footer>
</body>
</html>
