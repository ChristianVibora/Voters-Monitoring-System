<?php
include "connection.php";

$xml = simplexml_load_file("DOB.xml") or die("error");
$error=0;
$success=0;
$i=1;
foreach ($xml->children() as $row) {
	$name = $row->Voter_x0027_s_x0020_Name;
	$splitname = explode(",", $name);
	$dob = $row->DOB;
	
	
	$lastname = validateinput($splitname[0]);
	$firstmiddlename = validateinput($splitname[1]);
	
	$sql = "INSERT INTO demo (firstname_middlename, lastname, dob) VALUES ('$firstmiddlename', '$lastname', '$dob')";
	//$sql = "SELECT clusters.precint_number, barangays.barangay_name FROM clusters INNER JOIN barangays ON barangays.barangay_id=clusters.cluster_barangay WHERE clusters.cluster_id = '$precint' AND clusters.cluster_barangay = '$barangay'";
	$result = $connection->query($sql);

	if ($result === true) {
		echo "$i - $lastname, $firstmiddlename Imported! <br/>";
		$success++;
	}
	else {
		echo "$i - $lastname, $firstmiddlename Failed! <br/>";
		$error++;
	}
	$i++;
}
echo "<br/><br/>" . $success . "/s Successful Import<br/>";
echo $error . "/s Errors Occured";

function validateinput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = addslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
?>