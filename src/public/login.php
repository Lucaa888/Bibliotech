<?php
require __DIR__ . '/../app/auth.php';
start_session();

$mysqli = require __DIR__ . '/../app/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($username === '' || $password === '') {
    $error = "Compila username e password.";
  } else {

    // Prepared statement (anti SQL injection)
    $stmt = $mysqli->prepare(
      "SELECT id, username, full_name, role, password_hash
       FROM users
       WHERE username = ?"
    );

    if (!$stmt) {
      die("Errore interno (prepare).");
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();

    // get_result richiede mysqlnd (di solito c'è). Se manca, ti dico sotto l'alternativa.
    $result = $stmt->get_result();
    $user = $result ? $result->fetch_assoc() : null;

    $stmt->close();

    if ($user && password_verify($password, $user['password_hash'])) {
      session_regenerate_id(true);

      $_SESSION['user'] = [
        'id' => (int)$user['id'],
        'username' => $user['username'],
        'full_name' => $user['full_name'],
        'role' => $user['role'],
      ];

      header('Location: /index.php');
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
  <style>
    body { font-family: Arial, sans-serif; margin: 40px; }
    .box { max-width: 420px; padding: 16px; border: 1px solid #ddd; border-radius: 8px; }
    .row { margin-bottom: 10px; }
    input { width: 100%; padding: 8px; }
    button { padding: 10px 12px; cursor: pointer; }
    .err { color: #b00020; margin-bottom: 10px; }
  </style>
</head>
<body>
  <h1>BiblioTech</h1>

  <div class="box">
    <h2>Login</h2>

    <?php if ($error !== ''): ?>
      <div class="err"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
      <div class="row">
        <label>Username</label>
        <input name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" autocomplete="username">
      </div>

      <div class="row">
        <label>Password</label>
        <input type="password" name="password" autocomplete="current-password">
      </div>

      <button type="submit">Accedi</button>
    </form>

    <p style="margin-top:12px;font-size:0.9em;color:#555;">
      Test: studente1/studente1 - biblio/biblio1
    </p>
  </div>
</body>
</html>