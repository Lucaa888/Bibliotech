<?php
require __DIR__ . '/../app/auth.php';
$mysqli = require __DIR__ . '/../app/db.php';
require_login();

if (!isset($_GET['id'])) {
    die("Errore: nessun libro selezionato.");
}
$book_id = (int)$_GET['id'];
$user_id = $_SESSION['user']['id'];

if ($_SESSION['user']['role'] !== 'student') {
    die("Errore: Solo gli studenti possono prendere libri in prestito.");
}

$stmt = $mysqli->prepare("UPDATE books SET available_copies = available_copies - 1 WHERE id = ? AND available_copies > 0");
$stmt->bind_param("i", $book_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    
    $stmt_insert = $mysqli->prepare("INSERT INTO loans (user_id, book_id, loan_date) VALUES (?, ?, NOW())");
    $stmt_insert->bind_param("ii", $user_id, $book_id);
    
    if ($stmt_insert->execute()) {
        header("Location: libri.php?msg=prestito_ok");
        exit;
    } else {
        die("Errore durante la registrazione del prestito.");
    }

} else {
    die("Errore: Copie esaurite o libro inesistente.");
}
?>