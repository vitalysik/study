<?php session_start()?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Edit</title>
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
          <span><?php header('Refresh: 3; URL=index.php');?>Oops! Edit profile can only registered users!
          <h5>Now you will be redirected to the home page</h5></span>
        </div>
      <?php endif; ?>
      <?php if (!empty($_SESSION['user']) && !empty($_GET['id'])): ?>
      <?php
      include "bd.php";
      $uid = $_GET['id'];
      $res = $db->prepare("SELECT * FROM `users` WHERE uid = :uid");
      $res->bindParam(':uid', $uid);
      $res->execute();
      $my = $res->fetch();
      ?>
      <form action="editp.php?uid=<?php print $my['uid']; ?>" method="POST">
      Name: <br><input type="text" name="name" value="<?php print $my['name']; ?>" required><br><br>
      Second name: <br><input type="text" name="sename"  value="<?php print $my['sename']; ?>" required><br><br>
      Password: <br><input type="password" name="password"><br><br>
      Email: <br><input type="text" name="email"  value="<?php print $my['email']; ?>" required><br><br>
      <input type="submit" name="update" value="Save">
      </form>
      <?php endif; ?>
      </div>
    </main>
  </div>
  <footer class="footer">

  </footer>
</body>
</html>
