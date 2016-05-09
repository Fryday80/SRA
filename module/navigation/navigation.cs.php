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
			//print_r($data);
			bugfix (88);
			//$data2 = $this->re_arrange($data);
			return $data;
		}
	}
	/*
	protected function re_arrange($array){
		$i=0;
		$result = array();
		$max = count ($array);
		for ($i=0; $i < $max; $i++) {
			$result[$array[$i]['position']]['name'] = $array[$i]['name'];
			$result[$array[$i]['position']]['link'] = $array[$i]['link'];
		}
		return $result;
	}
	*/
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
			//$data = $this->re_arrange($data);
			return $data;
		}
	}
	/*
	protected function re_arrange($array){
		$i=0;
		$result = array();
		$max = count ($array);
		for ($i=0; $i < $max; $i++) {
			$result[$array[$i]['role']][$array[$i]['position']]["name"] = $array[$i]['position']['name'];
			$result[$array[$i]['role']][$array[$i]['position']]["link"] = $array[$i]['position']['link'];
		}
		return $result;
	}
	*/
}

class NavVO extends ValueObject {
	public $position, $id;
	public $name;
	public $link;

	function __construct($dao, $id, $position = null, $name = null, $link = null) {
		parent::setID($dao, $id);
		$this->id = $id;
		$this->name = $name;
		$this->link = $link;
		$this->position = $position;
	}
}

class MemNavVO extends ValueObject {
	public $role, $id;
	public $position;
	public $name;
	public $link;

	function __construct($dao, $id = null, $position= null, $name = null, $link = NULL, $role = null) {
		parent::setID($dao, $id);
		$this->id = $id;
		$this->name = $name;
		$this->role = $role;
		$this->position = $position;
		$this->link = $link;
	}
}

class nav_show {
	public $navDAO_Main, $navDAO_Mem;

	function __construct($mainNavObject, $memberNavObject)
	{
		$this->navDAO_Main = $mainNavObject;
		$this->navDAO_Mem = $memberNavObject;
	}

	function show_main () {

		foreach ($this->navDAO_Main as $k => $value) {
			foreach ($value as $key => $value2){
				//print_r($key);
				if ($key == 'position') { $position = $value2;}
				if ($key == 'name') { $name = $value2;}
				if ($key == 'link') { $link = $value2;}
			}
			$array[$position]['name'] = $name;
			$array[$position]['link'] = $link;
		}
		ksort($array);
		//print_r ($array);
		foreach ($array as $key => $value){
			//echo $key.'<br>';
			$link = $array[$key]['link'];
			$name = $array[$key]['name'];
			echo '<div class="link"><a href="' . $link . '">' . $name . '</a></div>';
		}
	}
		
	public function show_mem ($permission_power = 0)
	{
		$i=0;
		foreach ($this->navDAO_Mem as $key => $value)	{
				foreach ($value as $key2 => $value2){
				//	print_r($key2);
					if ($key2 == 'position') { $position = $value2;}
					if ($key2 == 'name') { $name = $value2;}
					if ($key2 == 'link') { $link = $value2;}
					if ($key2 == 'role') { $role = $value2;}
				}
				$array[$role][$position]['name'] = $name;
				$array[$role][$position]['link'] = $link;
		}
		ksort($array);
		//print_r ($array);
		while ($i <= $permission_power) {
			if (isset($array[$i])) {
			//	print_r($array[$i]);
				foreach ($array[$i] as $key => $val) {

					$link = $array[$i][$key]['link'];
					$name = $array[$i][$key]['name'];
					echo '<div class="link"><a href="' . $link . '">' . $name . '</a></div>';
				}
			}
			$i++;
		}
	}
}