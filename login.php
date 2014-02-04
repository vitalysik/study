<?php
if (isset($_POST['exit'])) {
  unset($_SESSION['user']);
}
?>
<?php
if (!empty($_SESSION['user'])) : ?>
  <form action="" method="post">
  <span>You are logged in as <h4>
  <a href="profile.php?id=<?php print $_SESSION['user']->uid; ?>">
  <?php print $_SESSION['user']->login; ?>
  </a></h4></span>
  <input name="exit" type="submit" value="Logout">
  </form>
<?php endif; ?>
