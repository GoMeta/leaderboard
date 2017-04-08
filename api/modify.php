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
if ( ! isset($_POST['name']) && ! isset($_POST['logo']) && ! isset($_POST['description'])) {
    echo json_encode([ 'result' => 'success' ]);
    exit;
}

if (isset($_POST['name']) && ! preg_match('/^[a-z0-9 .\-]+$/i', $_POST['name'])) {
    echo json_encode([ 'result' => 'error', 'message' => '\'name\' must not contain special characters.' ]);
    exit;
}

/* Check if Score exists for user */
$update = [ ];
foreach ([ 'name', 'logo', 'description' ] as $key) {
    if (isset($_POST[$key])) {
        $stmt = $db->prepare('UPDATE leaderboard l SET l.'.$key.' = ? WHERE l.id = ?');
        $stmt->bind_param('si', $_POST[$key], $leaderboard['id']);
        $stmt->execute();
    }
}

/* Send Response */
echo json_encode([ 'result' => 'success' ]);