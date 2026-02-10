<?php
// src/app/db.php

$config = require _DIR_ . '/config.php';

// dati connessione
$host = $config['db']['host'];
$user = $config['db']['user'];
$pass = $config['db']['pass'];
$name = $config['db']['name'];

// connessione
$conn = new mysqli($host, $user, $pass, $name);

// controllo errore
if ($conn->connect_error) {
  die("Errore di connessione al database.");
}

// charset corretto
$conn->set_charset("utf8mb4");

return $conn;