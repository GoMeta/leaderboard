<?php
require("../db.php");

/* Set JSON Response Type */
header('Content-Type: application/json');

/* Validate input */
foreach ([ 'name', 'logo', 'description' ] as $required) {
    if ( ! isset($_POST[$required])) {
        echo json_encode([ 'result' => 'error', 'message' => 'You must specify a \''.$required.'\'.' ]);
        exit;
    }
}

if ( ! preg_match('/^[a-z0-9 .\-]+$/i', $_POST['name'])) {
    echo json_encode([ 'result' => 'error', 'message' => '\'name\' must not contain special characters.' ]);
    exit;
}

/* Create database */
$apikey = strtoupper(md5(rand(50000, 100000)));
$stmt = $db->prepare('INSERT INTO leaderboard VALUES (\'\', ?, ?, ?, ?, ?, ?, false)');
$now = Date("Y-m-d H:i:s", strtotime('now'));
$stmt->bind_param('ssssss', $_POST['name'], $_POST['logo'], $_POST['description'], $apikey, $now, $now);
$stmt->execute();

/* Send Response */
echo json_encode([ 'result' => 'success', 'id' => $stmt->insert_id, 'apikey' => $apikey ]);