<?php
if (basename($_SERVER['SCRIPT_FILENAME']) === 'navigation.cs.php'){exit('This page may not be called directly !'); }

// ja ohne debug ausgaben seh ich nix
// dann füg ein... ich hab auch schon geschaut, das globale schreiben funzt au ned...
class navigation {
	protected $name, $link, $position, $perm, $db_link;
	public $view = array();
	public $view_m = array();
	
	public function __construct($db_link)
	{
		$this->db_link = $db_link;
		$this->view 	= array();
		$this->view_m   = array();
		$this->build_main();
		$this->build_mem();
	}
	
	private function build_main () {
		$sql = 'SELECT * FROM `navigation` ORDER BY "position"';
		$db_erg = mysqli_query( $this->db_link, $sql );
//		if ( ! $db_erg ) {die('Ung&uuml;ltige Abfrage: ' .mysqli_errno($db_link));}
		while ($daten = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
		{
			$name = $daten['name'];
			$link = $daten['link'];
			$pos = $daten['position'];
			
			$this->view[$pos] = array( "name" => $name, "link" => $link);
		}
		mysqli_free_result( $db_erg );
		
	}
	
	private function build_mem (){
		$sql = "SELECT * FROM `membernav` ORDER BY 'position'";
		$db_erg = mysqli_query( $this->db_link, $sql );
	//	if ( ! $db_erg ) {echo 'Ung&uuml;ltige Abfrage: ' .mysqli_errno($db_link);}
		while ($daten = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
		{
			$name = $daten['name'];
			$link = $daten['link'];
			$pos = $daten['position'];
			$perm = $daten['role'];
			$this->view_m[$perm][$pos] = array( "name" => $name, "link" => $link);
		}
	}
	
	
}

class nav_show {

	function show_main ($nav_object) {
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
	
		ksort($nav_object->view_m);
		for ($i=0; $i <= $permission_power; $i++){
			if ($nav_object->view_m[$i]){
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

}