<?php
session_start();
include "classes/barangays.php";
include "classes/clusters.php";
include "classes/voters.php";
include "connection.php";
include "functions.php";

if (!isset($_SESSION["logged"])) {echo "<script>window.location='login.php';</script>";}

?>
<html>
<head>
<title>Voters Search</title>
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
<h1>Voters Search</h1>
<br><br/>
</center>
<div id="cssmenu">
				<ul>
				<li><a href="welcome.php"><span>Home</span></a></li>
				   <li><a href="age-brackets.php" target="_blank"><span>Age Brackets</span></a></li>
				   <li><a href="birthday-celebrants.php"><span>Birthday Celebrants</span></a></li>
				   <li><a href="voters-list.php"><span>Voters List</span></a></li>
				   <li class="active"><a href="voters-search.php"><span>Voters Search</span></a></li>
				   <li><a>Encoding</a>
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
<br/><br/>
</div>
<center>
<form method="POST" action="voters-search.php" class="printignore">
<table>
<tr>
<td>
<label>Search Voter's Name: </label>
</td>
<td>
<input type="text" name="search_keyword" autocomplete="off" autofocus required>
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
		if ($_SESSION["user_level"] == "Admin") {
			generate_voters_search_list(validateinput($_POST["search_keyword"]), true);
		}
		else {
			generate_voters_search_list(validateinput($_POST["search_keyword"]), false);
		}
	}
}

?>
</body>
</html>