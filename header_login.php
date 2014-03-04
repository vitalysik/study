<?php
if (isset($_POST['exit'])) {
  unset($_SESSION['user']);
  header("Location: index.php");
}
?>
<?php
  if (!empty($_POST['lang'])) {
    $_SESSION['lang'] = empty($_SESSION['lang']) ? 'en' : $_POST['lang'];
  }
?>
<div id="lang">
  <form action="" method="POST">
    <input class="en" type="submit" name="lang" value="en">
    <input class="ua" type="submit" name="lang" value="ua">
  </form>
</div>
<?php if (user_access('view form login')): ?>
  <form action="" method="post">
    <?php print t('Login')?>:<br><input name="login" type="text" size="20" required><br>
    <?php print t('Password')?>:<br><input name="password" type="password" size="20" required><br>
    <input name="submit" type="submit" value="<?php print t('Sign in')?>">
    <a href="reg.php"><?php print t('Registration')?></a>
  </form>
<?php else: ?>
  <form class="paut" action="" method="post">
    <span><?php print t('You are logged in as')?> <h4>
    <a href="user.php?id=<?php print $_SESSION['user']->uid; ?>">
    <?php print $_SESSION['user']->login; ?>
    </a></h4></span>
    <input name="exit" type="submit" value=<?php print t('Logout')?>>
  </form>
<?php endif; ?>
