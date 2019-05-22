<?php
session_start();
include "classes/barangays.php";
include "classes/votes.php";
include "classes/voters.php";
include "connection.php";
include "functions.php";

if (!isset($_SESSION["logged"]) || $_SESSION["user_level"] != "Admin") {echo "<script>window.location='login.php';</script>";}

?>
<html>
<head>
<title>Tags By Barangay Report</title>
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
<h1>Tags By Barangay Report</h1>
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
<?php $barangays = Barangays::view_all_barangays(); 
$votes = Votes::view_votes_by_barangay($barangays);
?>
<table class="list">
<tr class="list-header">
<th>Number</th><th>Barangay</th><th>5 Tags & Above</th><th>4 Tags</th><th>3 Tags</th><th>2 Tags</th><th>1 Tags</th><th>0 Tags</th><th>Total</th>
</tr>
<?php
$total_overall_voters = $total_votes_0 = $total_votes_1 = $total_votes_2 = $total_votes_3 = $total_votes_4 = $total_votes_5 = 0;

for ($i=0;$i<count($votes);$i++) {
	$total_voters = Voters::count_voters("voter_barangay", $barangays[$i]->get_barangay_id());
	$total_overall_voters += $total_voters;
	$votes_0 = $votes[$i]->get_votes_0();
	$total_votes_0 += $votes_0;
	$votes_1 = $votes[$i]->get_votes_1();
	$total_votes_1 += $votes_1;
	$votes_2 = $votes[$i]->get_votes_2();
	$total_votes_2 += $votes_2;
	$votes_3 = $votes[$i]->get_votes_3();
	$total_votes_3 += $votes_3;
	$votes_4 = $votes[$i]->get_votes_4();
	$total_votes_4 += $votes_4;
	$votes_5 = $votes[$i]->get_votes_5();
	$total_votes_5 += $votes_5;
?>
<tr class="list-row">
<td><?php echo $i+1; ?></td>
<td><?php echo $barangays[$i]->get_barangay_name(); ?></td>
<td><?php echo number_format($votes_5) . " (". get_percentage($votes_5, $total_voters) .")"; ?></td>
<td><?php echo number_format($votes_4) . " (". get_percentage($votes_4, $total_voters) .")"; ?></td>
<td><?php echo number_format($votes_3) . " (". get_percentage($votes_3, $total_voters) .")"; ?></td>
<td><?php echo number_format($votes_2) . " (". get_percentage($votes_2, $total_voters) .")"; ?></td>
<td><?php echo number_format($votes_1) . " (". get_percentage($votes_1, $total_voters) .")"; ?></td>
<td><?php echo number_format($votes_0) . " (". get_percentage($votes_0, $total_voters) .")"; ?></td>
<td><?php echo number_format($total_voters); ?></td>
</tr>
<?php } ?>
<tr class="list-header">
<th></th>
<th>Total</th>
<th><?php echo number_format($total_votes_5) . " (". get_percentage($total_votes_5, $total_overall_voters) .")"; ?></th>
<th><?php echo number_format($total_votes_4) . " (". get_percentage($total_votes_4, $total_overall_voters) .")"; ?></th>
<th><?php echo number_format($total_votes_3) . " (". get_percentage($total_votes_3, $total_overall_voters) .")"; ?></th>
<th><?php echo number_format($total_votes_2) . " (". get_percentage($total_votes_2, $total_overall_voters) .")"; ?></th>
<th><?php echo number_format($total_votes_1) . " (". get_percentage($total_votes_1, $total_overall_voters) .")"; ?></th>
<th><?php echo number_format($total_votes_0) . " (". get_percentage($total_votes_0, $total_overall_voters) .")"; ?></th>
<th><?php echo number_format($total_overall_voters); ?></th>
</tr>
</table>
</body>
</html>
