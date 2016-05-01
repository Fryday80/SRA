<?php
class UserDataGrabber extends DataGrabber {
	protected $dataType = "UserData";
	private $dummy;
	
	function __construct() {
		parent::__construct();
		//create dummy data
		$this->dummy = array(new UserData(1, "Hans Peter", 1),
							 new UserData(1, "George PenisWurst", 2));
	}
	//getByName()
	function getById($id){
		if (DATA_MOCKING) {
			return $this->dummy[0];
		} else {
			//$data = $this.getByValue("login", "id", $id);
			$data = $this.getBySqlQuery("SELECT * FROM `login` WHERE `id` = '".$id."'");
			if (count($data) < 1) {
				return false;
			}
		}
	}
}

class UserData {
	public $id;
	public $name;
	public $role;

	function __construct($id = null, $name = null, $role = null) {
		$this->id = $id;
		$this->name = $name;
		$this->role = $role;
	}
}
