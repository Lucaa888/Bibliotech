<?php
require __DIR__ . '/../app/auth.php';
$mysqli = require __DIR__ . '/../app/db.php';
require_login();

$sql = "SELECT * FROM books ORDER BY title ASC";
$result = $mysqli->query($sql);
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Catalogo - BiblioTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php">BiblioTech</a>
            <a href="index.php" class="btn btn-outline-light btn-sm">Torna alla Home</a>
        </div>
    </nav>

    <div class="container">
        
        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'prestito_ok'): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Operazione riuscita!</strong> Il prestito è stato registrato correttamente.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="card-header bg-white py-3">
                <h4 class="mb-0">Catalogo Libri</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>Titolo</th>
                                <th>Autore</th>
                                <th class="text-center">Disponibilità</th>
                                <th class="text-end">Azioni</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td class="fw-bold"><?= htmlspecialchars($row['title']) ?></td>
                                    <td><?= htmlspecialchars($row['author']) ?></td>
                                    
                                    <td class="text-center">
                                        <?php 
                                            $perc = ($row['available_copies'] / $row['total_copies']) * 100;
                                            $color = $perc > 50 ? 'success' : ($perc > 0 ? 'warning' : 'danger');
                                        ?>
                                        <span class="badge bg-<?= $color ?> rounded-pill">
                                            <?= $row['available_copies'] ?> / <?= $row['total_copies'] ?>
                                        </span>
                                    </td>

                                    <td class="text-end">
                                        <a href="libro.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info text-white me-1">Dettagli</a>

                                        <?php if ($_SESSION['user']['role'] === 'student'): ?>
                                            <?php if ($row['available_copies'] > 0): ?>
                                                <a href="azione_prestito.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-success">Prendi</a>
                                            <?php else: ?>
                                                <button class="btn btn-sm btn-secondary" disabled>Esaurito</button>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>