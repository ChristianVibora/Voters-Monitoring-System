<?php
#  © 2018 →rEVOLution← Studios #

$servername = "localhost";
$db_username = "root";
$db_password = "root";
$database = "project.x";

$connection = new mysqli($servername, $db_username, $db_password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>