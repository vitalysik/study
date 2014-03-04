<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=db', 'root', '123456');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec('SET NAMES utf8');
}
catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

?>
