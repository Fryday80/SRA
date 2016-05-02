<?php
class UserDAO extends DataGrabber {
	protected $dataType = "UserVO";
	protected $tableName = "login";
	private $dummy;
	
	function __construct() {
		//create dummy data
		$this->dummy = array(new UserVO(1, "peter", 2, "202cb962ac59075b964b07152d234b70"),
							 new UserVO(2, "sepp", 2, "202cb962ac59075b964b07152d234b70"));
	}
	//getByName()
	function getById($id){
		if (DATA_MOCKING) {
			return $this->dummy[0];
		} else {
			$data = $this->where("id", $id);
			if (count($data) < 1) {
				return false;
			}
			return $data[0];
		}
	}
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

class UserVO {
	public $id;
	public $name;
	public $role;
	public $pw;

	function __construct($id = null, $name = null, $role = null, $pw = null) {
		$this->id = $id;
		$this->name = $name;
		$this->role = $role;
		$this->pw = $pw;
	}
}
