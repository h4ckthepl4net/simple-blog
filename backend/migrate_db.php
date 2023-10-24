<?php
global $db;
include './database_connection.php';

if (!$db) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    die(1);
}

$db->query("
    CREATE TABLE users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(30) NOT NULL,
        password VARCHAR(255) NOT NULL
    );
");

$db->query("
    CREATE TABLE categories (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL
    );
");

$db->query("
    CREATE TABLE posts (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        user_id INT(6) UNSIGNED NOT NULL,
        FOREIGN KEY (user_id) REFERENCES users(id)
    );
");

$db->query("
    CREATE TABLE posts_categories (
        post_id INT(6) UNSIGNED NOT NULL,
        category_id INT(6) UNSIGNED NOT NULL,
        FOREIGN KEY (post_id) REFERENCES posts(id),
        FOREIGN KEY (category_id) REFERENCES categories(id),
        PRIMARY KEY (post_id, category_id)
    );
");