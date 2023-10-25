<?php
global $db;
include './database_connection.php';

if (!$db) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    die(1);
}

$db->query("
    CREATE TABLE IF NOT EXISTS users (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(30) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
    );
");

$db->query("
    CREATE TABLE IF NOT EXISTS categories (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL UNIQUE
    );
");

$db->query("
    CREATE TABLE IF NOT EXISTS posts (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        content TEXT NOT NULL,
        user_id INT(6) UNSIGNED NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    );
");

$db->query("
    CREATE TABLE IF NOT EXISTS posts_categories (
        post_id INT(6) UNSIGNED NOT NULL,
        category_id INT(6) UNSIGNED NOT NULL,
        FOREIGN KEY (post_id) REFERENCES posts(id),
        FOREIGN KEY (category_id) REFERENCES categories(id),
        PRIMARY KEY (post_id, category_id)
    );
");