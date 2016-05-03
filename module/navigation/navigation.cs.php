<?php
if (basename($_SERVER['SCRIPT_FILENAME']) === 'navigation.cs.php'){exit('This page may not be called directly !'); }


class NavigationDAO extends DataAccessObject{
	protected $dataType = "NavVO";
	protected $tableName = "navigation";
	private $dummy;

	function __construct() {
		//create dummy data
		$this->dummy = array(new NavVO($this, 1, 1, "Profil", "?site=profil"),
							 new NavVO($this, 2, 2, "dummy","?site=FuehrtZuNix"));
	}

	function getNavigation(){
		if (DATA_MOCKING) {
			return $this->dummy;}
		else {
			$data = $this->wholeTable();
			if (count($data) < 1) {
				return false;
			}
			return $data;
		}
	}
	protected function re_arrange($array){
		$i=0;
		$max = count ($array);
		for ($i=0; $i < $max; $i++) {
			$result[$array[$i]['position']] = array( 	"name" => $array[$i]['position']['name'],
														"link" => $array[$i]['position']['link']);
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
		$this->dummy = array(new MemNavVO($this, 1, 1, "Profil", "?site=profil", 1),
			new MemNavVO($this, 2, 2, "dummy","?site=FuehrtZuNix", 2));
	}

	public function getNavigation(){
		if (DATA_MOCKING) {
			return $this->dummy[0];}
		else {
			$data = $this->wholeTable();
			if (count($data) < 1) {
				return false;
			}

			return $data;
		}
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
	public $NavDA_Main, $navDAO_Mem;

	function __construct($mainNavObject, $memberNavObject)
	{
		$this->NavDAO_Main = $mainNavObject;
		$this->navDAO_Mem = $memberNavObject;
	}

	function show_main () {
		ksort($mainNavObject);
		foreach ($mainNavObject as $k => $v){
			ksort($mainNavObject["$k"]);
			$lin = $mainNavObject["$k"]["link"];
			$nam = $mainNavObject["$k"]["name"];
			echo '<div class="link"><a href="'.$lin.'">'.$nam.'</a></div>';
		}
	}
		
	public function show_mem ($permission_power)
	{
		$i=0;
		//@ hier wäre der Aufbau $role =>$position => 	$link = xx
		//												$name = yy       // nötig
	
		ksort($memberNavObject); //@nach role sortieren 0->6
		for ($i=0; $i <= $permission_power; $i++){
			ksort($memberNavObject["$i"]);
			foreach ($memberNavObject[$i] as $k => $v)
			{
				$lin = $memberNavObject["$i"]["$k"]["link"];
				$nam = $memberNavObject["$i"]["$k"]["name"];
				echo '<div class="link"><a href="'.$lin.'">'.$nam.'</a></div>';
			}
		}
	}

}