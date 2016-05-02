<?php
class RolesDAO extends DataAccessObject {
	protected $dataType = "RolesVO";
	protected $tableName = "roles";
	private $dummy;
	
	function __construct() {
		//create dummy data
		$this->dummy = array(new UserVO(1, 1, "Member", "Hans", "Peter"),
							 new UserVO(2, 2, "Superuser", "Ludwig", NULL));
	}
	/*
	 * return UserVO
	 */
	function getByRoleNr($number){
		if (DATA_MOCKING) {
			return $this->dummy[0];
		} else {
			$data = $this->where("role_nr", $number);
			if (count($data) < 1) {
				return false;
			}
			return $data[0];
		}

	}
	/*
	 * return UserVO
	 */
	function getByRoleName($name) {
		if (DATA_MOCKING) {
			return $this->dummy[0];
		} else {
			$data = $this->where("role_desc", $name);
			if (count($data) < 1) {
				return false;
			}
			return $data[0];
		}
		
	}
}

class RolesVO extends ValueObject {
	public $role_name;
	public $role_number;
	public $leader_1;
	public $leader_2;

	function __construct($id, $role_name, $role_number, $leader_1, $leader_2) {
		parent::setID($id);
		$this->name = $name;
		$this->role = $role;
		$this->pw = $pw;
	}
}
