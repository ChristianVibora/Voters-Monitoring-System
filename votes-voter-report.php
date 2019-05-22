<?php
session_start();
include "classes/barangays.php";
include "classes/clusters.php";
include "classes/voters.php";
include "connection.php";
include "functions.php";

$selected = $disabled = $checked = "";

if (!isset($_SESSION["logged"]) || $_SESSION["user_level"] != "Admin") {echo "<script>window.location='login.php';</script>";}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	if (isset($_POST["barangay"])) {$_SESSION["selected_barangay3"] = $_POST["barangay"];}
	if (isset($_POST["cluster"])) {$_SESSION["selected_cluster2"] = $_POST["cluster"];}
	if (isset($_POST["sort"])) {$_SESSION["selected_sort"] = $_POST["sort"];}
}
?>
<html>
<head>
<title>Tags By Voter Report</title>
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
<h1>Tags By Voter Report</h1>
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
<form method="POST" action="votes-voter-report.php" class="printignore" id="voters_list_form">
<table>
<tr>
<td>
<label>Select Barangay: </label>
</td>
<td>
<select name="barangay" oninput="submit_form('voters_list_form')">
<option value="All" selected>All</option>
<?php $barangays = Barangays::view_all_barangays();
	for ($i=0;$i<count($barangays);$i++) {
		if (isset($_SESSION["selected_barangay3"])) {
			if ($barangays[$i]->get_barangay_id() == $_SESSION["selected_barangay3"]) {$selected = "selected";}
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
<?php if (isset($_SESSION["selected_barangay3"])) {$clusters = Clusters::view_clusters_by_barangay($_SESSION["selected_barangay3"]);} ?>
<label>Select Cluster Number: </label>
</td>
<td>
<select name="cluster">
<option value="All" selected>All</option>
<?php if (isset($_SESSION["selected_barangay3"])) {
		for ($i=0;$i<count($clusters);$i++) {
			if (isset($_SESSION["selected_cluster2"])) {
				if ($clusters[$i]->get_cluster_id() == $_SESSION["selected_cluster2"]) {$selected = "selected";}
				else {$selected = "";}
			}
			echo "<option value=". $clusters[$i]->get_cluster_id() ." $selected $disabled>". $clusters[$i]->get_precint_number() ."</option>";
		}
	}
?>
</select>
</td>
</tr>
<tr><td><br/></td></tr>
<tr>
<td>
<label>Sort by: </label>
</td>
<td>
<input type="radio" name="sort" value="lastname" checked> <label>Lastname</label>
<?php if (isset($_SESSION["selected_sort"])) {
if ($_SESSION["selected_sort"] == "votes, lastname") {$checked = "checked";}} ?>
<input type="radio" name="sort" value="votes, lastname" <?php echo $checked; ?>> <label>Tags</label>
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
		
		if ($_POST["barangay"] == "All") {
			if ($_POST["cluster"] == "All") {
				for ($i=0;$i<count($barangays);$i++) {
					generate_votes_voter_list($barangays[$i]->get_barangay_id(), $_POST["cluster"], $_POST["sort"]);
				}
			}
		}
		else {
			if ($_POST["cluster"] == "All") {
				generate_votes_voter_list($_POST["barangay"], $_POST["cluster"], $_POST["sort"]);
			}
			else {
				generate_votes_voter_list($_POST["barangay"], $_POST["cluster"], $_POST["sort"]);
			}
		}
		
	}
}

?>
</body>
</html>