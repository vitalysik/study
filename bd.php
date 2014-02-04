<?php
try {
    $db = new PDO('mysql:host=localhost;dbname=db', 'root', '123456');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}

?>
