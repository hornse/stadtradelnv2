<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['klasse'])) {
    http_response_code(403);
    echo "Nicht autorisiert.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $klasse = $_SESSION['klasse'];
    $kilometer = (int)$_POST['kilometer'];

    if ($kilometer > 0 && $kilometer <= 100) {
        $db = new PDO('sqlite:db.sqlite');
        $stmt = $db->prepare("INSERT INTO eintraege (klasse, kilometer) VALUES (?, ?)");
        $stmt->execute([$klasse, $kilometer]);
    }
}
header('Location: index.php');
?>
