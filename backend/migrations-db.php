<?php

return [
    'dbname' => $_ENV['MYSQL_DATABASE'],
    'user' => $_ENV['MYSQL_USER'] ?? 'root',
    'password' => $_ENV['MYSQL_PASSWORD'] ?? '',
    'host' => $_ENV['MYSQL_HOST'] ?? 'localhost',
    'driver' => 'pdo_mysql',
];