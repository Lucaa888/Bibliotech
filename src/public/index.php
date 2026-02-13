<?php
require __DIR__ . '/../app/auth.php';
require_login(); // Pagina protetta

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Home - BiblioTech</title>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        .menu { background: #f4f4f4; padding: 15px; border-radius: 5px; }
        a { text-decoration: none; color: #007bff; margin-right: 15px; font-weight: bold; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <h1>Benvenuto, <?= htmlspecialchars($user['full_name']) ?>!</h1>
    <p>Ruolo: <strong><?= $user['role'] === 'student' ? 'Studente' : 'Bibliotecario' ?></strong></p>

    <div class="menu">
        <a href="index.php">Home</a>
        
        <?php if ($user['role'] === 'student'): ?>
            <a href="libri.php">Catalogo Libri</a>
        <?php endif; ?>

        <?php if ($user['role'] === 'librarian'): ?>
            <a href="prestiti.php">Prestiti Attivi</a>
            <a href="gestione_restituzioni.php">Restituzioni</a>
        <?php endif; ?>

        <a href="logout.php" style="color: red;">Esci</a>
    </div>

    <p>Seleziona un'opzione dal menu sopra per iniziare.</p>
</body>
</html>
