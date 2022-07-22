<?php

$host = "localhost";
$username = "root";
$user_pass = "1234";
$database_in_use = "project2021";

$db = new mysqli($host, $username, $user_pass, $database_in_use);

//Check connection
if ($db->connect_errno) {
    echo "Failed to connect to MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
}
?>