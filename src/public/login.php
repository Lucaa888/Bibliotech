<?php
require __DIR__ . '/../app/auth.php';
start_session();

if (isset($_SESSION['user'])) {
    header('Location: /index.php');
    exit;
}

$mysqli = require __DIR__ . '/../app/db.php';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = "Compila username e password.";
    } else {
        $stmt = $mysqli->prepare("SELECT id, username, full_name, role, password_hash FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if ($user && password_verify($password, $user['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['user'] = [
                'id' => (int)$user['id'],
                'username' => $user['username'],
                'full_name' => $user['full_name'],
                'role' => $user['role'],
            ];
            header('Location: index.php');
            exit;
        } else {
            $error = "Credenziali non valide.";
        }
    }
}
?>
<!doctype html>
<html lang="it">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - BiblioTech</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; display: flex; align-items: center; min-height: 100vh; }
    .card-login { max-width: 400px; width: 100%; margin: auto; }
  </style>
</head>
<body>
  <div class="container">
    <div class="card card-login shadow-sm">
      <div class="card-body p-4">
        <h2 class="text-center mb-4 text-primary">BiblioTech</h2>
        
        <?php if ($error !== ''): ?>
          <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($error) ?>
          </div>
        <?php endif; ?>

        <form method="post">
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input name="username" class="form-control" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required autofocus>
          </div>

          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>

          <button type="submit" class="btn btn-primary w-100 py-2">Accedi</button>
        </form>
        
        <div class="mt-3 text-center text-muted small">
          <hr>
          <p class="mb-1">Credenziali Demo:</p>
          Studente: <code>studente1</code> / <code>studente1</code><br>
          Bibliotecario: <code>biblio</code> / <code>biblio1</code>
        </div>
      </div>
    </div>
  </div>
</body>
</html>