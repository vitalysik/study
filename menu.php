<a href="index.php"><?php print t('Home')?></a> |
<a href="materials.php"><?php print t('Materials')?></a>
<?php if (user_access('add own article')) :?>
  |
<a href="add_materials.php"><?php print t('Add materials')?></a>
<?php endif; ?>
<?php if (user_access('admin panel')): ?>
  |
  <a href="admin_panel.php"><?php print t('Admin panel')?></a>
<?php endif; ?>
