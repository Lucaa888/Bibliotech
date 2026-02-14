<?php
require __DIR__ . '/../app/auth.php';
$mysqli = require __DIR__ . '/../app/db.php';
require_login();

// 1. Controllo Ruolo
if ($_SESSION['user']['role'] !== 'librarian') {
    die("Accesso negato.");
}

// 2. Controllo ID Prestito
if (!isset($_GET['id'])) {
    die("ID prestito mancante.");
}
$loan_id = (int)$_GET['id'];

// 3. Recupero l'ID del libro associato a questo prestito 
// (Mi serve per incrementare le copie)
$stmt = $mysqli->prepare("SELECT book_id FROM loans WHERE id = ? AND return_date IS NULL");
$stmt->bind_param("i", $loan_id);
$stmt->execute();
$result = $stmt->get_result();
$loan = $result->fetch_assoc();

if (!$loan) {
    die("Errore: Prestito non trovato o libro già restituito.");
}

$book_id = $loan['book_id'];

// 4. ESECUZIONE DELLA RESTITUZIONE
// Aggiorno la data di fine prestito
$stmt_update_loan = $mysqli->prepare("UPDATE loans SET return_date = NOW() WHERE id = ?");
$stmt_update_loan->bind_param("i", $loan_id);
$stmt_update_loan->execute();

// Incremento le copie disponibili del libro
$stmt_update_book = $mysqli->prepare("UPDATE books SET available_copies = available_copies + 1 WHERE id = ?");
$stmt_update_book->bind_param("i", $book_id);
$stmt_update_book->execute();

// 5. Ritorno alla pagina di gestione
header("Location: gestione_restituzioni.php?msg=restituito");
exit;
?>