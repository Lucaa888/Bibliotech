<?php
require __DIR__ . '/../app/auth.php';
require_login();
$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home - BiblioTech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">BiblioTech</a>
            <div class="d-flex text-white">
                <span class="me-3 align-self-center">Ciao, <?= htmlspecialchars($user['full_name']) ?></span>
                <a href="logout.php" class="btn btn-outline-light btn-sm">Esci</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="p-5 mb-4 bg-white rounded-3 shadow-sm border">
            <h1 class="display-5 fw-bold">Benvenuto in Biblioteca</h1>
            <p class="col-md-8 fs-4">Sistema digitale per la gestione dei prestiti scolastici.</p>
            <span class="badge bg-secondary fs-6">Ruolo: <?= ucfirst($user['role']) ?></span>
        </div>

        <div class="row align-items-md-stretch">
            <?php if ($user['role'] === 'student'): ?>
                <div class="col-md-6 mb-3">
                    <div class="h-100 p-5 text-white bg-success rounded-3">
                        <h2>Catalogo Libri</h2>
                        <p>Cerca un libro, verifica la disponibilità e prenotalo subito con un click.</p>
                        <a href="libri.php" class="btn btn-outline-light">Vai al Catalogo</a>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="h-100 p-5 bg-white border rounded-3 shadow-sm">
                        <h2>I Miei Prestiti</h2>
                        <p>Controlla lo storico dei tuoi prestiti e verifica le date di restituzione.</p>
                        <a href="miei_prestiti.php" class="btn btn-outline-secondary">Visualizza Storico</a>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($user['role'] === 'librarian'): ?>
                <div class="col-md-6 mb-3">
                    <div class="h-100 p-5 text-white bg-danger rounded-3">
                        <h2>Restituzioni</h2>
                        <p>Gestisci i rientri dei libri e visualizza chi ha attualmente copie in carico.</p>
                        <a href="gestione_restituzioni.php" class="btn btn-outline-light">Gestisci Restituzioni</a>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="h-100 p-5 bg-white border rounded-3 shadow-sm">
                        <h2>Catalogo Completo</h2>
                        <p>Visualizza l'inventario completo e lo stato delle copie.</p>
                        <a href="libri.php" class="btn btn-outline-secondary">Vedi Catalogo</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>