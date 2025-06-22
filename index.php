<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['klasse'])) {
    header("Location: auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <link rel="stylesheet" href="style.css">
  <meta charset="UTF-8">
  <title>Stadtradeln – Kilometer eintragen</title>
</head>
<body>
  <h1>Willkommen, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h1>
  <p>Du trägst Kilometer für die Klasse <strong><?php echo htmlspecialchars($_SESSION['klasse']); ?></strong> ein.</p>
  <form action="submit.php" method="POST">
    <label>Gefahrene Kilometer:
      <input type="number" name="kilometer" min="1" max="100" required>
    </label><br>
    <button type="submit">Absenden</button>
  </form>

  <h2>Ranking</h2>
  <canvas id="chart" width="400" height="200"></canvas>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    fetch('data.php')
      .then(res => res.json())
      .then(data => {
        const ctx = document.getElementById('chart').getContext('2d');
        new Chart(ctx, {
          type: 'bar',
          data: {
            labels: data.map(e => e.klasse),
            datasets: [{
              label: 'Gesamtkilometer',
              data: data.map(e => e.kilometer),
              backgroundColor: data.map((_, i) => `hsl(${i * 50 % 360}, 60%, 60%)`)
            }]
          },
          options: {
            scales: { y: { beginAtZero: true } }
          }
        });
      });
  </script>
  <p><a href="auth/logout.php">Logout</a></p>
</body>
</html>
