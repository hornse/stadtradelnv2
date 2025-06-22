<?php
$db = new PDO('../db.sqlite');
$stmt = $db->query("SELECT klasse, SUM(kilometer) AS kilometer FROM eintraege GROUP BY klasse ORDER BY kilometer DESC");
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="de">
<head>
  <link rel="stylesheet" href="../style.css">
  <meta charset="UTF-8">
  <title>Stadtradeln Dashboard</title>
</head>
<body>
<header>
  <h1>📊 Klassenranking – Stadtradeln</h1>
</header>
<main>
  <h1>Aktueller Stand</h1>
  <canvas id="chart" width="400" height="200"></canvas>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    const data = <?php echo json_encode($data); ?>;
    const ctx = document.getElementById('chart').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: data.map(e => e.klasse),
        datasets: [{
          label: 'Kilometer',
          data: data.map(e => e.kilometer),
          backgroundColor: data.map((_, i) => `hsl(${i * 50 % 360}, 60%, 60%)`)
        }]
      },
      options: {
        scales: { y: { beginAtZero: true } }
      }
    });
  </script>
  <p><a href="../auth/logout.php">Logout</a></p>
</main>
<footer>
  &copy; 2025 – Friedrich-Rückert-Gymnasium Düsseldorf
</footer>
</body>
</html>
