<?php

$config = require __DIR__ . '/config.php';

$host = $config['db']['host'];
$user = $config['db']['user'];
$pass = $config['db']['pass'];
$name = $config['db']['name'];

$conn = new mysqli($host, $user, $pass, $name);

if ($conn->connect_error) {
  die("Errore di connessione al database.");
}

$conn->set_charset("utf8mb4");

return $conn;