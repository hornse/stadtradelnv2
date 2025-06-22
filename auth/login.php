<?php
session_start();
require_once __DIR__ . '/auth/auth_webuntis.php';

use Stadtradeln\Auth\AuthWebUntis;

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'] ?? '';
    $pass = $_POST['pass'] ?? '';

    if ($user && $pass) {
        $auth = new AuthWebUntis();
        if ($auth->validateUser($user, $pass)) {
            $_SESSION['user'] = $user;

            // Klassenzuordnung prüfen
            if (!isset($_SESSION['klasse'])) {
                header('Location: choose_class.php');
                exit;
            }

            header('Location: index.php');
            exit;
        } else {
            $error = "Login fehlgeschlagen. Bitte überprüfe Benutzername und Passwort.";
        }
    } else {
        $error = "Bitte Benutzername und Passwort eingeben.";
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>Login – Stadtradeln</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header><h1>🔐 Login WebUntis</h1></header>
  <main>
    <h2>Login mit WebUntis-Zugang</h2>
    <?php if ($error): ?>
      <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <form method="post">
      <label>Benutzername:
        <input type="text" name="user" required>
      </label><br>
      <label>Passwort:
        <input type="password" name="pass" required>
      </label><br>
      <button type="submit">Einloggen</button>
    </form>
  </main>
  <footer>&copy; 2025 – Friedrich-Rückert-Gymnasium Düsseldorf</footer>
</body>
</html>
