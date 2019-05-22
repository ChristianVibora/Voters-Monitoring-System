<html>
<head>
<title>User Log-In</title>
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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["login"])) {
		$user = Users::check_user_login(validateinput($_POST["username"]), md5(validateinput($_POST["password"])));
		if (count($user) == 1) {
			$_SESSION["logged"] = "true";
			$_SESSION["username"] = $user[0]->get_username();
			$_SESSION["fullname"] = $user[0]->get_firstname() . " " . $user[0]->get_lastname();
			$_SESSION["user_level"] = $user[0]->get_user_level();
			echo "<script>messagealert('Welcome ". $_SESSION["user_level"] .": ". $_SESSION["fullname"] ."!'); window.location='welcome.php';</script>";
		}
		else {
			echo "<script>messagealert('Username and Password Not Found! Please Try Again.')</script>";
		}
	}
}
if ($_SERVER["REQUEST_METHOD"] == "GET") {
	if (isset($_GET["logout"])=="true") {
		session_unset();
		session_destroy();
	}
}
?>
<body>
<center>
<br/>
<h1>User Log-In</h1>
<br/><br/>
</center>
<div id="cssmenu">
				<ul>
				   <li class="active"><a href="login.php"><span>Log-In</span></a></li>
				</ul>
			</div>
<center>
<br/><br/>
<form method="POST" action="login.php">
<label>Username: </label><input type="text" name="username" autofocus required><br/><br/>
<label>Password: </label><input type="password" name="password" required><br/><br/>
<input type="submit" name="login" value="Log-In">
</form>
</body>
</html>
