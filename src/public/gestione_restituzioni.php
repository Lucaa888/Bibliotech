<?php
require __DIR__ . '/../app/auth.php';
$mysqli = require __DIR__ . '/../app/db.php';
require_login();

// Controllo sicurezza: Solo i bibliotecari possono accedere qui
if ($_SESSION['user']['role'] !== 'librarian') {
    die("Accesso negato. Area riservata ai bibliotecari.");
}

// Query: Seleziona SOLO i prestiti NON ancora restituiti (return_date IS NULL)
// Unisce tre tabelle: loans, books (per il titolo) e users (per il nome studente)
$query = "SELECT loans.id as loan_id, books.title, users.full_name, loans.loan_date 
          FROM loans 
          JOIN books ON loans.book_id = books.id 
          JOIN users ON loans.user_id = users.id 
          WHERE loans.return_date IS NULL 
          ORDER BY loans.loan_date ASC";

$result = $mysqli->query($query);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Gestione Restituzioni - BiblioTech</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .btn-return { 
            background-color: #d9534f; color: white; padding: 5px 10px; 
            text-decoration: none; border-radius: 4px; 
        }
    </style>
</head>
<body>
    <a href="index.php">← Torna alla Dashboard</a>
    <h1>Gestione Restituzioni</h1>
    <p>Elenco dei libri attualmente fuori sede.</p>

    <table>
        <thead>
            <tr>
                <th>Studente</th>
                <th>Libro</th>
                <th>Data Prestito</th>
                <th>Azione</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['full_name']) ?></td>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= date('d/m/Y', strtotime($row['loan_date'])) ?></td>
                    <td>
                        <a href="azione_restituzione.php?id=<?= $row['loan_id'] ?>" 
                           class="btn-return"
                           onclick="return confirm('Confermi la restituzione del libro?');">
                           RESTITUISCI
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>