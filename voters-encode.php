<?php
session_start();
include "classes/barangays.php";
include "classes/clusters.php";
include "classes/voters.php";
include "connection.php";
include "functions.php";

$selected = $disabled = $result = $result_color = "";
	
	if (!isset($_SESSION["logged"])) {echo "<script>window.location='login.php';</script>";}
	
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	unset($_SESSION["success"]); 
	if (isset($_POST["barangay_form"])) {
		$_SESSION["selected_barangay"] = $_POST["barangay"];
		unset($_SESSION["selected_cluster"]);
		}
	if (isset($_POST["cluster_form"])) {$_SESSION["selected_cluster"] = $_POST["cluster"];}
	if (isset($_POST["voter"])) {
		if (Voters::add_voter($_SESSION["selected_barangay"], $_SESSION["selected_cluster"], strtoupper(validateinput($_POST["firstname"])), strtoupper(validateinput($_POST["middlename"])), strtoupper(validateinput($_POST["lastname"])), $_SESSION["username"]) === true) {
			$_SESSION["success"] = "true";
			echo "<script>window.location='voters-encode.php'</script>";
		}
		else {
			$_SESSION["success"] = "false";
			echo "<script>window.location='voters-encode.php'</script>";
			
		}
	}
}
?>
<html>
<head>
<title>Voters Encoding</title>
<script src="js/jquery-1.12.2.min.js" type="text/javascript"></script>
<script src="js/script.js" type="text/javascript"></script>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/print.css">
<link rel="stylesheet" type="text/css" href="css/menu.css">
</head>
<body>
<center>
<br/>
<h1>Voters Encoding</h1>
<br/><br/>
</center>
<div id="cssmenu">
				<ul>
				<li><a href="welcome.php"><span>Home</span></a></li>
				   <li><a href="age-brackets.php" target="_blank"><span>Age Brackets</span></a></li>
				   <li><a href="birthday-celebrants.php"><span>Birthday Celebrants</span></a></li>
				   <li><a href="voters-list.php"><span>Voters List</span></a></li>
				   <li><a href="voters-search.php"><span>Voters Search</span></a></li>
				   <li class="activeSS"><a>Encoding</a>
				   <ul>
				   <li><a href="voters-encode.php"><span>Voters Encoding</span></a></li>
				   <li><a href="leaders-encode.php"><span>Leaders Encoding</span></a></li>
				   <li><a href="votes-encode.php"><span>Tags Encoding</span></a></li>
				   </ul>
				   </li>
				   <li><a>Reports</a>
				   <ul>
				   <li><a href="votes-voter-report.php"><span>Tags By Voter Report</span></a></li>
				   <li><a href="votes-leader-report.php"><span>Tags By Leader Report</span></a></li>
				   <li><a href="votes-date-report.php"><span>Tags By Date Report</span></a></li>
				   <li><a href="votes-barangay-report.php"><span>Tags By Barangay Report</span></a></li>
				   <li><a href="votes-cluster-report.php"><span>Tags By Cluster Report</span></a></li>
				   </ul>
				   </li>
				   <li><a href="register.php"><span>User Registration</span></a></li>
				   <li><a href="login.php?logout=true"><span>Log-Out</span></a></li>
				</ul>
			</div>
<center>
<br/>
<?php
if (isset($_SESSION["success"])) {
	if ($_SESSION["success"] == "true") {
		$result = "Voter Successfully Encoded!";
		$result_color = "green";
	}
	else {
		$result = "Something Went Wrong! Please Try Again.";
		$result_color = "red";
	}
?>
<h5 style="color:<?php echo $result_color;?>"><?php echo $result; }?></h5>
<br/>
<table>
<tr>
<td>
<label>Select Barangay: </label>
</td>
<td>
<form method="POST" action="voters-encode.php" id="barangay_form">
<select name="barangay" oninput="submit_form('barangay_form')">
<option value="0" selected disabled></option>
<?php $barangays = Barangays::view_all_barangays();
	for ($i=0;$i<count($barangays);$i++) {
		if (isset($_SESSION["selected_barangay"])) {
			if ($barangays[$i]->get_barangay_id() == $_SESSION["selected_barangay"]) {$selected = "selected";}
			else {$selected = "";}
		}
		echo "<option value=", $barangays[$i]->get_barangay_id(), " $selected> " . $barangays[$i]->get_barangay_name() . "</option>";
	}
?>
</select>
<input type="hidden" name="barangay_form">
</form>
</td>
</tr>
<tr><td><br/></td></tr>
<tr>
<td>
<?php if (isset($_SESSION["selected_barangay"])) {
	$disabled="";
	$clusters = Clusters::view_clusters_by_barangay($_SESSION["selected_barangay"]);
	} 
	else {$disabled="disabled";}?>
<label>Select Precinct Number: </label>
</td>
<td>
<form method="POST" action="voters-encode.php" id="cluster_form" name="cluster_form">
<select name="cluster" oninput="submit_form('cluster_form')" <?php echo $disabled; ?>>
<option value="0" selected disabled></option>
<?php if (isset($_SESSION["selected_barangay"])) {
		for ($i=0;$i<count($clusters);$i++) {
			if (isset($_SESSION["selected_cluster"])) {
				if ($clusters[$i]->get_cluster_id() == $_SESSION["selected_cluster"]) {$selected = "selected";}
				else {$selected = "";}
			}
			echo "<option value=". $clusters[$i]->get_cluster_id() ." $selected $disabled>". $clusters[$i]->get_precint_number() ."</option>";
		}
	}
?>
</select>
<input type="hidden" name="cluster_form">
</form>
</td>
<tr><td><br/></td></tr>
</tr>
<tr>
<td align="center" colspan=2>
<form method="POST" action="voters-encode.php" id="voters_name" autocomplete="off">
<?php if (isset($_SESSION["selected_cluster"])) {$disabled="";} 
	else {$disabled="disabled";}?>
<label>Firstname: </label><input type="text" name="firstname" <?php echo $disabled; ?> autofocus required><br/><br/>
<label>Middlename: </label><input type="text" name="middlename" <?php echo $disabled; ?>><br/><br/>
<label>Lastname: </label><input type="text" name="lastname" <?php echo $disabled; ?> required><br/><br/><br/>
<input type="submit" name="voter" value="Submit" <?php echo $disabled; ?>>
</form>
</td>
</tr>
</table>
</body>
</html>