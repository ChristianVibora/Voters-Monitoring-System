<?php
class Users {
	private $username;
	private $password;
	private $firstname;
	private $middlename;
	private $lastname;
	private $user_level;
	
	function __construct(){

	}
	
	public function set_username($username) {
		$this->username = $username;
	}
	
	public function set_password($password) {
		$this->password = $password;
	}
	
	public function set_firstname($firstname) {
		$this->firstname = $firstname;
	}
	
	public function set_middlename($middlename) {
		$this->middlename = $middlename;
	}
	
	public function set_lastname($lastname) {
		$this->lastname = $lastname;
	}
	
	public function set_user_level($user_level) {
		$this->user_level = $user_level;
	}
	
	public function get_username() {
		return $this->username;
	}
	
	public function get_password() {
		return $this->password;
	}
	
	public function get_firstname() {
		return $this->firstname;
	}
	
	public function get_middlename() {
		return $this->middlename;
	}
	
	public function get_lastname() {
		return $this->lastname;
	}	
	
	public function get_user_level() {
		return $this->user_level;
	}
	
	public static function check_user_login($username, $password) {
		include __DIR__ . "/../connection.php";
		$data = array();
		$sql="SELECT * FROM users WHERE username = '$username' AND password = '$password'";
		$result = $connection->query($sql);
		
		if ($result->num_rows == 1) {
			while ($row=$result->fetch_object()) {
				$rows = new Users();
				$rows->set_username($row->username);
				$rows->set_firstname($row->firstname);
				$rows->set_lastname($row->lastname);
				$rows->set_user_level($row->user_level);
				$data[0] = $rows;
			}
		}
		return $data;
	}
	
	public static function add_user($username, $password, $firstname, $middlename, $lastname, $user_level, $encoder) {
		include __DIR__ . "/../connection.php";
				
		$sql="INSERT INTO users (username, password, firstname, middlename, lastname, user_level, encoder) VALUES ('$username', '$password', '$firstname', '$middlename', '$lastname', '$user_level', '$encoder')";
		$result = $connection->query($sql);
	
		return $result;
	}
	
}


?>