<?php
require __DIR__ . '/../app/auth.php';
start_session();

$_SESSION = [];

session_destroy();

header('Location: /login.php');
exit;