<?php
class DataGrabber {
// 	private $dummyData;
	protected $dataType, $mysqlQuery;

	function __construct($dataType, $mysqlQuery) {
		$this->mysqlQuery = $mysqlQuery;
// 		$this->dummyData = $dummyData;
		$this->dataType = $dataType;
		$this->db_erg = array();
	}

	function loadFromMYSQL($mysqlQuery, $dataTypek) {
		$db->db_erg = mysqli_query($db->db_link, $mysqlQuery);
		echo $db->db_erg.'____<br>';
		$i = 0;
		$result = array(); 
		while ($daten = mysqli_fetch_array($db->db_erg, MYSQLI_ASSOC)){
			$dataClass = new $dataType();
			$result[$i] = $dataClass;
			foreach ($daten as $key => $v){ 
				$dataClass[$key] = $v;
			}
			$i++;
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