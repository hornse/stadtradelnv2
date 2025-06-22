<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>Stadtradeln – Klassenranking</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h1>🚴‍♂️ Stadtradeln Ranking</h1>
    <p>Diese Übersicht zeigt live die gefahrenen Kilometer pro Klasse. Regelmäßige Aktualisierung garantiert.</p>
    <canvas id="rankingChart"></canvas>
  </div>

  <script>
    async function ladeDaten() {
      const res = await fetch('data.php');
      const daten = await res.json();
      const labels = daten.map(e => e.klasse);
      const werte = daten.map(e => e.km);
      const farben = daten.map(e => e.farbe);

      new Chart(document.getElementById('rankingChart'), {
        type: 'bar',
        data: {
          labels: labels,
          datasets: [{
            label: 'Kilometer',
            data: werte,
            backgroundColor: farben,
            borderRadius: 6
          }]
        },
        options: {
          responsive: true,
          plugins: {
            legend: { display: false },
            title: {
              display: true,
              text: 'Gefahrene Kilometer je Klasse'
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              title: { display: true, text: 'Kilometer' }
            }
          }
        }
      });
    }

    ladeDaten();
  </script>
</body>
</html>