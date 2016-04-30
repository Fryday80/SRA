<?php
if (basename($_SERVER['SCRIPT_FILENAME']) === 'navigation.cs.php'){exit('This page may not be called directly !'); }


class navigation {
	protected $name, $link, $position;
	protected $view;
	
	public function __construct($name, $link, $position)
	{
			
		$this->name		= $name;
		$this->link     = $title;
		$this->position = $position;
		$this->items    = array();
	}
	
	function add ($name, $link, $position) {
		$this->view[$position] = array( "name" => $name, "link" => $link);
	}
	
	function show () {
		ksort($this->view);
		foreach ($this->view as $k => $v){
			ksort($this->view["$k"]);
			$lin = $this->view["$k"]["link"];
			$nam = $this->view["$k"]["name"];
			echo '<div class="link"><a href="'.$lin.'">'.$nam.'</a></div>';
		}
	}
}

class memnav {
	protected $name, $link, $position, $perm;
	protected $view_m;

	public function __construct($name, $link, $position, $perm)
	{
		$this->name		= $name;
		$this->link     = $title;
		$this->position = $position;
		$this->perm		= $perm;
		$this->items    = array();
	}
	
	private function mkitem($name, $link, $position, $perm)
	{
		return array( "$position" => array( "name" => $name, "link" => $link));
	}
	
	public function add ($name, $link, $position, $perm) 
	{
		//$this->view_m[$perm] = $this->mkitem($name, $link, $position, $perm);
		$this->view_m[$perm][$position] = array( "name" => $name, "link" => $link);
	}
		
	public function show ($perm) 
	{

		$i=0;
		
		ksort($this->view_m);
		for ($i=0; $i <= $perm; $i++){
			ksort($this->view_m["$i"]);
			foreach ($this->view_m[$i] as $k => $v)
			{
				$lin = $this->view_m["$i"]["$k"]["link"];
				$nam = $this->view_m["$i"]["$k"]["name"];
				echo '<div class="link"><a href="'.$lin.'">'.$nam.'</a></div>';
			}
		}
	}

}