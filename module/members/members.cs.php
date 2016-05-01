<?php


class memberBackend{
	protected $db_link, $db_erg;
	public $members;
	
	public function __construct($db_link){
		$this->db_link = $db_link;
		$this->members = array();
		$this->db_erg = array();
		$this->members = $this->getAll();
// 		print_r ($this->members);
// 		echo 'hallooooooo';
	}
	
	private function getAll (){
		$tables = array ("members", "login", "memberdata");
		foreach ($tables as $key => $values)
		{
			$sql = "SELECT * FROM `$values`";
			$this->db_erg = mysqli_query($this->db_link, $sql);
			$i = 0;
			while($daten=mysqli_fetch_array($this->db_erg, MYSQLI_ASSOC)){
				$run = $daten['usr_id'];
				$result[$run][$values][$i] = $daten;
				$i++;
			}
		}
		return $result;
	}
	public function getAllByLogin ($usr_id){
		$tables = array ("members", "login");
		foreach ($tables as $key => $values)
		{
			$sql = "SELECT * FROM `$values` WHERE `usr_id` = `$usr_id`";
			$this->db_erg = mysqli_query($this->db_link, $sql);
			$i = 0;
			while($daten=mysqli_fetch_array($this->db_erg, MYSQLI_ASSOC)){
				$run = $daten['usr_id'];
				$result[$run][$values] = $daten;
				$i++;
			}
		}
		return $result;
	}
}