<?php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['klasse'])) {
    header('Location: landing.html');
    exit;
}

$db = new PDO('sqlite:../db.sqlite');
$klasse = $_SESSION['klasse'];

$stmt = $db->prepare('SELECT SUM(km) as total FROM eintraege WHERE klasse = ?');
$stmt->execute([$klasse]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$gesamtKm = $result['total'] ?? 0;

?>
<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>Stadtradeln – Eingabe</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>Stadtradeln <?= htmlspecialchars($klasse) ?></h1>

    <form action="submit.php" method="POST">
      <label for="km">Gefahrene Kilometer eintragen:</label>
      <input type="number" name="km" id="km" step="0.1" min="0" required>
      <button type="submit">Absenden</button>
    </form>

    <p>Insgesamt gefahren: <strong><?= $gesamtKm ?> km</strong></p>

    <h2>Klassenvergleich</h2>
    <canvas id="chart" width="400" height="200"></canvas>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    fetch('data.php')
      .then(res => res.json())
      .then(data => {
        const ctx = document.getElementById('chart');
        const chart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: data.map(e => e.klasse),
            datasets: [{
              label: 'Gefahrene Kilometer',
              data: data.map(e => e.km),
              backgroundColor: data.map(e => e.farbe)
            }]
          },
          options: {
            scales: {
              y: {
                beginAtZero: true
              }
            }
          }
        });
      });
  </script>
</body>
</html>
