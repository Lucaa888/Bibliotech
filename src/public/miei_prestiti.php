<?php
require __DIR__ . '/../app/auth.php';
$mysqli = require __DIR__ . '/../app/db.php';
require_login();

// Prendo l'ID dello studente loggato
$user_id = $_SESSION['user']['id'];

// Query: unisco la tabella prestiti con la tabella libri per avere il titolo
// Mostro sia quelli attivi che quelli restituiti (storico)
$query = "SELECT books.title, loans.loan_date, loans.return_date 
          FROM loans 
          JOIN books ON loans.book_id = books.id 
          WHERE loans.user_id = ? 
          ORDER BY loans.loan_date DESC";

$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>I miei prestiti - BiblioTech</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .attivo { color: green; font-weight: bold; }
        .chiuso { color: gray; }
    </style>
</head>
<body>
    <a href="index.php">← Torna alla Home</a>
    <h1>I miei prestiti</h1>

    <table>
        <thead>
            <tr>
                <th>Libro</th>
                <th>Data Prestito</th>
                <th>Stato</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($row['loan_date'])) ?></td>
                    <td>
                        <?php if ($row['return_date'] === null): ?>
                            <span class="attivo">IN CORSO</span>
                        <?php else: ?>
                            <span class="chiuso">Restituito il <?= date('d/m/Y', strtotime($row['return_date'])) ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>