<?php
session_start();
include "classes/barangays.php";
include "classes/clusters.php";
include "classes/leaders.php";
include "classes/votes.php";
include "classes/voters.php";
include "connection.php";
include "functions.php";

$selected = $disabled = "";

if (!isset($_SESSION["logged"])) {echo "<script>window.location='login.php';</script>";}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["barangay_form"])) {$_SESSION["selected_barangay2"] = $_POST["barangay"]; unset($_SESSION["selected_leader"]);}
	if (isset($_POST["leader_form"])) {$_SESSION["selected_leader"] = $_POST["leader"]; unset($_SESSION["selected_date"]);}
	if (isset($_POST["date_form"])) {$_SESSION["selected_date"] = $_POST["record_date"];}
}
?>
<html>
<head>
<title>Tags Encoding</title>
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
<h1>Tags Encoding</h1>
<br/><br/>
</center>
<div id="cssmenu">
				<ul>
				<li><a href="welcome.php"><span>Home</span></a></li>
				   <li><a href="age-brackets.php" target="_blank"><span>Age Brackets</span></a></li>
				   <li><a href="birthday-celebrants.php"><span>Birthday Celebrants</span></a></li>
				  <li><a href="voters-list.php"><span>Voters List</span></a></li>
				   <li><a href="voters-search.php"><span>Voters Search</span></a></li>
				   <li class="active"><a>Encoding</a>
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
<br/><br/>
<table>
<tr>
<td>
<label>Select Barangay: </label>
</td>
<td>
<form method="POST" action="votes-encode.php" id="barangay_form">
<select name="barangay" oninput="submit_form('barangay_form')">
<option value="0" selected disabled></option>
<?php $barangays = Barangays::view_all_barangays();
	for ($i=0;$i<count($barangays);$i++) {
		if (isset($_SESSION["selected_barangay2"])) {
			if ($barangays[$i]->get_barangay_id() == $_SESSION["selected_barangay2"]) {$selected = "selected";}
			else {$selected = "";}
		}
		echo "<option value=". $barangays[$i]->get_barangay_id() ." $selected> ". $barangays[$i]->get_barangay_name() ."</option>";
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
<?php if (isset($_SESSION["selected_barangay2"])) {
	$disabled="";
	$leaders = Leaders::view_leaders_by_barangay($_SESSION["selected_barangay2"]);
	} 
	else {$disabled="disabled";}?>
<label>Select Leader: </label>
</td>
<td>
<form method="POST" action="votes-encode.php" id="leader_form">
<select name="leader" oninput="submit_form('leader_form')" <?php echo $disabled; ?>>
<option value="0" selected disabled></option>
<?php if (isset($_SESSION["selected_barangay2"])) {
		for ($i=0;$i<count($leaders);$i++) {
			if (isset($_SESSION["selected_leader"])) {
				if ($leaders[$i]->get_leader_id() == $_SESSION["selected_leader"]) {$selected = "selected";}
			else {$selected = "";}
		}
			echo "<option value=". $leaders[$i]->get_leader_id() ." $selected $disabled>". $leaders[$i]->get_leader_lastname() .", ". $leaders[$i]->get_leader_firstname() ." ". $leaders[$i]->get_leader_middlename() ."</option>";
		}
	}
?>
</select>
<input type="hidden" name="leader_form">
</form>
</td>
<tr><td><br/></td></tr>
</tr>
<tr>
<td>
<?php if (isset($_SESSION["selected_leader"])) {$disabled="";} 
	else {$disabled="disabled"; unset($_SESSION["selected_date"]);}
	if (isset($_SESSION["selected_date"])) {$selected_date=$_SESSION["selected_date"];}
	else {$selected_date="";}
	?>
<label>Select Date: </label>
</td>
<td>
<form method="POST" action="votes-encode.php" id="date_form">
<input type="date" name="record_date" value="<?php echo $selected_date; ?>" oninput="submit_form('date_form')" <?php echo $disabled; ?>>
<input type="hidden" name="date_form">
</form>
</td>
</tr>
<tr><td><br/></td></tr>
<tr>
<td align="center" colspan=2>
<?php if (isset($_SESSION["selected_date"])) {$disabled="";} 
	else {$disabled="disabled";} ?>
<form method="POST" action="votes-encode.php">
<input type="submit" name="next" value="Next" <?php echo $disabled; ?>>
</form>
</td>
</tr>
</table>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["next"])) {
		?>
		<form method="POST" action="votes-encode.php">
		<?php
		generate_votes_encode_list($_SESSION["selected_barangay2"]);
		?>
		<br/>
		<input type="submit" name="submit_votes" value="Submit Tags">
		</form>
		<?php
	}
	if (isset($_POST["submit_votes"])) {
		if (isset($_POST["voter_ids"])) {
			$success = 0;
			for ($i=0;$i<count($_POST["voter_ids"]);$i++) {
				if (Votes::check_vote_exists($_POST["voter_ids"][$i], $_SESSION["selected_leader"], $_SESSION["selected_date"]) === false) {
					if (Votes::add_votes($_POST["voter_ids"][$i], $_SESSION["selected_leader"], $_SESSION["selected_barangay2"], $_SESSION["selected_date"], $_SESSION["username"]) === true) {
						if (Votes::update_votes($_POST["voter_ids"][$i]) === true) {
							$success++;
						}
					}
				}
				else {
					if (Votes::add_votes($_POST["voter_ids"][$i], $_SESSION["selected_leader"], $_SESSION["selected_barangay2"], $_SESSION["selected_date"], $_SESSION["username"]) === true) {
						$success++;
					}
				}
			}
			echo "<script>messagealert('$success Tags Have Been Registered! Thank You.'); window.location='votes-encode.php';</script>";
		}
	}
}
?>
</body>
</html>