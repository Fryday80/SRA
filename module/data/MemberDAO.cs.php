<?php
class MemberDAO extends DataGrabber {
	protected $dataType = "MemberData";
	private $dummy;

	function __construct() {
		parent::__construct();
		$this->dummy = [new MemberData(1, "Hans Peter")];
	}
	//getByName()
	function getById($id){
		return $this->dummy[0];
	}
}

class MemberVO {
	public $id;
	public $name;

	function __construct($id = null, $name = null) {
		$this->id = $id;
		$this->name = $name;
	}
}
