<?php
$db = new PDO('sqlite:db.sqlite');
$db->exec("CREATE TABLE IF NOT EXISTS eintraege (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    klasse TEXT NOT NULL,
    kilometer INTEGER NOT NULL,
    datum TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
echo "Datenbank erstellt.";
?>