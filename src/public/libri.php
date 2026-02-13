<?php
require __DIR__ . '/../app/auth.php';
$mysqli = require __DIR__ . '/../app/db.php';
require_login();

// Query per prendere tutti i libri
$sql = "SELECT * FROM books ORDER BY title ASC";
$result = $mysqli->query($sql);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Catalogo - BiblioTech</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f2f2f2; }
        .btn { padding: 5px 10px; background: #28a745; color: white; text-decoration: none; border-radius: 3px; }
        .btn-disabled { background: #ccc; pointer-events: none; }
    </style>
</head>
<body>
    <a href="index.php">← Torna alla Home</a>
    <h1>Catalogo Libri</h1>

    <table>
        <thead>
            <tr>
                <th>Titolo</th>
                <th>Autore</th>
                <th>Copie Disponibili</th>
                <th>Azioni</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['author']) ?></td>
                    
                    <td>
                        <?= $row['available_copies'] ?> / <?= $row['total_copies'] ?>
                    </td>

                    <td>
                        <a href="libro.php?id=<?= $row['id'] ?>" style="margin-right: 10px;">Dettagli</a>

                        <?php if ($row['available_copies'] > 0): ?>
                            <a href="azione_prestito.php?id=<?= $row['id'] ?>" class="btn">PRENDI IN PRESTITO</a>
                        <?php else: ?>
                            <span class="btn btn-disabled">Non disponibile</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>