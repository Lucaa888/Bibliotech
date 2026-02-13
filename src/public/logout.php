<?php
require _DIR_ . '/../app/auth.php';
start_session();

// Svuota l'array di sessione
$_SESSION = [];

// Distrugge la sessione sul server
session_destroy();

// Rimanda al login
header('Location: /login.php');
exit;