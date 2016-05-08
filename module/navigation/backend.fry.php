<?php
if (basename($_SERVER['SCRIPT_FILENAME']) === 'backend.fry.php'){exit('This page may not be called directly !'); }

class backend_Navigation_Data
{
	private $selector1, $selector2;
	protected $select, $navigation_items;

	function __construct($navigation_menu)
	{
		$this->selector1 = 'mainnav';
		$this->selector2 = 'memnav';
		$this->select = $navigation_menu;
		$GLOBALS['selector'] = $this->select;
		$this->build_navigationdata($this->select);
	}
	
	private function build_navigationdata()
	{
		if ($this->select == $this->selector1) {
			$items = new NavigationDAO();
		}
		if ($this->select == $this->selector2) {
			$items = new MembersNavigationDAO();
		}

		$items = $items->getNavigation();
		$this->navigation_items = $items;
		$array_of_interest = $this->get_array();
		return $array_of_interest;
	}
	
	private function get_array ()
	{
		foreach ($this->navigation_items as $key => $value)	{
			foreach ($value as $key2 => $value2){
				//bugfix ();
				//print_r($key2);
				if ($key2 == 'position') { $position = $value2;}
				if ($key2 == 'name') { $name = $value2;}
				if ($key2 == 'link') { $link = $value2;}
				if ($key2 == 'role') { $role = $value2;}
				if ($key2 == 'id')   { $id = $value2;}
			}
			if ($this->select == $this->selector2) {
				$array[$role][$position]['name'] = $name;
				$array[$role][$position]['link'] = $link;
				$array[$role][$position]['id'] = $id;
				$GLOBALS['roleswitch']= TRUE;
			}
			if ($this->select == $this->selector1) {
				$array[0][$position]['name'] = $name;
				$array[0][$position]['link'] = $link;
				$GLOBALS['roleswitch']= FALSE;
			}
		}
		bugfix ('final array<br>');
		//print_r($array);
		//ksort($array);
		$GLOBALS['navarray'] = $array;

	}
}

class backend_Navigation_View {
protected $navigation_array, $selector;

	function __construct()
	{
		$this->navigation_array = $GLOBALS['navarray'];

	}

	public function create_View ()
	{
		if ($GLOBALS['roleswitch']) {
			//print_r ($this->navigation_array);
			for ($i = 0; $i < '10'; $i++) {
				if ($this->navigation_array[$i])
				{
					foreach ($this->navigation_array[$i] as $key => $value)
					{
						$position = $key;
						$name = $this->navigation_array[$i][$key]['name'];
						$link = $this->navigation_array[$i][$key]['link'];
						$id = $this->navigation_array[$i][$key]['id'];
						$role = $this->navigation_array[$i][$key]['role'];
						?>
						<form>
						<input type="hidden" name="selector" value="<?php echo $GLOBALS['selector'];?>"/>
						<input type="hidden" name="navid" value="<?php echo $id;?>" required/>
						<input type="hidden" name="navcount" value="<?php echo $i;?>" required/>
						<input type="text" name="navname" value="<?php echo $name;?>" required/></td>
						<td><input type="text" name="navlink" value="<?php echo $link;?>" required/></td>
						<td><input type="text" name="navpos" value="<?php echo $position;?>" required/></td>
						<td><input type="text" name="navrole" value="<?php echo $role;?>" required/></td>
						<td><input type="hidden" name="savevar" value="<?php echo $id;?>" required/>
						<input Type="submit" name="save" value="save">
						<input Type="submit" name="delete" value="L&ouml;schen">
						</form>
						<?php
					}
				}
			}
		} else{

		}
	}
}
?>