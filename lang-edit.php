<?php include "bd.php";
session_start();
include "form_aut.php";
include "functions.php";
if (!user_access('admin panel')) {
  page_access_denied();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php print t('Admin panel')?></title>
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
      <?php
      include "bd.php";
      if (!empty($_POST['update'])){
        foreach ($_POST as $lid => $value) {
          if (is_numeric($lid) && is_array($value)) {
            $en = strip_tags($value['en']);
            $ua = strip_tags($value['ua']);
            $result = $db->prepare("UPDATE lang SET en = :en, ua = :ua
                                    WHERE lid = :lid");
            $result->bindParam(':en', $en);
            $result->bindParam(':ua', $ua);
            $result->bindParam(':lid', $lid);
            $result->execute();
          }
        }
        unset($_POST);
        header('Refresh: 0');
      }
      $query = $db->prepare("SELECT * FROM lang ORDER BY lid DESC");
      $query->execute();
      ?>
      <form action="" method="POST">
        <?php while ($row = $query->fetch()): ?>
          <div class="row">
            <input type="text" name="<?php print $row['lid']; ?>[en]" value="<?php print $row['en']; ?>" required>
            <input type="text" name="<?php print $row['lid']; ?>[ua]" value="<?php print $row['ua']; ?>" required>
          </div>
        <?php endwhile; ?>
        <input type="submit" name="update" value="<?php print t('Save'); ?>">
      </form>
    </main>
  </div>
  <footer class="footer">

  </footer>
</body>
</html>
