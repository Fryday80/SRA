<?php
class WappenDAO extends DataAccessObject {
	protected $dataType = "WappenVO";
	protected $tableName = "wappenrolle";
	private $dummy;
	
	function __construct() {
		//create dummy data
		$this->dummy = array(new $this->dataType(1, 1, "Test1", "Tester", "test", "Hofnarr", "pennery", "test",1,1,0, "test",2,0,0),
							 new $this->dataType(1, 1, "Test2", "Tester2", "test2", "Hofnarr2", "pennery2", "tes2t",1,1,0, "test2",2,0,0));
	}
	/*
	 * return UserVO
	 */
	function getById($id){
		if (DATA_MOCKING) {
			return $this->dummy[0];
		} else {
			$data = $this->where("usr_id", $id);
			if (count($data) < 1) {
				return false;
			}
			return $data[0];
		}

	}

	public function getRolle()
	{
		if (DATA_MOCKING) {
			return $this->dummy;
		} else {
			$data = $this->wholeTable();
			if (count($data) < 1) {
				return false;
			}
			return $data;
		}
	}
	/*
	 * return UserVO
	 */
	function getByName($name) {
		if (DATA_MOCKING) {
			return $this->dummy[0];
		} else {
			$data = $this->where("wappenrolle", $name);
			if (count($data) < 1) {
				return false;
			}
			return $data[0];
		}
		
	}
}

class WappenVO extends ValueObject { 
	public $usr_id, $vorname, $name, $familienname, $titel, $titel2, $piccode;
public $beziehung, $kinder, $hirachie, $trossfamilie, $soldat;

	function __construct($dao, $id, $usr_id = NULL, $vorname = NULL, $name=NULL, $familienname = NULL,
						 $titel = NULL, $titel2 = NULL, $piccode = NULL, $beziehung = NULL,
						 $kinder = NULL, $hirachie = NULL, $trossfamilie = NULL, $soldat = NULL) {
		parent::setID($id);
		$this->usr_id = $usr_id;
		$this->vorname = $vorname;
		$this->name = $name;
		$this->familienname = $familienname;
		$this->titel = $titel;
		$this->titel2 = $titel2;
		$this->piccde = $piccode;
		$this->beziehung = $beziehung;
		$this->kinder = $kinder;
		$this->hirachie = $hirachie;
		$this->trossfamilie = $trossfamilie;
		$this->soldat = $soldat;
	}
}
		?>
