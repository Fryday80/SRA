<?php

class DataGrabber {
	protected $dataType;
	protected static $dbLink;

	static function initDB() {

	}
	function getByValue($tableName, $valueName, $value) {
		return getBySqlQuery( "SELECT * FROM `".$tableName."` WHERE `".$valueName."` = '".$value."'");
	}
	function save($data) {
		if (is_array($data)) {
			//
		} else if (get_class($data) == $this->dataType) {
			//@todo push to db
			foreach($data as $key => $value) {
				//build SQL query
			}
		}
	}
	private function getBySqlQuery($mysqlQuery) {
		$db_erg = mysqli_query($this::dbLink, $mysqlQuery);
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
}