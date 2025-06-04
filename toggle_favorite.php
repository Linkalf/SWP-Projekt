<?php
session_start();
require_once("dbconnection.php");
//überprüft ob der User eingeloggt ist und ob der Game_id gesetzt ist
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || !isset($_POST['game_id'])) {
    echo json_encode(['status' => 'not_logged_in']);
    exit;
}
//überprüft ob der User eingeloggt ist und ob der Game_id gesetzt ist   
$user_id = $_SESSION['user_id'];
$game_id = intval($_POST['game_id']);
//überprüft ob der User eingeloggt ist und ob der Game_id gesetzt ist   
$sql = "SELECT * FROM favoriten WHERE user_id = ? AND game_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id, $game_id]);
//überprüft ob der User eingeloggt ist und ob der Game_id gesetzt ist   
if ($stmt->rowCount() > 0) {
    $delete = $pdo->prepare("DELETE FROM favoriten WHERE user_id = ? AND game_id = ?");
    $delete->execute([$user_id, $game_id]);
    $status = 'removed';
} else {
    //überprüft ob der User eingeloggt ist und ob der Game_id gesetzt ist   
    $insert = $pdo->prepare("INSERT INTO favoriten (user_id, game_id) VALUES (?, ?)");
    $insert->execute([$user_id, $game_id]);
    $status = 'added';
}

// Aktuelle Gesamtzahl abrufen
$countStmt = $pdo->prepare("SELECT COUNT(*) FROM favoriten WHERE game_id = ?");
$countStmt->execute([$game_id]);
$favoriteCount = $countStmt->fetchColumn();

echo json_encode(['status' => $status, 'count' => $favoriteCount]);
