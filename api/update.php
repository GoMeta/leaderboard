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

if ( ! $leaderboard) {
    echo json_encode([ 'result' => 'error', 'message' => 'Invalid API key.' ]);
    exit;
}

/* Validate input */
foreach ([ 'increment' ] as $required) {
    if ( ! isset($_POST[$required])) {
        echo json_encode([ 'result' => 'error', 'message' => 'You must specify a \''.$required.'\'.' ]);
        exit;
    }
}

if ( ! is_numeric($_POST['increment'])) {
    echo json_encode([ 'result' => 'error', 'message' => '\'increment\' must be a number.' ]);
    exit;
}

/* Check if Score exists for user */
$stmt = $db->prepare('SELECT s.id FROM scores s WHERE s.username = ? AND s.leaderboard = ?');
$stmt->bind_param('si', $_POST['username'], $leaderboard['id']);
$stmt->execute();
$result = $stmt->get_result();
$score = $result->fetch_array(MYSQLI_ASSOC);

/* Insert or update score */
if ( ! $score) {
    $stmt = $db->prepare('INSERT INTO scores VALUES(\'\', ?, ?, ?, ?, ?)');
    $stmt->bind_param('isiss', $leaderboard['id'], $_POST['username'], $_POST['increment'],
        Date("Y-m-d H:i:s", strtotime('now')), Date("Y-m-d H:i:s", strtotime('now')));
} else {
    $stmt = $db->prepare('UPDATE scores SET score = score + ?, last_updated = ? WHERE username = ? AND leaderboard = ?');
    $stmt->bind_param('issi', $_POST['increment'], Date("Y-m-d H:i:s", strtotime('now')), $_POST['username'],  $leaderboard['id']);
}
$stmt->execute();

/* Send Response */
echo json_encode([ 'result' => 'success' ]);