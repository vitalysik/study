<?php include "bd.php";?>
<?php session_start()?>
<?php include "form.php";?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Materials</title>
  <link href="style.css" rel="stylesheet">
</head>
<body>
  <div class="wrapper">
    <header class="header">
<div class="aut">
        <?php include "login.php"; ?>
        <?php if (empty($_SESSION['user'])): ?>
          <form action="" method="post">
            Login:<br><input name="login" type="text" size="20" required><br>
            Password:<br><input name="password" type="password" size="20" required><br>
            <input name="submit" type="submit" value="Login">
          </form>
        <?php endif; ?>
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
          SELECT `n`.`id`, `n`.`title`, `n`.`fullnews`, `n`.`date_news`, `u`.`login`
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
            <h2>
              <?php print $row['title']; ?>
            </h2>
            <div>
              <label>Date:</label>
              <span><?php print $row['date_news']; ?></span>
            </div>
            <div>
              <label>Author:</label>
              <span><?php print $row['login']; ?></span>
            </div>
          <p><?php print $row['fullnews']; ?></p>
          <hr>
          <?php if (!empty($_SESSION['user'])): ?>
          <a href="edit.php?id= <?php print $row['id'] ?>">Edit/Delete</a>
          <?php endif; ?>
        <?php endwhile; ?>
      </div>
    </main>
  </div>
  <footer class="footer">

  </footer>
</body>
</html>
