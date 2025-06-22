<?php
session_start();
require_once 'auth_webuntis.php';
require_once '../farben.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'] ?? '';
    $pass = $_POST['pass'] ?? '';

    if ($user && $pass) {
        $auth = new \MRBS\Auth\AuthWebUntis();

        if ($auth->validateUser($user, $pass)) {
            $_SESSION['user'] = $user;

            // Klasse aus Benutzername extrahieren: z.B. 9A_schmidt
            if (preg_match('/^([5-9]|10|EF|Q1|Q2)[a-zA-Z]/i', $user, $match)) {
                $_SESSION['klasse'] = strtoupper($match[0]);
            } else {
                $_SESSION['klasse'] = 'unbekannt';
            }

            header('Location: ../index.php');
            exit;
        } else {
            $fehler = "Login fehlgeschlagen.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="../style.css">
</head>
<body>
  <header>
    <h1>🔐 Login WebUntis</h1>
  </header>
  <main>
    <h2>Login</h2>
    <?php if (!empty($fehler)) echo "<p style='color:red;'>$fehler</p>"; ?>
    <form method="POST">
      Benutzername: <input type="text" name="user" required><br>
      Passwort: <input type="password" name="pass" required><br>
      <button type="submit">Einloggen</button>
    </form>
  </main>
  <footer>
    &copy; 2025 – Friedrich-Rückert-Gymnasium Düsseldorf
  </footer>
</body>
</html>
