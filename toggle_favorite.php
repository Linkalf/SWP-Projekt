<?php
session_start();
require_once("dbconnection.php");

header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || !isset($_POST['game_id'])) {
    echo json_encode(['status' => 'not_logged_in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$game_id = intval($_POST['game_id']);

$sql = "SELECT * FROM favoriten WHERE user_id = ? AND game_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id, $game_id]);

if ($stmt->rowCount() > 0) {
    $delete = $pdo->prepare("DELETE FROM favoriten WHERE user_id = ? AND game_id = ?");
    $delete->execute([$user_id, $game_id]);
    $status = 'removed';
} else {
    $insert = $pdo->prepare("INSERT INTO favoriten (user_id, game_id) VALUES (?, ?)");
    $insert->execute([$user_id, $game_id]);
    $status = 'added';
}

// Aktuelle Gesamtzahl abrufen
$countStmt = $pdo->prepare("SELECT COUNT(*) FROM favoriten WHERE game_id = ?");
$countStmt->execute([$game_id]);
$favoriteCount = $countStmt->fetchColumn();

echo json_encode(['status' => $status, 'count' => $favoriteCount]);
