<?php
class UserDataGrabber extends DataGrabber {
protected $mysqlQuery;

	function __construct($db_link) {
		$this->dataType = 'UserData';
		$this->db_link = $db_link;
		parent::__construct($this->dataType);
	}
	//getByName()
	public function getByName($name){
		$this->mysqlQuery = "SELECT * FROM `login` WHERE `login` = '$name'";
		$data = $this->loadFromMYSQL($this->mysqlQuery, $this->dataType, $this->db_link);
		if (count($data) < 1) {
			return false;
		}else {return $data;}
	}
}

class UserData {
	public $usr_id;
	public $login;
	public $role;
	public $pw;

	function __construct() {
		$this->usr_id = '';
		$this->login = '';
		$this->role = '';
		$this->pw = '';
	}
}
