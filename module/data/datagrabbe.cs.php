<?php
class DataGrabber {
// 	private $dummyData;
	protected $dataType, $mysqlQuery, $db_erg;

	function __construct($dataType) {
// 		$this->mysqlQuery = $mysqlQuery;
// 		$this->dummyData = $dummyData;
		$this->dataType = $dataType;
		$this->db_erg = array();
	}

	function loadFromMYSQL($mysqlQuery, $dataType, $db_link) {
		$this->db_erg = mysqli_query($db_link, $mysqlQuery);
		print_r ($this->db_erg); echo '____<br>';
		$result = array(); 
		while ($daten = mysqli_fetch_array($this->db_erg, MYSQLI_ASSOC)){
			$dataClass = new $dataType();
			$result = $dataClass;
			foreach ($daten as $key => $v){ 
				$dataClass->$key = $v;
			}
		}
		return $result; 
	}
	function prepareQuery($query, $nameValue) {
		foreach ($nameValue as $key => $value) {
			strtr($query, array('{{'.$key.'}}' => $value) );
		}
	}
}
?>