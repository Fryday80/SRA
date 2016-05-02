<?php

class DataGrabber {
	protected $dataType;
	protected $tableName;
	protected static $dbLink;

	static function init() {
		if (DATA_MOCKING) return;
		self::$dbLink = mysqli_connect (
			MYSQL_HOST,
			MYSQL_BENUTZER,
			MYSQL_KENNWORT,
			MYSQL_DATENBANK, MYSQL_PORT
		);
		mysqli_set_charset(self::$dbLink, 'utf8');

		if ( !self::$dbLink )
		{
			die('keine Verbindung zur Zeit m&ouml;glich - sp&auml;ter probieren ');
		}
	}
	protected function where($valueName, $value) {
		return $this->getBySqlQuery( "SELECT * FROM `".$this->tableName."` WHERE `".$valueName."` = '".$value."'");
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
			$dataClass = new $this->dataType();
			$result[$i] = $dataClass;
			foreach ($daten as $key => $v){ 
				$dataClass[$key] = $v;
			}
			$i++;
		}
		return $result; 
	}
}