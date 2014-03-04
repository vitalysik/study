<?php include "bd.php";
session_start();
include "form_aut.php";
include "functions.php";?>
<?php if (user_access('blocked')) {
  page_user_blocked();} ?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv = "content-type" content = "text/html; charset = utf8">
	<title><?php print t('Home'); ?></title>
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
      <img src="i/content.jpg" height="100%" width="100%">
    </main>
  </div>
  <footer class="footer">

  </footer>
</body>
</html>
