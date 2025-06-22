<?php
session_start();

if (!isset($_SESSION['user']) || !isset($_SESSION['klasse'])) {
    http_response_code(403);
    echo json_encode(['error' => 'Nicht authentifiziert.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Ungültige Methode.']);
    exit;
}

$km = isset($_POST['km']) ? (float)$_POST['km'] : 0;
if ($km <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Ungültige Kilometerangabe.']);
    exit;
}

$db = new PDO('sqlite:../db.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$stmt = $db->prepare('INSERT INTO eintraege (klasse, km, zeitstempel) VALUES (?, ?, ?)');
$stmt->execute([
    $_SESSION['klasse'],
    $km,
    date('Y-m-d H:i:s')
]);

echo json_encode(['success' => true]);
