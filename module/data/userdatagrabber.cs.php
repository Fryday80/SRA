<?php
class UserDataGrabber extends DataGrabber {

	function __construct($mysqlQuery) {
		$this->dataType = 'UserData';
		$this->mysqlQuery = $mysqlQuery;
		parent::__construct($this->dataType, $mysqlQuery);
	}
	//getByName()
	public function getById($id){
		$this->mysqlQuery .= "'$id'";
		$data = $this->loadFromMYSQL($this->mysqlQuery, $this->dataType, $db->db_link);
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
