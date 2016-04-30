<?php
class UserDataGrabber extends DataGrabber {

	function __construct() {
		parent::__construct();
	}
	//getByName()
	static function getById($id){
		$data = $this->loadFromMYSQL($this->mysqlQuery, $this->dataType);
		if (count($data) < 1) {
			return false;
		}
	}
}

class UserData {
	public $id;
	public $name;
	public $role;

	function __construct($id, $name, $role) {

	}
}
