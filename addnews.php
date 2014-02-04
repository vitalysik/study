<?php session_start()?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add materials</title>
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
      <?php if (empty($_SESSION['user'])) : ?>
        <div class="no_aut">
          <span><?php header('Refresh: 3; URL=index.php');?> Oops! Add material can only registered users!
          <h5>Now you will be redirected to the home page</h5></span>
        </div>
      <?php endif; ?>
      <?php if (!empty($_SESSION['user'])): ?>
      <div class="addnews">
        <form action="insert.php" method="POST">
          Title: <br><input type="text" name="title" required><br><br>
          Text: <br><textarea name="fullnews" cols=40 rows=7 required></textarea><br><br>
          <input type="submit" value="Add material">
          <?php endif; ?>
        </form>
      </div>
    </main>
  </div>
  <footer class="footer">

  </footer>
</body>
</html>
