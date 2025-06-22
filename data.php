<?php
header('Content-Type: application/json');

$db = new PDO('sqlite:../db.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$result = $db->query('SELECT klasse, SUM(km) as km FROM eintraege GROUP BY klasse ORDER BY km DESC');
$klassen = $result->fetchAll(PDO::FETCH_ASSOC);

include 'farben.php';

foreach ($klassen as &$eintrag) {
    $eintrag['farbe'] = $farben[$eintrag['klasse']] ?? '#888888';
}

echo json_encode($klassen);
