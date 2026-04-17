<?php
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// conexiones
echo $_ENV['DB_HOST'];
echo $_ENV['DB_USER'];
echo $_ENV['DB_PASS'];

?>