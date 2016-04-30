<?php
class DataGrabber {
	private $dummyData;
	protected $dataType, $mysqlQuery;

	function __construct($dataType, $mysqlQuery) {
		$this->mysqlQuery = $mysqlQuery;
		$this->dummyData = $dummyData;
		$this->dataType = $dataType;
	}

	function loadFromMYSQL($mysqlQuery, $dataType) {
		$db_erg = mysqli_query($db_link, $this->mysqlQuery);
		$i = 0;
		$result = array(); 
		while ($daten = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)){
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