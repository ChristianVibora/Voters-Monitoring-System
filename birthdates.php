<?php
class Birthdates {
	private $firstname_middlename;
	private $lastname;
	private $date_of_birth;
	
	function __construct(){

	}
	
	public function set_firstname_middlename($firstname_middlename) {
		$this->firstname_middlename = $firstname_middlename;
	}
	
	public function set_lastname($lastname) {
		$this->lastname = $lastname;
	}
	
	public function set_date_of_birth($date_of_birth) {
		$this->date_of_birth = $date_of_birth;
	}
	
	public function get_firstname_middlename() {
		return $this->firstname_middlename;
	}
	
	public function get_lastname() {
		return $this->lastname;
	}
	
	public function get_date_of_birth() {
		return $this->date_of_birth;
	}
	
	public static function view_all_birthdates() {
			include __DIR__ . "/../connection.php";
		$data = array();
		$sql="SELECT * FROM birthdates ORDER BY MONTH(date_of_birth), DAY(date_of_birth), YEAR(date_of_birth), lastname";
		$result = $connection->query($sql);
		
		$i=0;
		if ($result->num_rows > 0) {
			while ($row=$result->fetch_object()) {
				$rows = new Birthdates();
				$rows->set_firstname_middlename($row->firstname_middlename);
				$rows->set_lastname($row->lastname);
				$rows->set_date_of_birth($row->date_of_birth);
				$data[$i] = $rows;
				$i++;
			}
		}
		return $data;
	}
	
	public static function view_birthdates_by_keywords($date_from, $date_to) {
		include __DIR__ . "/../connection.php";
		$data = array();
		$sql="SELECT * FROM birthdates WHERE (MONTH(date_of_birth) >= MONTH('$date_from') AND DAY(date_of_birth) >= DAY('$date_from')) AND (MONTH(date_of_birth) <= MONTH('$date_to') AND DAY(date_of_birth) <= DAY('$date_to')) ORDER BY MONTH(date_of_birth), DAY(date_of_birth), YEAR(date_of_birth), lastname";
		$result = $connection->query($sql);
		
		$i=0;
		if ($result->num_rows > 0) {
			while ($row=$result->fetch_object()) {
				$rows = new Birthdates();
				$rows->set_firstname_middlename($row->firstname_middlename);
				$rows->set_lastname($row->lastname);
				$rows->set_date_of_birth($row->date_of_birth);
				$data[$i] = $rows;
				$i++;
			}
		}
		return $data;
	}
}


?>