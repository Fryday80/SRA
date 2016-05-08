<?php
class RolesDAO extends DataAccessObject {
	protected $dataType = "RolesVO";
	protected $tableName = "roles";
	private $dummy;
	
	function __construct() {
		//create dummy data
		$this->dummy = array(new $this->dataType(1, 1, "Member", "Hans", "Peter"),
							 new $this->dataType(2, 2, "Superuser", "Ludwig", NULL));
		if (!DATA_MOCKING) {$this->getRoles();}
	}
	/*
	 * return UserVO
	 */
	function getRoles(){
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
	
}

class RolesVO extends ValueObject {
	public $role_number, $role_description;

	function __construct($dao, $id, $role_number = NULL, $role_description = NULL) {
		parent::setID($id);
		$this->role_number = $role_number;
		$this->role_description = $role_description;
	}
}
