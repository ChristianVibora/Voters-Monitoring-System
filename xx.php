<?php
include "connection.php";

$sql = "SELECT * FROM barangays";

$result = $connection->query($sql);

while ($rows = $result->fetch_object()) {
	$barangay = $rows->barangay_name;
	
	echo "$barangay, ";
}















?>