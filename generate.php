<?php
include "connection.php";
include "classes/barangays.php";

$middlename = "Leader";
$lastname = "Admin";
 
for ($i=1;$i<=30;$i++) {
	$barangay = Barangays::view_barangay_name_by_id($i);
	$sql = "INSERT INTO leaders (leader_barangay, firstname, middlename, lastname, encoder) VALUES ('$i', '$barangay', '$middlename', '$lastname', 'admin')";
	$result = $connection->query($sql);
	echo $connection->error . " $i<br/>";
}
?>