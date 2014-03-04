<?php session_start();
include "functions.php";
?>
<?php if (user_access('blocked')) {
  page_user_blocked();} ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php print t('Edit profile')?></title>
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
      $res = $db->prepare("SELECT * FROM `users` WHERE uid = :uid");
      $res->bindParam(':uid', $uid);
      $res->execute();
      $my = $res->fetch();
      $my['avatar'] = empty($my['avatar']) ? 'image/default.jpg' : $my['avatar'];

      $query = $db->prepare("SELECT * FROM `role` WHERE rid > 1");
      $query->execute();
      $roles = $query->fetchAll();
      ?>
      <?php if (user_access('edit own profile')
      && $my['uid'] == $_SESSION['user']->uid
      || user_access('edit any profile')
      && !empty($_GET['id'])): ?>
      <div>
      <img src="<?php print $my['avatar'] ?>" width="150" height="150">
      </form>
      <form action="loading_image.php" method="post" enctype="multipart/form-data">
      <input type="FILE" name="imgupload">
      <input type="hidden" value="<?php print $uid; ?>" name="uid">
      <input type="submit" value=<?php print t('Download')?>>
      </form>
      </div>
      <form action="form_edit_user.php" method="POST">
      <?php print t('Name')?>: <br><input type="text" name="name" value="<?php print $my['name']; ?>"><br><br>
      <?php print t('Surname')?>: <br><input type="text" name="sename"  value="<?php print $my['sename']; ?>"><br><br>
      <?php print t('Password')?>: <br><input type="password" name="password"><br><br>
      E-mail: <br><input type="text" name="email"  value="<?php print $my['email']; ?>"><br><br>
      <?php if (user_access('admin panel')) : ?>
      <div>
        <select name="role">
          <?php foreach ($roles as $role): ?>
            <?php if ($role['rid'] == $my['rid']) : ?>
              <option selected value="<?php print $role['rid']; ?>"><?php print $role['name']; ?></option>
            <?php else: ?>
              <option value="<?php print $role['rid']; ?>"><?php print $role['name']; ?></option>
            <?php endif; ?>
          <?php endforeach; ?>
        </select>
      </div>
    <?php endif; ?>
      <input type="hidden" value="<?php print $uid; ?>" name="uid">
      <input type="submit" name="update" value=<?php print t('Save')?>>
      <input type="submit" name="delete" value=<?php print t('Delete profile')?>>
      <?php endif; ?>
      </div>
    </main>
  </div>
  <footer class="footer">

  </footer>
</body>
</html>
