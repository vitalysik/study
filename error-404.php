<?php include "bd.php";
session_start();
include "form_aut.php";
include "functions.php";?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Error-404</title>
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
      <img src="i/pagenotfound.jpg" height="100%" width="100%">
    </main>
  </div>
  <footer class="footer">

  </footer>
</body>
</html>
