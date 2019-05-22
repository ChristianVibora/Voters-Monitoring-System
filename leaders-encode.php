<?php
session_start();
include "classes/barangays.php";
include "classes/clusters.php";
include "classes/leaders.php";
include "connection.php";
include "functions.php";

$selected = $disabled = $result = $result_color = "";
	
	if (!isset($_SESSION["logged"])) {echo "<script>window.location='login.php';</script>";}
	
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	unset($_SESSION["success2"]); 
	if (isset($_POST["barangay_form"])) {
		$_SESSION["selected_barangay5"] = $_POST["barangay"];
		}
		if (isset($_POST["leader"])) {
			if (Leaders::add_leader($_SESSION["selected_barangay5"], strtoupper(validateinput($_POST["firstname"])), strtoupper(validateinput($_POST["middlename"])), strtoupper(validateinput($_POST["lastname"])), $_SESSION["username"]) === true) {
				$_SESSION["success2"] = "true";
				echo "<script>window.location='leaders-encode.php'</script>";
			}
			else {
				$_SESSION["success2"] = "false";
				echo "<script>window.location='leaders-encode.php'</script>";
			}
	}
}
?>
<html>
<head>
<title>Leaders Encoding</title>
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
<h1>Leaders Encoding</h1>
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
<br/>
<?php
if (isset($_SESSION["success2"])) {
	if ($_SESSION["success2"] == "true") {
		$result = "Leader Successfully Encoded!";
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
<form method="POST" action="leaders-encode.php" id="barangay_form">
<select name="barangay" oninput="submit_form('barangay_form')">
<option value="0" selected disabled></option>
<?php $barangays = Barangays::view_all_barangays();
	for ($i=0;$i<count($barangays);$i++) {
		if (isset($_SESSION["selected_barangay5"])) {
			if ($barangays[$i]->get_barangay_id() == $_SESSION["selected_barangay5"]) {$selected = "selected";}
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
<td align="center" colspan=2>
<form method="POST" action="leaders-encode.php" id="leaders_name" autocomplete="off">
<?php if (isset($_SESSION["selected_barangay5"])) {$disabled="";} 
	else {$disabled="disabled";}?>
<label>Firstname: </label><input type="text" name="firstname" <?php echo $disabled; ?> autofocus required><br/><br/>
<label>Middlename: </label><input type="text" name="middlename" <?php echo $disabled; ?>><br/><br/>
<label>Lastname: </label><input type="text" name="lastname" <?php echo $disabled; ?> required><br/><br/><br/>
<input type="submit" name="leader" value="Submit" <?php echo $disabled; ?>>
</form>
</td>
</tr>
</table>
</body>
</html>