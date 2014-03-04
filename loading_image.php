<?php
$path_directory = 'image/';
if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)|(gif)|(GIF)|(png)|(PNG)$/',$_FILES['imgupload']['name']) && !empty($_POST['uid'])){
   $filename = $_FILES['imgupload']['name'];
   $source = $_FILES['imgupload']['tmp_name'];
   $target = $path_directory . $filename;
   move_uploaded_file($source, $target);
   if(preg_match('/[.](GIF)|(gif)$/', $filename)){
      $im = imagecreatefromgif($path_directory.$filename) ;
   }
   if(preg_match('/[.](PNG)|(png)$/', $filename)){
      $im = imagecreatefrompng($path_directory.$filename) ;
   }
   if(preg_match('/[.](JPG)|(jpg)|(jpeg)|(JPEG)$/', $filename)){
      $im = imagecreatefromjpeg($path_directory.$filename);
   }
   $w = 150;
   $w_src = imagesx($im);
   $h_src = imagesy($im);
   $dest = imagecreatetruecolor($w,$w);
   if ($w_src>$h_src){
   imagecopyresampled($dest, $im, 0, 0,
   round((max($w_src,$h_src)-min($w_src,$h_src))/2),
   0, $w, $w, min($w_src,$h_src), min($w_src,$h_src));
   }
   if ($w_src < $h_src){
   imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w,
   min($w_src,$h_src), min($w_src,$h_src));
   }
   if ($w_src==$h_src){
   imagecopyresampled($dest, $im, 0, 0, 0, 0, $w, $w, $w_src, $w_src);
   }
   $date=time();
   imagejpeg($dest, $path_directory.$date.".jpg");
   $avatar = $path_directory.$date.".jpg";
   $delfull = $path_directory.$filename;
   unlink ($delfull);
   include ("bd.php");
   $uid = $_POST['uid'];
   $result = $db->prepare("UPDATE `users` SET avatar = :avatar WHERE uid = :uid");
   $result->bindParam(':avatar', $avatar);
   $result->bindParam(':uid', $uid);
   $result->execute();
   header("Location: user.php?id={$uid}");
}
else {
   exit ("Error, image must be <strong>JPG,GIF or PNG</strong>");
}
?>

