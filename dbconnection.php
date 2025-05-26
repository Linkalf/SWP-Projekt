<?php
try {
    $dsn = "mysql:host=localhost;dbname=gamespace;charset=utf8";

    $pdo = new PDO($dsn, 'root', '');
} catch (PDOException $e) {
    die("Fehler beim Verbindungsaufbau mit der Datenbank");
}

?>