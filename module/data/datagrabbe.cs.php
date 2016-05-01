<?php
class DataGrabber {
	protected $dataType;
	protected $mysqlQuery;
	protected static $dbLink;

	function __construct() {
	}
	function getByValue($tableName, $valueName, $value) {
		return getBySqlQuery( "SELECT * FROM `".$tableName."` WHERE `".$valueName."` = '".$value."'");
	}
	function getBySqlQuery($mysqlQuery) {
		$db_erg = mysqli_query($db_link, $mysqlQuery);
		$i = 0;
		$result = array(); 
		while ($daten = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)){
			$dataClass = new $this.dataType();
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