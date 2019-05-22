<html>
<head>
<title>Age Brackets</title>
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
include "classes/birthdates.php";
include "connection.php";
include "functions.php";

if (!isset($_SESSION["logged"])) {echo "<script>window.location='login.php';</script>";}

$early = $middle = $late = $senior = $total = 0;

	$birthdates = Birthdates::view_all_birthdates();

	for ($i=0;$i<count($birthdates);$i++) {
		
		$age = date_diff(date_create($birthdates[$i]->get_date_of_birth()), date_create('now'))->y;
				
			if ($age >= 18 && $age <= 30) {$early++;}
			else if ($age >= 31 && $age <= 45) {$middle++;}
			else if ($age >= 46 && $age <= 59) {$late++;}
			else if ($age >= 60) {$senior++;}				
			$total++;
	}

?>
<body>
<center>
<br/>
<h1>Age Brackets</h1>
<br/><br/>
<div  class="printignore">
<div id="cssmenu">
	<ul>
		<li class="active"><a href="age-brackets.php"><span>Age Brackets</span></a></li>
	</ul>
</div>
<br/><br/>
</div>
<table  class="age_brackets">
<tr class="list-header"><th>Category</th><th>Age</th><th>Count</th><th>Percentage</th></tr>
<tr class="list-row"><td>Early Ages</td><td>18 - 30</td><td><?php echo number_format($early); ?></td><td><?php echo get_percentage($early, $total) ?></td></tr>
<tr class="list-row"><td>Middle Ages</td><td>31 - 45</td><td><?php echo number_format($middle); ?></td><td><?php echo get_percentage($middle, $total) ?></td></tr>
<tr class="list-row"><td>Late Ages</td><td>46 - 59</td><td><?php echo number_format($late); ?></td><td><?php echo get_percentage($late, $total) ?></td></tr>
<tr class="list-row"><td>Senior Ages</td><td>60 & Above</td><td><?php echo number_format($senior); ?></td><td><?php echo get_percentage($senior, $total) ?></td></tr>
<tr class="list-header"><td></td><td></td><th><?php echo "Total: " . number_format($total); ?></th><td></td></tr>
</table>
</body>
</html>