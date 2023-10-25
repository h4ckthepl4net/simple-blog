<?php
require_once __DIR__ . '/../vendor/autoload.php';

global $klein;
$klein = new \Klein\Klein();

require_once __DIR__ . '/routes/Auth.php';
require_once __DIR__ . '/routes/Posts.php';

$klein->dispatch();

