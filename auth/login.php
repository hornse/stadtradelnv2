<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'] ?? '';
    $pass = $_POST['pass'] ?? '';
    if ($user && $pass) {
        // Beispiel: Klassenname aus dem Benutzernamen ableiten
        if (preg_match('/^(\d+[a-zA-Z]*)_/', $user, $m)) {
            $_SESSION['klasse'] = $m[1];
        } else {
            $_SESSION['klasse'] = 'unbekannt';
        }
        $_SESSION['user'] = $user;
        header('Location: ../index.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <link rel="stylesheet" href="../style.css"><meta charset="UTF-8"><title>Login</title></head>
<body>
<header>
  <h1>🔐 Login WebUntis</h1>
</header>
<main>
  <h1>Login</h1>
  <form method="POST">
    Benutzername: <input type="text" name="user"><br>
    Passwort: <input type="password" name="pass"><br>
    <button type="submit">Einloggen</button>
  </form>
</main>
<footer>
  &copy; 2025 – Friedrich-Rückert-Gymnasium Düsseldorf
</footer>
</body>
</html>