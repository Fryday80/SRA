<?php
class UserDataGrabber extends DataGrabber {

	function __construct() {
		parent::__construct();
	}
	//getByName()
	static function getById(){
		$data = $this->loadFromMYSQL("SELECT * FROM `login` WHERE `login` = '".$name."'", "UserData");
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

//weil die zusammengehören ok