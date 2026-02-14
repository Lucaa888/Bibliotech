<?php
require __DIR__ . '/../app/auth.php';
$mysqli = require __DIR__ . '/../app/db.php';
require_login();

if (!isset($_GET['id'])) die("Libro non specificato.");
$id = (int)$_GET['id'];
$stmt = $mysqli->prepare("SELECT * FROM books WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$libro = $stmt->get_result()->fetch_assoc();
if (!$libro) die("Libro non trovato.");
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($libro['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0"><?= htmlspecialchars($libro['title']) ?></h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h5 class="text-muted mb-3"><?= htmlspecialchars($libro['author']) ?></h5>
                                <p><strong>ISBN:</strong> <?= htmlspecialchars($libro['isbn']) ?></p>
                                <p><strong>Anno:</strong> <?= htmlspecialchars($libro['pub_year']) ?></p>
                                <hr>
                                <p class="card-text"><?= nl2br(htmlspecialchars($libro['description'])) ?></p>
                            </div>
                            <div class="col-md-4 text-center bg-light p-3 rounded">
                                <h6>Copie Disponibili</h6>
                                <h1 class="display-4 fw-bold text-primary"><?= $libro['available_copies'] ?></h1>
                                <small class="text-muted">su <?= $libro['total_copies'] ?> totali</small>
                                
                                <div class="d-grid gap-2 mt-4">
                                    <?php if ($_SESSION['user']['role'] === 'student'): ?>
                                        <?php if ($libro['available_copies'] > 0): ?>
                                            <a href="azione_prestito.php?id=<?= $libro['id'] ?>" class="btn btn-success btn-lg">CONFERMA PRESTITO</a>
                                        <?php else: ?>
                                            <button class="btn btn-secondary btn-lg" disabled>NON DISPONIBILE</button>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <a href="libri.php" class="btn btn-outline-secondary">Torna al Catalogo</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>