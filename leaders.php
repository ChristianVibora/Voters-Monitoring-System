<?php
class Leaders {
	private $leader_id;
	private $leader_barangay;
	private $leader_firstname;
	private $leader_middlename;
	private $leader_lastname;
	
	function __construct(){

	}
	
	public function set_leader_id($leader_id) {
		$this->leader_id = $leader_id;
	}
	
	public function set_leader_barangay($leader_barangay) {
		$this->leader_barangay = $leader_barangay;
	}
	
	public function set_leader_firstname($leader_firstname) {
		$this->leader_firstname = $leader_firstname;
	}
	
	public function set_leader_middlename($leader_middlename) {
		$this->leader_middlename = $leader_middlename;
	}
	
	public function set_leader_lastname($leader_lastname) {
		$this->leader_lastname = $leader_lastname;
	}
	
	public function get_leader_id() {
		return $this->leader_id;
	}
	
	public function get_leader_barangay() {
		return $this->leader_barangay;
	}
	
	public function get_leader_firstname() {
		return $this->leader_firstname;
	}
	
	public function get_leader_middlename() {
		return $this->leader_middlename;
	}
	
	public function get_leader_lastname() {
		return $this->leader_lastname;
	}
	
	public static function view_leaders_by_barangay($barangay_id) {
		include __DIR__ . "/../connection.php";
		$data = array();
		$sql="SELECT * FROM leaders WHERE leader_barangay = '$barangay_id' ORDER BY lastname";
		$result = $connection->query($sql);
		
		$i=0;
		if ($result->num_rows > 0) {
			while ($row=$result->fetch_object()) {
				$rows = new Leaders();
				$rows->set_leader_id($row->leader_id);
				$rows->set_leader_firstname($row->firstname);
				$rows->set_leader_middlename($row->middlename);
				$rows->set_leader_lastname($row->lastname);
				$data[$i] = $rows;
				$i++;
			}
		}
		return $data;
	}
	
	public static function view_leader_by_id($leader_id) {
		include __DIR__ . "/../connection.php";
		$data = array();
		$sql="SELECT * FROM leaders WHERE leader_id = '$leader_id'";
		$result = $connection->query($sql);
		
		$i=0;
		if ($result->num_rows == 1) {
			while ($row=$result->fetch_object()) {
				$rows = new Leaders();
				$rows->set_leader_id($row->leader_id);
				$rows->set_leader_firstname($row->firstname);
				$rows->set_leader_middlename($row->middlename);
				$rows->set_leader_lastname($row->lastname);
				$data = $rows;
			}
		}
		return $data;
	}
	
	public static function add_leader($leader_barangay, $firstname, $middlename, $lastname, $encoder) {
		include __DIR__ . "/../connection.php";
				
		$sql="INSERT INTO leaders (leader_barangay, firstname, middlename, lastname, encoder) VALUES ('$leader_barangay', '$firstname', '$middlename', '$lastname', '$encoder')";
		$result = $connection->query($sql);
		
		return $result;
	}
}


?>