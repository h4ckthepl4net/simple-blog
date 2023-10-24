<?php
global $db;
$db = null;
try {
    $host = getenv('MYSQL_HOST') ?: 'localhost';
    $port = getenv('MYSQL_PORT') ?: 3306;
    $dbname = getenv('MYSQL_DATABASE') ?: 'main';
    $user = getenv('MYSQL_USER') ?: 'root';
    $password = getenv('MYSQL_PASSWORD') ?: '';

    $dbString = 'mysql:host='.$host.';port='.$port.';dbname='.$dbname;

    echo $dbString;

    $db = new PDO($dbString, $user, $password);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}