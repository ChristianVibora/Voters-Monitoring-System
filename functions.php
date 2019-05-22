<?php

function validateinput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = addslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
	
function check_username($username) {
	include "connection.php";
	
	$username = validateinput($username);
	
	$sql = "SELECT * FROM users WHERE username = '$username'";
	$result = $connection->query($sql);
	
	if ($result->num_rows > 0) {
		return true;
	}
	return false;
}

function check_password($password, $confirm_password) {
	if (validateinput($password) == validateinput($confirm_password)) {
		return true;
	}
	else return false;
}
function generate_voters_list($voter_barangay, $voter_cluster) {
	$voters = Voters::view_voters_by_cluster($voter_barangay, $voter_cluster, "voter_id");
	?>
		<br/><hr class="printignore"/><br/>
		<h2><?php echo "Brgy. " . Barangays::view_barangay_name_by_id($voter_barangay); ?></h2>
		<h3><?php echo "Precinct " . Clusters::view_precint_number_by_id($voter_cluster); ?></h3>
		<br/>
		<?php if (count($voters) > 0) { ?>
		<table class="list">
		<tr class="list-header"><th>Number</th><th>Lastname</th><th>Firstname & Middlename</th>
		</tr>
		<?php for ($i=0;$i<count($voters);$i++) { ?>
		<tr class="list-row">
		<td><?php echo $i+1; ?></td>
		<td><?php echo $voters[$i]->get_voter_lastname(); ?></td>
		<td><?php echo $voters[$i]->get_voter_firstname_middlename();?></td>
		<?php } ?>
		</table>
		<?php } else { ?>
		<h4>No Results Found</h4>
		<?php } ?>
		<div class="pagebreak"></div>
<?php } 

function generate_votes_voter_list($voter_barangay, $voter_cluster, $sort) {
	
	$precint_view = false;
	
	if ($voter_cluster == "All") {
		$voters = Voters::view_voters_by_barangay($voter_barangay, $sort);
		$precint_view = true;
		$precint_header = "All Precincts";
	}
	else {
		$voters = Voters::view_voters_by_cluster($voter_barangay, $voter_cluster, $sort);
		$precint_header = "Precinct " . Clusters::view_precint_number_by_id($voter_cluster);
	}	
	?>
		<br/><hr class="printignore"/><br/>
		<h2><?php echo "Brgy. " . Barangays::view_barangay_name_by_id($voter_barangay); ?></h2>
		<h3><?php echo $precint_header; ?></h3>
		<br/>
		<table class="list">
		<tr class="list-header"><th>Number</th><th>Lastname</th><th>Firstname & Middlename</th>
		<?php if ($precint_view === true) { ?><th>Precinct Number</th><?php } ?>
		<th>Votes</th>
		</tr>
		<?php for ($i=0;$i<count($voters);$i++) { ?>
		<tr class="list-row">
		<td><?php echo $i+1; ?></td>
		<td><?php echo $voters[$i]->get_voter_lastname(); ?></td>
		<td><?php echo $voters[$i]->get_voter_firstname_middlename();?></td>
		<?php  if ($precint_view === true) {echo "<td>". Clusters::view_precint_number_by_id($voters[$i]->get_voter_cluster()) ."</td>";} ?>
		<td><?php echo $voters[$i]->get_votes();?></td>
		</tr>
		<?php } ?>
		</table>
		<div class="pagebreak"></div>
<?php } 

function generate_votes_encode_list($voter_barangay) {
	
	$voters = Voters::view_voters_by_barangay($voter_barangay, "lastname");
		?>
		<br/><hr class="printignore"/><br/>
		<h2><?php echo "Brgy. " . Barangays::view_barangay_name_by_id($voter_barangay); ?></h2>
		<br/>
		<table class="list">
		<tr class="list-header"><th>Number</th><th>Select</th><th>Lastname, Firstname Middlename</th><th>Precinct Number</th></tr>
		<?php for ($i=0;$i<count($voters);$i++) { ?>
		<tr class="list-row">
		<td><?php echo $i+1; ?></td>
		<td><input type="checkbox" name="voter_ids[]" value="<?php echo $voters[$i]->get_voter_id(); ?>"></td>
		<td><?php echo $voters[$i]->get_voter_lastname() . ", " . $voters[$i]->get_voter_firstname_middlename(); ?></td>
		<td><?php echo Clusters::view_precint_number_by_id($voters[$i]->get_voter_cluster()); ?></td>
		</tr>
		<?php } ?>
		</table>
<?php } 

function generate_votes_by_leader_list($voter_barangay, $leader) {
	
	$voters = Voters::view_voters_by_barangay($voter_barangay, "lastname");
		?>
		<br/><hr class="printignore"/><br/>
		<h2><?php echo "Brgy. " . Barangays::view_barangay_name_by_id($voter_barangay); ?></h2>
		<h3><?php echo $leader->get_leader_lastname() . ", " . $leader->get_leader_firstname() . " " . $leader->get_leader_middlename(); ?></h3>
		<br/>
		<table class="list">
		<tr class="list-header"><th>Number</th><th>Lastname</th><th>Firstname & Middlename</th><th>Precinct Number</th><th>Votes</th></tr>
		<?php for ($i=0;$i<count($voters);$i++) { ?>
		<tr class="list-row">
		<td><?php echo $i+1; ?></td>
		<td><?php echo $voters[$i]->get_voter_lastname(); ?></td>
		<td><?php echo $voters[$i]->get_voter_firstname_middlename();?></td>
		<td><?php echo Clusters::view_precint_number_by_id($voters[$i]->get_voter_cluster()); ?></td>
		<td><?php echo Votes::view_votes_by_leader($leader->get_leader_id(), $voters[$i]->get_voter_id()); ?> </td>
		</tr>
		<?php } ?>
		</table>
		<div class="pagebreak"></div>
		
<?php } 

