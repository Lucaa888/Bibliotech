<?php
function start_session() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

function require_login() {
    start_session();
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        exit();
    }
}