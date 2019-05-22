<?php
class Votes {
	private $id;
	private $votes_0;
	private $votes_1;
	private $votes_2;
	private $votes_3;
	private $votes_4;
	private $votes_5;
	private $voter_id;
	private $votes_date;
	
	function __construct(){

	}
	
	public function set_id($id) {
		$this->id = $id;
	}
	
	public function set_votes_0($votes_0) {
		$this->votes_0 = $votes_0;
	}
	
	public function set_votes_1($votes_1) {
		$this->votes_1 = $votes_1;
	}
	
	public function set_votes_2($votes_2) {
		$this->votes_2 = $votes_2;
	}
	
	public function set_votes_3($votes_3) {
		$this->votes_3 = $votes_3;
	}
	
	public function set_votes_4($votes_4) {
		$this->votes_4 = $votes_4;
	}
	
	public function set_votes_5($votes_5) {
		$this->votes_5 = $votes_5;
	}
	
	public function set_voter_id($voter_id) {
		$this->voter_id = $voter_id;
	}
	
	public function set_votes_date($votes_date) {
		$this->votes_date = $votes_date;
	}
	
	public function get_id() {
		return $this->id;
	}
	
	public function get_votes_0() {
		return $this->votes_0;
	}
	
	public function get_votes_1() {
		return $this->votes_1;
	}
	
	public function get_votes_2() {
		return $this->votes_2;
	}
	
	public function get_votes_3() {
		return $this->votes_3;
	}
	
	public function get_votes_4() {
		return $this->votes_4;
	}
	
	public function get_votes_5() {
		return $this->votes_5;
	}
	
	public function get_voter_id() {
		return $this->voter_id;
	}
	
	public function get_votes_date() {
		return $this->votes_date;
	}
	
	public static function add_votes($voter_id, $leader_id, $barangay_id, $date_recorded, $encoder) {
		include __DIR__ . "/../connection.php";
		
		$sql="INSERT INTO votes (voter_id, leader_id, barangay_id, date_recorded, encoder) VALUES ('$voter_id', '$leader_id' ,'$barangay_id', '$date_recorded', '$encoder')";
		$result = $connection->query($sql);
		
		return $result;
	}
	
	public static function update_votes($voter_id) {
		include __DIR__ . "/../connection.php";
		
		$sql="UPDATE voters SET votes=votes+1 WHERE voter_id='$voter_id'";
		$result = $connection->query($sql);
		
		return $result;
	}
	
	public static function check_vote_exists($voter_id, $leader_id, $date_recorded) {
		include __DIR__ . "/../connection.php";
		
		$sql = "SELECT * FROM votes WHERE voter_id = '$voter_id' AND date_recorded = '$date_recorded'";
		$result = $connection->query($sql);

		if ($result->num_rows == 1) {
			return true;
		}
		return false;
	}
	
	public static function count_votes($table, $id, $number) {
		include __DIR__ . "/../connection.php";
		
		$number_votes = 0;
		$op="=";
		if ($number == 5) {
			$op	=">=";
		}
		$sql = "SELECT COUNT(*) AS votes_number FROM voters WHERE $table = '$id' AND votes $op '$number'";
		$result = $connection->query($sql);

		if ($result->num_rows == 1) {
			while ($row = $result->fetch_object()) {
				$number_votes = $row->votes_number;
			}
		}
		return $number_votes;
	}
	
	public static function view_votes_by_barangay($barangays) {
		include __DIR__ . "/../connection.php";
		
		$data = array();
		$table = "voter_barangay";
		for ($i=0;$i<count($barangays);$i++) {
			$barangay_id = $barangays[$i]->get_barangay_id();
			$rows = new Votes();
			$rows->set_id($barangay_id);
			$rows->set_votes_0(Votes::count_votes($table, $barangay_id, 0));
			$rows->set_votes_1(Votes::count_votes($table, $barangay_id, 1));
			$rows->set_votes_2(Votes::count_votes($table, $barangay_id, 2));
			$rows->set_votes_3(Votes::count_votes($table, $barangay_id, 3));
			$rows->set_votes_4(Votes::count_votes($table, $barangay_id, 4));
			$rows->set_votes_5(Votes::count_votes($table, $barangay_id, 5));
			$data[$i] = $rows;
		}
		return $data;	
	}

	public static function view_votes_by_cluster($clusters) {
		include __DIR__ . "/../connection.php";
		
		$data = array();
		$table = "voter_cluster";
		for ($i=0;$i<count($clusters);$i++) {
			$cluster_id = $clusters[$i]->get_cluster_id();
			$rows = new Votes();
			$rows->set_id($cluster_id);
			$rows->set_votes_0(Votes::count_votes($table, $cluster_id, 0));
			$rows->set_votes_1(Votes::count_votes($table, $cluster_id, 1));
			$rows->set_votes_2(Votes::count_votes($table, $cluster_id, 2));
			$rows->set_votes_3(Votes::count_votes($table, $cluster_id, 3));
			$rows->set_votes_4(Votes::count_votes($table, $cluster_id, 4));
			$rows->set_votes_5(Votes::count_votes($table, $cluster_id, 5));
			$data[$i] = $rows;
		}
		return $data;	
	}
	
	public static function view_votes_by_leader($leader_id, $voter_id) {
		include __DIR__ . "/../connection.php";
		
		$number_votes = 0;
		$sql = "SELECT COUNT(*) AS votes_number FROM votes WHERE leader_id = '$leader_id' AND voter_id = '$voter_id'";
		$result = $connection->query($sql);

		if ($result->num_rows == 1) {
			while ($row = $result->fetch_object()) {
				$number_votes = $row->votes_number;
			}
		}
		return $number_votes;
	}
	
	public static function view_vote_dates_by_barangay($barangay_id) {
		include __DIR__ . "/../connection.php";
		$data = array();
		$sql="SELECT DISTINCT date_recorded FROM votes WHERE barangay_id = '$barangay_id'";
		$result = $connection->query($sql);
		
		$i=0;
		if ($result->num_rows > 0) {
			while ($row=$result->fetch_object()) {
				$rows = new Votes();
				$rows->set_votes_date($row->date_recorded);
				$data[$i] = $rows;
				$i++;
			}
		}
		return $data;
	}
	
	public static function view_votes_by_date($leader_id, $date) {
		include __DIR__ . "/../connection.php";
		
		$data = array();
		$sql = "SELECT * FROM votes WHERE leader_id = '$leader_id' AND date_recorded = '$date' ORDER BY voter_id";
		$result = $connection->query($sql);

		$i=0;
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_object()) {
				$rows = new Votes();
				$rows->set_voter_id($row->voter_id);
				$data[$i] = $rows;
				$i++;
			}
		}
		return $data;
	}
}


?>