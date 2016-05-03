<?php
class MembersDAO extends DataAccessObject
{
	protected $dataType = "MemberDataVO";
	protected $tableName = "memberdata";
	private $dummy;

	function __construct()
	{
		//create dummy data
		$this->dummy = array(new UserVO(1, "Mark", "One", "Tony Stark Blv.", "1a", 0, 0, 0),
			new UserVO(2, "Marc", "Two", "Drurchfallweg", 5, 0, 0, 0));
	}

	/*
	 * return UserVO
	 */
	function getById($id)
	{
		if (DATA_MOCKING) {
			return $this->dummy[0];
		} else {
			$data = $this->where("usr_id", $id);
			if (count($data) < 1) {
				return false;
			}
			return $data[0];
		}

	}
}

class MemberDataVO extends ValueObject {
	public $name;
	public $role;
	public $pw;

	function __construct($id, $name, $role, $pw) {
		parent::setID($id);
		$this->name = $name;
		$this->role = $role;
		$this->pw = $pw;
	}
}
