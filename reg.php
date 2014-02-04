<?php include "bd.php";?>
<?php session_start(); ?>
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
    </header>
  <div class="menu">
    <?php include "menu.php"; ?>
  </div>
    <main class="content">
      <div>
        <form action="form_reg.php" method="POST">
          Login:<br><input name="login" type="text" required><br>
          Password:<br><input name="password" type="password" required><br>
          Password again:<br><input name="password2" type="password" required><br>
          E-mail:<br><input name="email" type="text" required><br>
          <input name="submit" type="submit" value="Register">
        </form>
      </div>
    </main>
  </div>
  <footer class="footer">

  </footer>
</body>
</html>
