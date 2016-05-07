<?php
class UserDAO extends DataAccessObject {
	protected $dataType = "UserVO";
	protected $tableName = "login";
	private $dummy;
	
	function __construct() {
		//create dummy data
		$this->dummy = array(new $this->dataType(1, 1, 1, "peter", "202cb962ac59075b964b07152d234b70", 3, NULL, NULL, NULL),
							 new $this->dataType(2, 2,2,  "sepp", "202cb962ac59075b964b07152d234b70", 1, NULL, NULL, NULL));
	}
	/*
	 * return UserVO
	 */
	function getById($id){
		if (DATA_MOCKING) {
			bugfix('was tu ich hier');
			return $this->dummy[0];
		} else {
			bugfix('hier bin ich richtig');
			$data = $this->where("id", $id);
			if (count($data) < 1) {
				return false;
			}
			print_r($data);
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
			return $data;
		}
	}
	protected function backend_fetch(){
		if (DATA_MOCKING) {
			return $this->dummy[0];
		} else {
			$data = $this->wholeTable;
			if (count($data) < 1) {
				return false;
			}
			return $data;
		}
	}
}

class UserVO extends ValueObject {
	public $usr_id, $login, $pw, $role, $last_change, $since, $last_login;

	function __construct($dao,  $id, $usr_id=NULL, $login=NULL, $pw=NULL, $role=NULL, $last_change=NULL,
						 $since=NULL, $last_login=NULL ) {
		parent::__construct($dao, $id);
		$this->usr_id = $usr_id;
		$this->login = $login;
		$this->pw = $pw;
		$this->role = $role;
		$this->last_change = $last_change;
		$this->since = $since;
		$this->last_login = $last_login;
	}
}
