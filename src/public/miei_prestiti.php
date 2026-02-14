<?php
require __DIR__ . '/../app/auth.php';
$mysqli = require __DIR__ . '/../app/db.php';
require_login();

$user_id = $_SESSION['user']['id'];
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
    <title>I miei prestiti</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-success mb-4">
        <div class="container">
            <span class="navbar-brand">Area Studente</span>
            <a href="index.php" class="btn btn-outline-light btn-sm">Torna alla Home</a>
        </div>
    </nav>

    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h4 class="mb-0">Storico Prestiti</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped">
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
                                <td><?= date('d/m/Y', strtotime($row['loan_date'])) ?></td>
                                <td>
                                    <?php if ($row['return_date'] === null): ?>
                                        <span class="badge bg-warning text-dark">IN CORSO</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Restituito il <?= date('d/m/Y', strtotime($row['return_date'])) ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>