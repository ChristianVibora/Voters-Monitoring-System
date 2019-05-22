<?php
class Clusters {
	private $cluster_id;
	private $cluster_barangay;
	private $precint_number;
	
	function __construct(){

	}
	
	public function set_cluster_id($cluster_id) {
		$this->cluster_id = $cluster_id;
	}
	
	public function set_cluster_barangay($cluster_barangay) {
		$this->cluster_barangay = $cluster_barangay;
	}
	
	public function set_precint_number($precint_number) {
		$this->precint_number = $precint_number;
	}
	
	public function get_cluster_id() {
		return $this->cluster_id;
	}
	
	public function get_cluster_barangay() {
		return $this->cluster_barangay;
	}
	
	public function get_precint_number() {
		return $this->precint_number;
	}
	
	public static function view_all_clusters() {
		include __DIR__ . "/../connection.php";
		$data = array();
		$sql="SELECT * FROM clusters ORDER BY precint_number";
		$result = $connection->query($sql);
		
		$i = 0;
		if ($result->num_rows > 0) {
			while ($row=$result->fetch_object()) {
				$rows = new Clusters();
				$rows->set_cluster_id($row->cluster_id);
				$rows->set_precint_number($row->precint_number);
				$rows->set_cluster_barangay($row->cluster_barangay);
				$data[$i] = $rows;
				$i++;
			}
		}
		return $data;
	}
	
	public static function view_clusters_by_barangay($barangay_id) {
		include __DIR__ . "/../connection.php";
		
		$data = array();
		$sql="SELECT * FROM clusters WHERE cluster_barangay = '$barangay_id' ORDER BY precint_number";
		$result = $connection->query($sql);
		
		$i = 0;
		if ($result->num_rows > 0) {
			while ($row=$result->fetch_object()) {
				$rows = new Clusters();
				$rows->set_cluster_id($row->cluster_id);
				$rows->set_precint_number($row->precint_number);
				$rows->set_cluster_barangay($row->cluster_barangay);
				$data[$i] = $rows;
				$i++;
			}
		}
		return $data;
	}
	
	public static function view_precint_number_by_id($cluster_id) {
		include __DIR__ . "/../connection.php";
		$data = "";
		$sql="SELECT * FROM clusters WHERE cluster_id = '$cluster_id'";
		$result = $connection->query($sql);
		
		if ($result->num_rows == 1) {
			while ($row=$result->fetch_object()) {
				$data = $row->precint_number;
			}
		}
		return $data;
	}
	
}


?>