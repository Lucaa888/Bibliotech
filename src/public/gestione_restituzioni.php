<?php
require __DIR__ . '/../app/auth.php';
$mysqli = require __DIR__ . '/../app/db.php';
require_login();

if ($_SESSION['user']['role'] !== 'librarian') die("Accesso negato.");

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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restituzioni</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-danger mb-4">
        <div class="container">
            <span class="navbar-brand">Area Bibliotecario</span>
            <a href="index.php" class="btn btn-outline-light btn-sm">Torna alla Dashboard</a>
        </div>
    </nav>

    <div class="container">
        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'restituito'): ?>
            <div class="alert alert-success alert-dismissible fade show">
                Libro restituito con successo! Le giacenze sono state aggiornate.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm border-danger">
            <div class="card-header bg-danger text-white">
                <h4 class="mb-0">Prestiti Attivi (Da Restituire)</h4>
            </div>
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Studente</th>
                            <th>Libro</th>
                            <th>Data Prestito</th>
                            <th class="text-end">Azione</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($result->num_rows > 0): ?>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td class="fw-bold"><?= htmlspecialchars($row['full_name']) ?></td>
                                    <td><?= htmlspecialchars($row['title']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($row['loan_date'])) ?></td>
                                    <td class="text-end">
                                        <a href="azione_restituzione.php?id=<?= $row['loan_id'] ?>" 
                                           class="btn btn-danger btn-sm"
                                           onclick="return confirm('Confermi la restituzione?');">
                                           REGISTRA RESTITUZIONE
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="text-center text-muted">Nessun prestito attivo al momento.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>