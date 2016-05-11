<?php
class MembersDAO extends DataAccessObject
{
	protected $dataType = "MemberDataVO";
	protected $tableName = "memberdata";
	private $dummy;

	function __construct()
	{
		//create dummy data
		$this->dummy = array(	new $this->dataType(1, 1, "Mark", "One", "Tony Stark Blv.", "1a", 0, 0, 0),
								new $this->dataType(2, 2, "Marc", "Two", "Drurchfallweg", 5, 0, 0, 0));
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
	function get_all_members (){
		if (DATA_MOCKING) {
			return $this->dummy[0];
		} else {
			$data = $this->wholeTable("ORDER BY `" .$this->tableName. "`.`usr_id` ASC ");
			if (count($data) < 1) {
				return false;
			}
			return $data;
		}
	}
}

class MemberDataVO extends ValueObject {
	public $usr_id, $vorname, $name, $strasse, $nr, $plz, $ort, $land;

	function __construct($dao, $id, $usr_id=NULL, $vorname=NULL, $name=NULL, $strasse=NULL, $nr=NULL, $plz=NULL, $ort=NULL, $land=NULL) {
		parent::setID($id);
		$this->name = $name;
		$this->usr_id = $usr_id;
		$this->vorname = $vorname;
		$this->strasse = $strasse;
		$this->nr = $nr;
		$this->plz = $plz;
		$this->ort = $ort;
		$this->land = $land;
	}
}
