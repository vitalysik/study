<?php include "bd.php";?>
<?php session_start(); ?>
<?php include "form.php";?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Home</title>
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
            <a href="reg.php">Registration</a>
          </form>
        <?php endif; ?>
      </div>
  	</header>
  <div class="menu">
<?php include "menu.php"; ?>
  </div>
  	<main class="content"></main>
  </div>
  <footer class="footer">

  </footer>
</body>
</html>