function generate_votes_by_date_list($barangay, $leader, $date) {
	
	$leader = Leaders::view_leader_by_id($leader);
	$votes = Votes::view_votes_by_date($leader->get_leader_id(), $date);
	
		?>
		<br/><hr class="printignore"/><br/>
		<h2><?php echo "Brgy. " . Barangays::view_barangay_name_by_id($barangay); ?></h2>
		<h3><?php echo $leader->get_leader_lastname() . ", " . $leader->get_leader_firstname() . " " . $leader->get_leader_middlename(); ?></h3>
		<h3><?php echo date_format(date_create($date), "F d, Y"); ?></h3>
		<br/>
		<?php if (count($votes) > 0) { ?>
		<table class="list">
		<tr class="list-header"><th>Number</th><th>Lastname</th><th>Firstname & Middlename</th><th>Precinct Number</th></tr>
		<?php for ($i=0;$i<count($votes);$i++) { 
			$voters = Voters::view_voters_by_id($votes[$i]->get_voter_id());
		?>
		<tr class="list-row">
		<td><?php echo $i+1; ?></td>
		<td><?php echo $voters->get_voter_lastname(); ?></td>
		<td><?php echo $voters->get_voter_firstname_middlename(); ?></td>
		<td><?php echo Clusters::view_precint_number_by_id($voters->get_voter_cluster()); ?></td>
		</tr>
		<?php } ?>
		</table>
		<?php } else { ?>
		<h4>No Results Found</h4>
		<?php } ?>
		<div class="pagebreak"></div>
<?php } 

function generate_voters_search_list($search_keyword, $votes_view) {
	
	$voters = Voters::view_voters_by_keyword($search_keyword);
	
	?>
		<br/><hr class="printignore"/><br/>
		<h2><?php echo "Search Results For: " . $search_keyword; ?></h2>
		<br/>
		<?php if (count($voters) > 0) { ?>
		<table class="list">
		<tr class="list-header"><th>Number</th><th>Lastname</th><th>Firstname & Middlename</th><th>Barangay</th><th>Precinct Number</th>
		<?php if ($votes_view === true) { ?><th>Votes</th><?php } ?>
		</tr>
		<?php for ($i=0;$i<count($voters);$i++) { ?>
		<tr class="list-row">
		<td><?php echo $i+1; ?></td>
		<td><?php echo $voters[$i]->get_voter_lastname(); ?></td>
		<td><?php echo $voters[$i]->get_voter_firstname_middlename();?></td>
		<td><?php echo Barangays::view_barangay_name_by_id($voters[$i]->get_voter_barangay()); ?></td>
		<td><?php echo Clusters::view_precint_number_by_id($voters[$i]->get_voter_cluster()); ?></td>
		<?php  if ($votes_view === true) {echo "<td>". $voters[$i]->get_votes() ."</td>";} ?>
		</tr>
		<?php } ?>
		</table>
		<?php } else { ?>
		<h4>No Results Found</h4>
		<?php } ?>
		<div class="pagebreak"></div>
<?php } 

function generate_birthday_celebrants_list($date_from, $date_to) {
	
	$birthdays = Birthdates::view_birthdates_by_keywords($date_from, $date_to);
	
	?>
		<br/><hr class="printignore"/><br/>
		<h2><?php echo "Birthday Celebrants from: " . date_format(date_create($date_from), "F d, Y") ." to ". date_format(date_create($date_to), "F d, Y"); ?></h2>
		<br/>
		<?php if (count($birthdays) > 0) { ?>
		<table class="list">
		<tr class="list-header"><th>Number</th><th>Lastname</th><th>Firstname & Middlename</th><th>Barangay</th><th>Date of Birth</th><th>Age (To Be)</th><th>Category</th></tr>
		<?php for ($i=0;$i<count($birthdays);$i++) { ?>
		<tr class="list-row">
		<td><?php echo $i+1; ?></td>
		<td><?php echo $birthdays[$i]->get_lastname(); ?></td>
		<td><?php echo $birthdays[$i]->get_firstname_middlename(); ?></td>
		<?php $voters = Voters::view_voters_by_keyword($birthdays[$i]->get_lastname() . " " . $birthdays[$i]->get_firstname_middlename());?>
		<td><?php if (count($voters) == 1) {echo Barangays::view_barangay_name_by_id($voters[0]->get_voter_barangay());} ?></td>
		<td><?php echo date_format(date_create($birthdays[$i]->get_date_of_birth()), "m/d/Y"); ?></td>
		<?php $age = date_diff(date_create($birthdays[$i]->get_date_of_birth()), date_create('now'))->y; ?>
		<td><?php if (date_diff(date_create($birthdays[$i]->get_date_of_birth()), date_create('now'))->m <= 0 && date_diff(date_create($birthdays[$i]->get_date_of_birth()), date_create('now'))->d <= 0) {echo $age;} else {echo $age+1;} ?></td>
		<?php
			if ($age >= 18 && $age <= 30) {$category = "Early Age";}
			else if ($age >= 31 && $age <= 45) {$category = "Middle Age";}
			else if ($age >= 46 && $age <= 59) {$category = "Late Age";}
			else if ($age >= 60) {$category = "Senior Age";}
		?>
		<td><?php echo $category; ?></td>
		</tr>
		<?php } ?>
		</table>
		<?php } else { ?>
		<h4>No Results Found</h4>
		<?php } ?>
		<div class="pagebreak"></div>
<?php } 

function get_percentage($number, $total) {
	if ($total == 0) {
		return "100%";
	}
	else
	$result = ($number/$total)*100;
	return number_format($result, 2) . "%";
}

?>