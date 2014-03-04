<?php
include "bd.php";
session_start();
include "form_aut.php";
include "functions.php";
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php print t('Registration')?></title>
  <link href="style.css" rel="stylesheet">
  <script src="http://code.jquery.com/jquery-1.10.2.min.js" type="text/javascript"></script>
  <script src="js/my.js" type="text/javascript"></script>
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
        <form action="form_reg.php" method="POST" id="formreg">
          <?php print t('Login')?>:<br><input name="login" type="text" required><br>
          <?php print t('Password')?>:<br><input name="password" type="password" required><br>
          <?php print t('Password again')?>:<br><input name="password2" type="password" required><br>
          E-mail:<br><input name="email" type="text" required><br>
          <input name="submit" type="submit" value=<?php print t('Registration')?>>
        </form>
      </div>
    </main>
  </div>
  <footer class="footer">

  </footer>
</body>
</html>
