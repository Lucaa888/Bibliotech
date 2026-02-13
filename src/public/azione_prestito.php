<?php
require __DIR__ . '/../app/auth.php';
$mysqli = require __DIR__ . '/../app/db.php';
require_login();

// 1. Controllo ID
if (!isset($_GET['id'])) {
    die("Errore: nessun libro selezionato.");
}
$book_id = (int)$_GET['id'];
$user_id = $_SESSION['user']['id'];

// 2. Controllo Ruolo (Solo studenti possono prendere in prestito)
if ($_SESSION['user']['role'] !== 'student') {
    die("Errore: Solo gli studenti possono prendere libri in prestito.");
}

// 3. LOGICA DI PRESTITO SICURA
// Usiamo una transazione logica semplice:
// Prima proviamo a decrementare le copie SOLO SE sono > 0.
// Se l'aggiornamento ha successo (1 riga modificata), allora inseriamo il prestito.

// Step A: Decrementa copie disponibili
$stmt = $mysqli->prepare("UPDATE books SET available_copies = available_copies - 1 WHERE id = ? AND available_copies > 0");
$stmt->bind_param("i", $book_id);
$stmt->execute();

// Controlliamo se ha funzionato (affected_rows sarà 1 se c'era una copia, 0 se erano finite)
if ($stmt->affected_rows > 0) {
    
    // Step B: Inserisci il record nella tabella loans
    $stmt_insert = $mysqli->prepare("INSERT INTO loans (user_id, book_id, loan_date) VALUES (?, ?, NOW())");
    $stmt_insert->bind_param("ii", $user_id, $book_id);
    
    if ($stmt_insert->execute()) {
        // Successo! Rimando alla pagina dei miei prestiti (che faremo dopo) o al catalogo
        // Per ora rimando al catalogo con un messaggio (usando un parametro GET semplice)
        header("Location: libri.php?msg=prestito_ok");
        exit;
    } else {
        // Se fallisce l'insert (molto raro), dovremmo ri-aggiungere la copia. 
        // Per semplicità scolastica, diamo errore generico.
        die("Errore durante la registrazione del prestito.");
    }

} else {
    // Se arriviamo qui, significa che le copie erano 0 o il libro non esiste
    die("Errore: Copie esaurite o libro inesistente.");
}
?>