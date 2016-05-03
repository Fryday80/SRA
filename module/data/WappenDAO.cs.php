<?php
class WapenDAO extends DataAccessObject {
	protected $dataType = "UserVO";
	protected $tableName = "wappenrolle";
	private $dummy;
	
	function __construct() {
		//create dummy data
		$this->dummy = array(new UserVO(1, 1, "Test1", "Tester", "test", "Hofnarr", "pennery", "test",1,1,0, "test",2,0,0),
							 new UserVO(1, 1, "Test2", "Tester2", "test2", "Hofnarr2", "pennery2", "tes2t",1,1,0, "test2",2,0,0));
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

	public function getRolle(){
		if (DATA_MOCKING) {
			return $this->dummy;
		} else {
			$data = $this->wholeTable();
			if (count($data) < 1) {
				return false;
			}
			return $data[0];
	/*
	 * return UserVO
	 */
	function getByName($name) {
		if (DATA_MOCKING) {
			return $this->dummy[0];
		} else {
			$data = $this->where("login", $name);
			if (count($data) < 1) {
				return false;
			}
			return $data[0];
		}
		
	}
}

class WappenVO extends ValueObject {  ///warum hat der n problem mim namen??
	public $name;
	public $role;
	public $pw;

	function __construct($id, $name, $role, $pw) {
		parent::setID($id);
		$this->name = $name;
		$this->role = $role;
		$this->pw = $pw;
	}
}
