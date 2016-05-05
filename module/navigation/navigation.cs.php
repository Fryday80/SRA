<?php
if (basename($_SERVER['SCRIPT_FILENAME']) === 'navigation.cs.php'){exit('This page may not be called directly !'); }


class NavigationDAO extends DataAccessObject{
	protected $dataType = "NavVO";
	protected $tableName = "navigation";
	private $dummy;

	function __construct() {
		//create dummy data
		$this->dummy = array(new $this->dataType($this, 1, 1, "Profil", "?site=profil"),
							 new $this->dataType($this, 2, 2, "dummy","?site=FuehrtZuNix"));
	}

	function getNavigation(){
		if (DATA_MOCKING) {
			return $this->dummy;}
		else {
			$data = $this->wholeTable();
			if (count($data) < 1) {
				return false;
			}
			$data = $this->re_arrange($data);
			return $data;
		}
	}
	protected function re_arrange($array){
		$i=0;
		$result = array();
		$max = count ($array);
		for ($i=0; $i < $max; $i++) {
			$result = array ($array[$i]['position'] = array( 	"name" => $array[$i]['position']['name'],
															"link" => $array[$i]['position']['link']));
		}
		return $result;
	}
}

class MembersNavigationDAO extends DataAccessObject{
	protected $dataType = "MemNavVO";
	protected $tableName = "membernav";
	private $dummy;

	function __construct() {
		//create dummy data
		$this->dummy = array(	new $this->dataType($this, 1, 1, "Profil", "?site=profil", 1),
								new $this->dataType($this, 2, 2, "dummy","?site=FuehrtZuNix", 2));
	}

	public function getNavigation(){
		if (DATA_MOCKING) {
			return $this->dummy[0];}
		else {
			$data = $this->wholeTable();
			if (count($data) < 1) {
				return false;
			}
			$data = $this->re_arrange($data);
			return $data;
		}
	}
	protected function re_arrange($array){
		$i=0;
		$result = array();
		$max = count ($array);
		for ($i=0; $i < $max; $i++) {
			$result = array ($array[$i]['position'] = array( 	"name" => $array[$i]['name'],
				"link" => $array[$i]['link']));
		}
		return $result;
	}
}
class NavVO extends ValueObject {
	public $position;
	public $name;
	public $link;

	function __construct($dao, $id = null, $position = null, $name = null, $link = null) {
		parent::setID($dao, $id);
		$this->name = $name;
		$this->link = $link;
		$this->position = $position;
	}
}
//@ hier wäre der Aufbau   		$position => 	$link = xx
//												$name = yy       // nötig
class MemNavVO extends ValueObject {
	public $role;
	public $position;
	public $name;
	public $link;

	function __construct($dao, $id = null, $position= null, $name = null, $link = NULL, $role = null) {
		parent::setID($dao, $id);
		$this->name = $name;
		$this->role = $role;
		$this->position = $position;
		$this->link = $link;
	}
}
//@ hier wäre der Aufbau $role =>$position => 	$link = xx
//												$name = yy       // nötig





class nav_show {
	public $navDAO_Main, $navDAO_Mem;

	function __construct($mainNavObject, $memberNavObject)
	{
		$this->navDAO_Main = $mainNavObject;
		$this->navDAO_Mem = $memberNavObject;
	}

	function show_main () {
		//ksort($mainNavObject);
		foreach ($this->navDAO_Main as $k => $v){
		//	ksort($this->navDAO_Main["$k"]);
			$lin = $this->navDAO_Mai["$k"]["link"];
			$nam = $this->navDAO_Mai["$k"]["name"];
			echo '<div class="link"><a href="'.$lin.'">'.$nam.'</a></div>';
		}
	}
		
	public function show_mem ($permission_power)
	{
		$i=0;
		//@ hier wäre der Aufbau $role =>$position => 	$link = xx
		//												$name = yy       // nötig
	
		//ksort($this->navDAO_Mem); //@nach role sortieren 0->6
		for ($i=0; $i <= $permission_power; $i++){
			//ksort($this->navDAO_Mem["$i"]);
			foreach ($this->navDAO_Mem[$i] as $k => $v)
			{
				$lin = $this->navDAO_Mem["$i"]["$k"]["link"];
				$nam = $this->navDAO_Mem["$i"]["$k"]["name"];
				echo '<div class="link"><a href="'.$lin.'">'.$nam.'</a></div>';
			}
		}
	}

}