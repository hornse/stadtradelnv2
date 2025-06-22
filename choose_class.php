<?php
session_start();
if (!isset($_SESSION['user'])) die('Nicht eingeloggt');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $klasse = $_POST['klasse'] ?? '';
    if ($klasse) {
        $db = new SQLite3('db.sqlite');
        $stmt = $db->prepare('INSERT OR REPLACE INTO users (username, klasse) VALUES (:user, :klasse)');
        $stmt->bindValue(':user', $_SESSION['user'], SQLITE3_TEXT);
        $stmt->bindValue(':klasse', $klasse, SQLITE3_TEXT);
        $stmt->execute();
        $_SESSION['klasse'] = $klasse;
        header('Location: index.php');
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>Klasse wählen</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header>
  <h1>🚲 Stadtradeln – Klassenzuordnung</h1>
</header>

<main>
  <h2>Bitte wähle deine Klasse</h2>
  <form method="post">
    <select name="klasse" required>
      <option value="">– Bitte wählen –</option>

      <?php
      // Jahrgänge 5 bis 10: A–F
      for ($stufe = 5; $stufe <= 10; $stufe++) {
          foreach (['A','B','C','D','E','F'] as $buchstabe) {
              $klasse = $stufe . $buchstabe;
              echo "<option value=\"$klasse\">$klasse</option>";
          }
      }

      // Oberstufe
      foreach (['EF', 'Q1', 'Q2'] as $oberstufe) {
          echo "<option value=\"$oberstufe\">$oberstufe</option>";
      }
      ?>

    </select>
    <br><br>
    <button type="submit">Speichern</button>
  </form>
</main>

<footer>
  &copy; 2025 – Friedrich-Rückert-Gymnasium Düsseldorf
</footer>
</body>
</html>
