<?php
$db = new PDO('sqlite:db.sqlite');
$stmt = $db->query("SELECT klasse, SUM(kilometer) AS kilometer FROM eintraege GROUP BY klasse ORDER BY kilometer DESC");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>