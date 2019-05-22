<?php
session_start();
include "classes/barangays.php";
include "classes/clusters.php";
include "classes/leaders.php";
include "classes/voters.php";
include "classes/votes.php";
include "connection.php";
include "functions.php";

$selected = $disabled = "";

if (!isset($_SESSION["logged"]) || $_SESSION["user_level"] != "Admin") {echo "<script>window.location='login.php';</script>";}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if (isset($_POST["barangay"])) {$_SESSION["selected_barangay4"] = $_POST["barangay"];}
	if (isset($_POST["leader"])) {$_SESSION["selected_leader2"] = $_POST["leader"];}
}
?>
<html>
<head>
<title>Tags By Leader Report</title>
<script src="js/jquery-1.12.2.min.js" type="text/javascript"></script>
<script src="js/script.js" type="text/javascript"></script>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/print.css">
<link rel="stylesheet" type="text/css" href="css/menu.css">
</head>
<body>
<div class="printignore">
<center>
<br/>
<h1>Tags By Leader Report</h1>
<br/><br/>
</center>
<div id="cssmenu">
				<ul>
				<li><a href="welcome.php"><span>Home</span></a></li>
				   <li><a href="age-brackets.php" target="_blank"><span>Age Brackets</span></a></li>
				   <li><a href="birthday-celebrants.php"><span>Birthday Celebrants</span></a></li>
				   <li><a href="voters-list.php"><span>Voters List</span></a></li>
				   <li><a href="voters-search.php"><span>Voters Search</span></a></li>
				   <li><a>Encoding</a>
				   <ul>
				   <li><a href="voters-encode.php"><span>Voters Encoding</span></a></li>
				   <li><a href="leaders-encode.php"><span>Leaders Encoding</span></a></li>
				   <li><a href="votes-encode.php"><span>Tags Encoding</span></a></li>
				   </ul>
				   </li>
				   <li class="active"><a>Reports</a>
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
<br/><br/>
</div>
<center>
<form method="POST" action="votes-leader-report.php" class="printignore" id="votes_leader_form">
<table>
<tr>
<td>
<label>Select Barangay: </label>
</td>
<td>
<select name="barangay" oninput="submit_form('votes_leader_form')">
<option value="all" selected>All</option>
<?php $barangays = Barangays::view_all_barangays();
	for ($i=0;$i<count($barangays);$i++) {
		if (isset($_SESSION["selected_barangay4"])) {
			if ($barangays[$i]->get_barangay_id() == $_SESSION["selected_barangay4"]) {$selected = "selected";}
			else {$selected = "";}
		}
		echo "<option value=". $barangays[$i]->get_barangay_id() ." $selected> ". $barangays[$i]->get_barangay_name() ."</option>";
	}
?>
</select>
</td>
</tr>
<tr><td><br/></td></tr>
<tr>
<td>
<?php if (isset($_SESSION["selected_barangay4"])) {$leaders = Leaders::view_leaders_by_barangay($_SESSION["selected_barangay4"]);} ?>
<label>Select Leader Name: </label>
</td>
<td>
<select name="leader">
<option value="all" selected>All</option>
<?php if (isset($_SESSION["selected_barangay4"])) {
		for ($i=0;$i<count($leaders);$i++) {
			if (isset($_SESSION["selected_leader2"])) {
				if ($leaders[$i]->get_leader_id() == $_SESSION["selected_leader2"]) {$selected = "selected";}
			else {$selected = "";}
		}
			echo "<option value=". $leaders[$i]->get_leader_id() ." $selected $disabled>". $leaders[$i]->get_leader_lastname() .", ". $leaders[$i]->get_leader_firstname() ." ". $leaders[$i]->get_leader_middlename() ."</option>";
		}
	}
?>
</select>
</td>
</tr>
<tr><td><br/></td></tr>
<tr>
<td align="center" colspan=2>
<input type="submit" name="search_voter" value="Search">
</td>
</tr>
</table>
</form>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["search_voter"])) {
		if ($_POST["barangay"] == "all" && $_POST["leader"] == "all") {
			for ($i=0;$i<count($barangays);$i++) {
				$leaders = Leaders::view_leaders_by_barangay($barangays[$i]->get_barangay_id());
				for ($j=0;$j<count($leaders);$j++) {
					generate_votes_by_leader_list($barangays[$i]->get_barangay_id(), $leaders[$j]);
				}
			}
		}
		else {
			if ($_POST["leader"] == "all") {
				for ($i=0;$i<count($leaders);$i++) {
					generate_votes_by_leader_list($_POST["barangay"], $leaders[$i]);
				}
			}
			else {
				$leader = Leaders::view_leader_by_id($_POST["leader"]);
				generate_votes_by_leader_list($_POST["barangay"], $leader);
			}
		}
		
	}
}

?>
</body>
</html>