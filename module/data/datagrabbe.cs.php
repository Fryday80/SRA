<?php
class DataGrabber {
	private $dummyData;

	function __construct($query, $mysqlQuery) {
		$this->mysqlQuery = $mysqlQuery;
		$this->dummyData = $dummyData; // des mit den dummy daten is kacke besser ne function die daten zurück giebt
	}

	function loadFromMYSQL($query, $dataType) {
		$db_erg = mysqli_query($db_link, $this->mysqlQuery);
		$i = 0;
		$result = array(); //wat brauchste denn?  mach mal 2 files einmal den DataGrabber in eins und in des andere den UserDataGrabber und UserData
		while ($daten = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)){
			$dataClass = new $dataType();
			$result[$i] = $dataClass;	//ja aber hier überbe ich das leere objekt und lese dann erst die daten aus
			foreach ($daten as $key => $v){ //hier
				$dataClass[$key] = $v;
			}
			$i++;
		}
		return $result; // result ist hier doch leer
	}
	function prepareQuery($query, $nameValue) {
		foreach ($nameValue as $key => $value) {
			strtr($query, array('{{'.$key.'}}' => $value) );
		}
	}
}
?>