<?php include "bd.php";?>
<?php session_start()?>
<?php include "form.php";?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Materials</title>
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
          </form>
        <?php endif; ?>
      </div>
    </header>
      <div class="menu">
      <?php include "menu.php"; ?>
      </div>
    <main class="content">
      <div>
        <?php
        include("bd.php");
        $lim = 5;
        $page = 1;
        if (!empty($_GET['page'])) {
          $page = $_GET['page'];
        }
        $res = $db->prepare("SELECT COUNT(*) FROM news");
        $res->execute();
        $row = $res->fetch();
        $posts = $row[0];
        $str = ceil($posts/$lim);
        if ($page > $str) {
          $page = $str;
        }
        $start = $page * $lim - $lim;
        $query = $db->prepare("
          SELECT `n`.`id`, `n`.`title`, `n`.`fullnews`, `n`.`date_news`, `u`.`login`
          FROM news AS `n`
          INNER JOIN users AS `u` ON
            `u`.`uid` = `n`.`uid`
          ORDER BY `n`.`date_news` DESC
          LIMIT $start, $lim");
        $query->execute();
        ?>
        <?php while ($row = $query->fetch()): ?>
          <?php if (!empty($_SESSION['user'])): ?>
            <h2>
              <a href="view.php?id=<?php print $row['id']; ?>">
                <?php print $row['title']; ?>
              </a>
            </h2>
          <?php endif; ?>
          <?php if (empty($_SESSION['user'])) : ?>
            <h2><?php print $row['title']; ?></h2>
          <?php endif; ?>
            <div>
              <label>Date:</label>
              <span><?php print $row['date_news']; ?></span>
            </div>
            <div>
              <label>Author:</label>
              <span><?php print $row['login']; ?></span>
            </div>
            <?php
            $lenght = 150;
            $a = mb_substr($row['fullnews'], 0, $lenght);
            if (mb_strlen($row['fullnews']) > $lenght) {
                $a .= '...<a href="view.php?id=' . $row['id'] . '">Read More</a>';
            }
            ?>
            <p><?php print $a; ?></p>
          <hr>
        <?php endwhile; ?>
        <!-- Build pager.  -->
        <ul class="pager">
          <?php if ($page > 1): ?>
            <li><a href="?page=<?php print $page - 1; ?>">Previous</a></li>
          <?php endif; ?>
          <?php for ($i = 1; $i <= $str; $i++): ?>
            <?php if ($i == $page) : ?>
              <li><strong><a href="?page=<?php print $i; ?>"><?php print $i; ?></a></strong></li>
            <?php else : ?>
              <li><a href="?page=<?php print $i; ?>"><?php print $i; ?></a></li>
            <?php endif; ?>
          <?php endfor; ?>
          <?php if ($page < $str) : ?>
            <a href="?page=<?php print $page + 1; ?>">Next</a>
          <?php endif; ?>
        </ul>
      </div>
    </main>
  </div>
  <footer class="footer">

  </footer>
</body>
</html>
