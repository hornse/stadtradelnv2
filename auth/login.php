<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'] ?? '';
    $pass = $_POST['pass'] ?? '';

    if ($user && $pass) {
        // Authentifizierung über WebUntis-Skript ehemals auth_webuntis.php
        require_once 'webuntis_config.php';
        $auth = new AuthWebUntis();
        if ($auth->validateUser($user, $pass)) {
            $_SESSION['user'] = $user;

            // Datenbankverbindung aufbauen
            $db = new SQLite3('db.sqlite');
            $stmt = $db->prepare('SELECT klasse FROM users WHERE username = :user');
            $stmt->bindValue(':user', $user, SQLITE3_TEXT);
            $result = $stmt->execute();
            $row = $result->fetchArray(SQLITE3_ASSOC);
            if ($row && $row['klasse']) {
                $_SESSION['klasse'] = $row['klasse'];
                header('Location: index.php');
            } else {
                header('Location: choose_class.php');
            }
            exit;
        } else {
            $error = "Login fehlgeschlagen";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
  <h1>🔐 Login WebUntis</h1>
</header>

<main>
  <h2>Login</h2>
  <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
  <form method="POST">
    <label for="user">Benutzername:</label>
    <input type="text" name="user" id="user" required><br>
    <label for="pass">Passwort:</label>
    <input type="password" name="pass" id="pass" required><br>
    <button type="submit">Einloggen</button>
  </form>
</main>

<footer>
  &copy; 2025 – Friedrich-Rückert-Gymnasium Düsseldorf
</footer>
</body>
</html>

