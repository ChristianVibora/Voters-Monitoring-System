<?php
class Barangays {
	private $barangay_id;
	private $barangay_name;
	
	function __construct(){

	}
	
	public function set_barangay_id($barangay_id) {
		$this->barangay_id = $barangay_id;
	}
	
	public function set_barangay_name($barangay_name) {
		$this->barangay_name = $barangay_name;
	}
	
	public function get_barangay_id() {
		return $this->barangay_id;
	}
	
	public function get_barangay_name() {
		return $this->barangay_name;
	}
	
	public static function view_all_barangays() {
		include __DIR__ . "/../connection.php";
		$data = array();
		$sql="SELECT * FROM barangays";
		$result = $connection->query($sql);
		
		$i = 0;
		if ($result->num_rows > 0) {
			while ($row=$result->fetch_object()) {
				$rows = new Barangays();
				$rows->set_barangay_id($row->barangay_id);
				$rows->set_barangay_name($row->barangay_name);
				$data[$i] = $rows;
				$i++;
			}
		}
		return $data;
	}
	
	public static function view_barangay_name_by_id($barangay_id) {
		include __DIR__ . "/../connection.php";
		$data = "";
		$sql="SELECT * FROM barangays WHERE barangay_id = '$barangay_id'";
		$result = $connection->query($sql);
		
		if ($result->num_rows == 1) {
			while ($row=$result->fetch_object()) {
				$data = $row->barangay_name;
			}
		}
		return $data;
	}
}


?>