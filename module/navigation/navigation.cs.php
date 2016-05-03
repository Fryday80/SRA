<?php
if (basename($_SERVER['SCRIPT_FILENAME']) === 'navigation.cs.php'){exit('This page may not be called directly !'); }


class NavigationDAO extends DataAccessObject{
	protected $dataType = "NavVO";
	protected $tableName = "navigation";
	private $dummy;

	function __construct() {
		//create dummy data
		$this->dummy = array(new UserVO(1, 1, "Profil", "?site=profil"),
			new UserVO(2, 2, "dummy","?site=FuehrtZuNix"));
		$this->getNavigation();
	}

	private function getNavigation(){
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

class MembersNavigationDAO extends DataAccessObject{
	protected $dataType = "MemNavVO";
	protected $tableName = "membernav";
	private $dummy;

	function __construct() {
		//create dummy data
		$this->dummy = array(new UserVO(1, 1, "Profil", "?site=profil", 1),
			new UserVO(2, 2, "dummy","?site=FuehrtZuNix", 2));
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

	function __construct($id, $name, $role, $pw) {
		parent::setID($id);
		$this->name = $name;
		$this->role = $role;
		$this->pw = $pw;
	}
}
//@ hier wäre der Aufbau   		$position => 	$link = xx
//												$name = yy       // nötig
class MemNavVO extends ValueObject {
	public $role;
	public $position;
	public $name;
	public $link;

	function __construct($id, $name, $role, $pw) {
		parent::setID($id);
		$this->name = $name;
		$this->role = $role;
		$this->pw = $pw;
	}
}
//@ hier wäre der Aufbau $role =>$position => 	$link = xx
//												$name = yy       // nötig





class nav_show {

	function show_main () {
		ksort($nav_object->view);
		foreach ($nav_object->view as $k => $v){
			ksort($nav_object->view["$k"]);
			$lin = $nav_object->view["$k"]["link"];
			$nam = $nav_object->view["$k"]["name"];
			echo '<div class="link"><a href="'.$lin.'">'.$nam.'</a></div>';
		}
	}
		
	public function show_mem ($nav_object, $permission_power) 
	{
		$i=0;
		//@ hier wäre der Aufbau $role =>$position => 	$link = xx
		//												$name = yy       // nötig
	
		ksort($nav_object->view_m); //@nach role sortieren 0->6
		for ($i=0; $i <= $permission_power; $i++){
			ksort($nav_object->view_m["$i"]);
			foreach ($nav_object->view_m[$i] as $k => $v)
			{
				$lin = $nav_object->view_m["$i"]["$k"]["link"];
				$nam = $nav_object->view_m["$i"]["$k"]["name"];
				echo '<div class="link"><a href="'.$lin.'">'.$nam.'</a></div>';
			}
		}
	}

}