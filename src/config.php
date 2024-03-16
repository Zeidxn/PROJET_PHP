<?php

$host = 'localhost';
$db_name = 'tn200843_PROJET';
$db_user = 'tn200843';
$db_password = 'tn200843';

$dsn = "mysql:host=$host;dbname=$db_name;charset=utf8";


try {
    global $db;
    $db = new PDO($dsn, $db_user, $db_password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
} catch (PDOException $e) {
    echo "Erreur de connexion : " . $e->getMessage();
    exit();
}


?>
