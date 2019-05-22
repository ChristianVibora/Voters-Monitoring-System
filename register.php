<html>
<head>
<title>User Registration</title>
<script src="js/jquery-1.12.2.min.js" type="text/javascript"></script>
<script src="js/script.js" type="text/javascript"></script>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/print.css">
<link rel="stylesheet" type="text/css" href="css/menu.css">
</head>
<?php
session_start();
include "classes/users.php";
include "connection.php";
include "functions.php";

if (!isset($_SESSION["logged"]) || $_SESSION["user_level"] != "Admin") {echo "<script>window.location='login.php';</script>";}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["register"])) {
		
		if (check_username($_POST["username"]) === true) {
			echo "<script>messagealert('Username Not Available! Please Try Again.')</script>";
		}
		else if (check_password($_POST["password"], $_POST["confirm_password"]) === false) {
			echo "<script>messagealert('Password Does Not Match Confirm Password! Please Try Again.')</script>";
		}
		else {
			if (Users::add_user(validateinput($_POST["username"]), md5(validateinput($_POST["password"])), strtoupper(validateinput($_POST["firstname"])), strtoupper(validateinput($_POST["middlename"])), strtoupper(validateinput($_POST["lastname"])), $_POST["user_level"], $_SESSION["username"]) === true) {
				echo "<script>messagealert('Registration Successful! Thank You.'); window.location='welcome.php';</script>";
			}
			else {
				echo "<script>messagealert('Registration Failed! Please Try Again.'); window.location='register.php';</script>";
			}
		}
	}
}
?>
<body>
<center>
<br/>
<h1>User Registration</h1>
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
				   <li><a>Reports</a>
				   <ul>
				   <li><a href="votes-voter-report.php"><span>Tags By Voter Report</span></a></li>
				   <li><a href="votes-leader-report.php"><span>Tags By Leader Report</span></a></li>
				   <li><a href="votes-date-report.php"><span>Tags By Date Report</span></a></li>
				   <li><a href="votes-barangay-report.php"><span>Tags By Barangay Report</span></a></li>
				   <li><a href="votes-cluster-report.php"><span>Tags By Cluster Report</span></a></li>
				   </ul>
				   </li>
				   <li class="active"><a href="register.php"><span>User Registration</span></a></li>
				   <li><a href="login.php?logout=true"><span>Log-Out</span></a></li>
				</ul>
			</div>

<center>
<br/><br/>
<form method="POST" action="register.php" autocomplete="off">
<table>
<tr><td><label>Firstname: </label></td><td><input type="text" name="firstname" autofocus required></td></tr>
<tr><td><label>Middlename: </label></td><td><input type="text" name="middlename" required></td></tr>
<tr><td><label>Lastname: </label></td><td><input type="text" name="lastname" required></td></tr>
<tr><td><label>User Level: </label></td><td><select name="user_level" required>
<option value="0" selected disabled></option>
<option value="Admin">Administrator</option>
<option value="Encoder">Encoder</option></select></td></tr>
<tr><td><label>Username: </label></td><td><input type="text" name="username" required></td></tr>
<tr><td><label>Password: </label></td><td><input type="password" name="password" required></td></tr>
<tr><td><label>Confirm Password: </label></td><td><input type="password" name="confirm_password" required></td></tr>
</table>
<br/>
<input type="submit" name="register" value="Register">
</form>
</body>
</html>
