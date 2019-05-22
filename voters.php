<?php
class Voters {
	private $voter_id;
	private $voter_barangay;
	private $voter_cluster;
	private $voter_firstname_middlename;
	private $voter_lastname;
	private $votes;
	
	function __construct(){

	}
	
	public function set_voter_id($voter_id) {
		$this->voter_id = $voter_id;
	}
	
	public function set_voter_barangay($voter_barangay) {
		$this->voter_barangay = $voter_barangay;
	}
	
	public function set_voter_cluster($voter_cluster) {
		$this->voter_cluster = $voter_cluster;
	}
	
	public function set_voter_firstname_middlename($voter_firstname_middlename) {
		$this->voter_firstname_middlename = $voter_firstname_middlename;
	}
	
	public function set_voter_lastname($voter_lastname) {
		$this->voter_lastname = $voter_lastname;
	}
	
	public function set_votes($votes) {
		$this->votes = $votes;
	}
	
	public function get_voter_id() {
		return $this->voter_id;
	}
	
	public function get_voter_barangay() {
		return $this->voter_barangay;
	}
	
	public function get_voter_cluster() {
		return $this->voter_cluster;
	}
	
	public function get_voter_firstname_middlename() {
		return $this->voter_firstname_middlename;
	}
	
	public function get_voter_lastname() {
		return $this->voter_lastname;
	}	
	
	public function get_votes() {
		return $this->votes;
	}	
	
	public static function add_voter($voter_barangay, $voter_cluster, $voter_firstname, $voter_middlename, $voter_lastname, $encoder) {
		include __DIR__ . "/../connection.php";
				
		$sql="INSERT INTO voters (voter_barangay, voter_cluster, firstname_middlename, lastname, encoder) VALUES ('$voter_barangay', '$voter_cluster', '$voter_firstname $voter_middlename', '$voter_lastname', '$encoder')";
		$result = $connection->query($sql);
		
		return $result;
	}
	
	public static function view_voters_by_cluster($voter_barangay, $voter_cluster, $sort) {
		include __DIR__ . "/../connection.php";
		
		$data = array();
		$sql = "SELECT * FROM voters WHERE voter_barangay = '$voter_barangay' AND voter_cluster = '$voter_cluster' ORDER BY $sort";
		$result = $connection->query($sql);
		
		$i = 0;
		if ($result->num_rows > 0) {
			while ($row=$result->fetch_object()) {
				$rows = new Voters();
				$rows->set_voter_id($row->voter_id);
				$rows->set_voter_firstname_middlename($row->firstname_middlename);
				$rows->set_voter_lastname($row->lastname);
				$rows->set_votes($row->votes);
				$data[$i] = $rows;
				$i++;
			}
		}
		return $data;
	}
	
	public static function view_voters_by_barangay($voter_barangay, $sort) {
		include __DIR__ . "/../connection.php";
		
		$data = array();
		$sql = "SELECT * FROM voters WHERE voter_barangay = '$voter_barangay' ORDER BY $sort";
		$result = $connection->query($sql);
		
		$i = 0;
		if ($result->num_rows > 0) {
			while ($row=$result->fetch_object()) {
				$rows = new Voters();
				$rows->set_voter_id($row->voter_id);
				$rows->set_voter_cluster($row->voter_cluster);
				$rows->set_voter_firstname_middlename($row->firstname_middlename);
				$rows->set_voter_lastname($row->lastname);
				$rows->set_votes($row->votes);
				$data[$i] = $rows;
				$i++;
			}
		}
		return $data;
	}
	
	public static function view_voters_by_id($voter_id) {
		include __DIR__ . "/../connection.php";
		
		$sql = "SELECT * FROM voters WHERE voter_id = '$voter_id'";
		$result = $connection->query($sql);
		
		$rows = new Voters();
		if ($result->num_rows == 1) {
			while ($row=$result->fetch_object()) {
				$rows->set_voter_id($row->voter_id);
				$rows->set_voter_cluster($row->voter_cluster);
				$rows->set_voter_firstname_middlename($row->firstname_middlename);
				$rows->set_voter_lastname($row->lastname);
			}
		}
		return $rows;
	}
	
	public static function view_voters_by_keyword($search_keyword) {
		include __DIR__ . "/../connection.php";
		
		$data = array();
		$sql = "SELECT * FROM voters WHERE CONCAT(firstname_middlename, ' ', lastname) LIKE '%$search_keyword%' OR CONCAT(lastname, ' ', firstname_middlename) LIKE '%$search_keyword%' ORDER BY voter_barangay, lastname";
		$result = $connection->query($sql);
		
		$i = 0;
		if ($result->num_rows > 0) {
			while ($row=$result->fetch_object()) {
				$rows = new Voters();
				$rows->set_voter_id($row->voter_id);
				$rows->set_voter_cluster($row->voter_cluster);
				$rows->set_voter_barangay($row->voter_barangay);
				$rows->set_voter_firstname_middlename($row->firstname_middlename);
				$rows->set_voter_lastname($row->lastname);
				$rows->set_votes($row->votes);
				$data[$i] = $rows;
				$i++;
			}
		}
		return $data;
	}
	
	public static function count_voters($table, $id) {
		include __DIR__ . "/../connection.php";
		
		$number = 0;
		$sql = "SELECT COUNT(*) AS number FROM voters WHERE $table = '$id'";
		$result = $connection->query($sql);
		
		if ($result->num_rows == 1) {
			while ($row = $result->fetch_object()) {
				$number = $row->number;
			}
		}
		return $number;
	}
}


?>