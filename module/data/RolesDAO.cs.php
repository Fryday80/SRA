<?php
class RolesDAO extends DataAccessObject {
	protected $dataType = "RolesVO";
	protected $tableName = "roles";
	private $dummy;
	
	function __construct() {
		//create dummy data
		$this->dummy = array(new UserVO(1, 1, "Member", "Hans", "Peter"),
							 new UserVO(2, 2, "Superuser", "Ludwig", NULL));
		if (!DATA_MOCKING) {$this->getRoles();}
	}
	/*
	 * return UserVO
	 */
	private function getRoles(){
		if (DATA_MOCKING) {
			return $this->dummy;
		} else {
			$data = $this->wholeTable();
			if (count($data) < 1) {
				return false;
			}
			return $data[0];
		}

	}
	
}

class RolesVO extends ValueObject {
	public $role_number;

	function __construct($role_number) {  //braucht es das? beim init. ist das doch alles noch nicht gesetzt
		parent::setID($id);
		$this->name = $name;
		$this->role = $role;
		$this->pw = $pw;
	}
}
