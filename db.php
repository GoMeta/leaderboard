<?php
require("config.php");

/* Connect to Database */
$db = mysqli_connect(config['db']['host'], config['db']['username'], config['db']['password'], config['db']['database']);
if ($db->connect_errno) {
    echo "Error connecting to DB: (".$db->connect_errno.") ".$db->connect_error;
}