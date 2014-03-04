<?php
include "bd.php";
session_start();
include "form_aut.php";
include_once "functions.php";
if (empty($_GET['id']) || check_user($_GET['id'])){
  page_not_found();
}
?>
<?php if (user_access('blocked')) {
  page_user_blocked();} ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php print t('User')?></title>
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
      <div class="edit_news">
      <?php
        include "bd.php";
        $uid = $_GET['id'];
        $query = $db->prepare("
        SELECT `name`, `sename`, `email`, `created`, `avatar`, `access`, `uid`
        FROM users
        WHERE uid = :uid
        ");
      $query->bindParam('uid',$uid);
      $query->execute();
      ?>
        <?php while ($row = $query->fetch()): ?>
            <?php $row['avatar'] = empty($row['avatar']) ? 'image/default.jpg' : $row['avatar']; ?>
            <div>
              <img src="<?php print $row['avatar'] ?>" width="150" height="150">
            </div>
      <?php if (user_access('view mail')) : ?>
            <div>
              <label>E-mail:</label>
              <span><?php print $row['email']; ?></span>
            </div>
      <?php endif; ?>
            <div>
              <label><?php print t('Surname')?>:</label>
              <span><?php print $row['sename']; ?></span>
            </div>
            <div>
              <label><?php print t('Name')?>:</label>
              <span><?php print $row['name']; ?></span>
            </div>
            <div>
              <label><?php print t('User created')?>:</label>
              <span><?php print $row['created']; ?></span>
            </div>
            <div>
              <label><?php print t('Last login')?>:</label>
              <span><?php print $row['access']; ?></span>
            </div>
          <?php if (user_access('edit own profile') && $row['uid'] == $_SESSION['user']->uid || user_access('edit any profile')) : ?>
          <a href="user_edit.php?id=<?php print $uid ?>"><?php print t('Edit profile')?></a>
          <?php endif; ?>
        <?php endwhile; ?>
      </div>
    </main>
  </div>
  <footer class="footer">

  </footer>
</body>
</html>
