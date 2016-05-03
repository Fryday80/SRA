<?php
class UserDAO extends DataAccessObject {
	protected $dataType = "UserVO";
	protected $tableName = "login";
	private $dummy;
	
	function __construct() {
		//create dummy data
		$this->dummy = array(new UserVO(1, 1, "peter", 4, "202cb962ac59075b964b07152d234b70"),
							 new UserVO(2, 2, "sepp", 2, "202cb962ac59075b964b07152d234b70"));
	}
	/*
	 * return UserVO
	 */
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

class UserVO extends ValueObject {
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
