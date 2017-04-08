<?php
require("../db.php");

/* Set JSON Response Type */
header('Content-Type: application/json');

/* Check if Leaderboard exists */
$stmt = $db->prepare('SELECT l.id FROM leaderboard l WHERE deleted = false AND l.apikey = ?');
$stmt->bind_param('s', $_POST['apikey']);
$stmt->execute();
$result = $stmt->get_result();
$leaderboard = $result->fetch_array(MYSQLI_ASSOC);

if(!$leaderboard) {
    echo json_encode(['result' => 'error', 'message' => 'Invalid API key.']);
    exit;
}

/* Soft delete leaderboard */
$stmt = $db->prepare('UPDATE leaderboard SET deleted = true, last_updated = ? WHERE id = ?');
$stmt->bind_param('si', Date("Y-m-d H:i:s"), $leaderboard['id']);
$stmt->execute();

/* Send Response */
echo json_encode(['result' => 'success']);