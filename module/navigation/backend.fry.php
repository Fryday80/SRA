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
		if (isset ($_POST['save'])) { $this->save_data();}
		if (isset ($_POST['delete'])) { $this->delete_data($_POST['navid']);}
		if (isset ($_POST['insert'])) { $this->insert();}
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
		//print_r($this->navigation_items);
		$array_of_interest = $this->get_array();
		$GLOBALS['roles_overwiew']= array();
		$roles = new RolesDAO();
		$roles = $roles->getRoles();
		$this->makeup_roles($roles);
		//print_r ($GLOBALS['roles_overwiew']);
		return $array_of_interest;
	}
	
	private function get_array ()
	{
		foreach ($this->navigation_items as $key => $value)	{
			foreach ($value as $key2 => $value2){
				//bugfix ();
				//print_r($key2);
				//br();
				//print_r ($value2);
				//br();
				if ($key2 == 'position') { $position = $value2;}
				if ($key2 == 'name') { $name = $value2;}
				if ($key2 == 'link') { $link = $value2;}
				if ($key2 == 'role') { $role = $value2;}
				if ($key2 == 'id')   { $id = $value2;}
			}
			if ($this->select == $this->selector2) /** Memnav **/ {
				$array[$role][$position]['name'] = $name;
				$array[$role][$position]['link'] = $link;
				$array[$role][$position]['id'] = $id;
				$GLOBALS['roleswitch']= TRUE;
			}
			if ($this->select == $this->selector1) /** Mainnav **/ {
				$array[0][$position]['name'] = $name;
				$array[0][$position]['link'] = $link;
				$array[0][$position]['id'] = $id;
				$GLOBALS['roleswitch']= FALSE;
			}
		}
		bugfix ('final array<br>', 5);
		//print_r($array);
		//ksort($array);
		$GLOBALS['navarray'] = $array;
	}

	private function makeup_roles ($items)
	{
		foreach ($items as $key => $value)	{
			foreach ($value as $key2 => $value2) {
			bugfix('makeup_roles', 5);
				
					if ($key2 == 'role_nr') {
						$nr = $value2;
					}
					if ($key2 == 'role_desc') {
						$desc = $value2;
					}

					if ($key2 == 'leader_1') {
						$l1 = $value2;
					}
					if ($key2 == 'leader_2') {
						$l2 = $value2;
					}

			}
				$array2[$nr]['role_desc'] = $desc;
				$array2[$nr]['leader_1'] = $l1;
				$array2[$nr]['leader_2'] = $l2;
		}
		bugfix ('final array<br>', 5);
		$GLOBALS['roles_overwiew'] = $array2;

	}

	private function save_to_array(){
		print_r ($_POST);
		if ($_POST['navrole'] !== 'Hauptnavigation') { $save_array['role'] = $_POST['navrole'];}
		$save_array['id'] = $_POST['navid'];
		$save_array['position'] = $_POST['navpos'];
		$save_array['name'] = $_POST['navname'];
		$save_array['link'] = $_POST['navlink'];
		return $save_array;
	}

	private function save_data (){
		$save_array = $this->save_to_array();
		if ($this->select == $this->selector1){ $save = new NavigationDAO();}
		if ($this->select == $this->selector2){ $save = new MembersNavigationDAO();}
		$save->save($save_array);
	}

	private function delete_data ($id){
		if ($this->select == $this->selector1){ $delete = new NavigationDAO();}
		if ($this->select == $this->selector2){ $delete = new MembersNavigationDAO();}
		$delete->delete($id);
	}

	private function insert (){
		$save_array = $this->save_to_array();
		if ($this->select == $this->selector1){ $insert = new NavigationDAO();}
		if ($this->select == $this->selector2){ $insert = new MembersNavigationDAO();}
		print_r ($_POST);
		br();
		print_r ($save_array);
		br();
		bugfix('backend New NAV Insert', 5);
		$insert->insert($save_array);
	}
}

class backend_Navigation_View {
    protected $navigation_array, $selector;
	protected $selectors_array = array();
	protected $position_array;

	function __construct()
	{
		$this->navigation_array = $GLOBALS['navarray'];
		//print_r ($this->navigation_array);
	}

	public function create_View ()
	{
		//$selections =
		$this->create_selectors();
		$position_count= 1;
		$newid = 1;
		if ($GLOBALS['roleswitch']) {

			ksort($this->navigation_array);
			foreach ($this->navigation_array as $role => $roleUser) {

				echo '<table><tr><th colspan="4">User_Power '.$role.'</th></tr>';
				echo '<tr><td>id</td><td>Name</td><td>Link</td><td>Position</td><td>Sichtbarkeit</td><td></td></tr>';

				foreach ($roleUser as $key => $value)
				{
					$newid++;
					$position_count++;
					$position = $key;
					$this->position_array[$position_count] = $position;
					$name = $value['name'];
					$link = $value['link'];
					$id = $value['id'];
					?>
					<tr><form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
							<td>
								<input type="hidden" name="selector" value="<?php echo $GLOBALS['selector'];?>"/>
								<input type="text" style="width:25px;" name="navid" value="<?php echo $id;?>" required readonly/>
								<input type="hidden" name="navcount" value="<?php echo $i;?>" required/>
							</td>
							<td><input type="text" name="navname" value="<?php echo $name;?>" required/></td>
							<td><input type="text" style="width:250px;" name="navlink" value="<?php echo $link;?>" required/></td>
							<td><select name="navpos" size=""1">
								<?php
								$selector = 'position';// $selector == string
								for ($i = 0; $i < '20'; $i++){
									if ($i == $position ) {
										$var = 'option'.$i.'s';
										if (isset ($this->selectors_array[$selector][$var])) {echo $this->selectors_array[$selector][$var];}}
									else{$var = 'option'.$i;
										if (isset ($this->selectors_array[$selector][$var])) {echo $this->selectors_array[$selector][$var];}}
								}
								?>
								</select></td>
							<td><select name="navrole" size="1">
									<?php
									$selector = 'roles';
									for ($i = 0; $i < '10'; $i++){
										if ($i == $role ) {$var = 'option'.$i.'s';
											if (isset ($this->selectors_array[$selector][$var])) {echo $this->selectors_array[$selector][$var];}}
										else{$var = 'option'.$i;
											if (isset ($this->selectors_array[$selector][$var])) {echo $this->selectors_array[$selector][$var];}}
									}
									?>
								</select></td>
							<td>
								<input type="hidden" name="savevar;
										if (isset ($this->selectors_array[" value="<?php echo $id;?>" required/>
								<input Type="submit" name="save" value="save">
								<input Type="submit" name="delete" value="L&ouml;schen">
							</td></form></tr>
					<?php
				}

			}

			echo '<tr><th colspan="4">Neu</th></tr>';
			?>
			<tr><form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
					<td>
						<input type="hidden" name="selector" value="<?php echo $GLOBALS['selector'];?>"/>
						<input type="hidden" name="new" value="1"/>
						<input type="text" style="width:25px;" name="navid" value="<?php echo $newid;?>" required readonly/>
					</td>
					<td><input type="text" name="navname" placeholder="Menüpunkt Name" required/></td>
					<td><input type="text" style="width:250px;" name="navlink" placeholder="Link" required/></td>
					<td><select name="navpos" size=""1">
						<?php
						$position=$position_count;
						$selector = 'position';
						for ($i = 0; $i < '20'; $i++){
							if ($i == $position ) {$var = 'option'.$i.'s';
								if (isset ($this->selectors_array[$selector][$var])) {echo $this->selectors_array[$selector][$var];}}
							else{$var = 'option'.$i;
								if (isset ($this->selectors_array[$selector][$var])) {echo $this->selectors_array[$selector][$var];}}
						}
						?>
					</select></td>
					<td><select name="navrole" size="1">
							<?php
							$role=1;
							$selector = 'roles';
							for ($i = 0; $i < '10'; $i++){
								if ($i == $role ) {$var = 'option'.$i.'s';
									if (isset ($this->selectors_array[$selector][$var])) {echo $this->selectors_array[$selector][$var];}}
								else{$var = 'option'.$i;
									if (isset ($this->selectors_array[$selector][$var])) {echo $this->selectors_array[$selector][$var];}}
							}
							?>
						</select></td>
					<td>
						<input Type="submit" name="insert" value="save">
					</td></form></tr>
			</table>
			<?php
		} else{
			echo '<table><tr><th colspan="4">Hauptnavigation</th></tr>';
			echo '<tr><td>id</td><td>Name</td><td>Link</td><td>Position</td><td>Sichtbarkeit</td><td></td></tr>';
			foreach ($this->navigation_array[0] as $key => $value)
			{
				$position = $key;
				$this->position_array[$position_count] = $position;
				$newid++;
				$position_count++;
				$name = $this->navigation_array[0][$key]['name'];
				$link = $this->navigation_array[0][$key]['link'];
				$id = $this->navigation_array[0][$key]['id'];
				$role = 'Hauptnavigation';
			//	$role = $this->navigation_array[$i][$key]['role'];
				?>
				<tr><form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
					<td>
						<input type="hidden" name="selector" value="<?php echo $GLOBALS['selector'];?>"/>
						<input type="text" style="width:25px;" name="navid" value="<?php echo $id;?>" required readonly/>
					</td>
					<td><input type="text" name="navname" value="<?php echo $name;?>" required/></td>
					<td><input type="text" style="width:250px;" name="navlink" value="<?php echo $link;?>" required/></td>
						<td><select name="navpos" size=""1">
							<?php
							$selector = 'position';
							for ($i = 0; $i < '20'; $i++){
								if ($i == $position ) {$var = 'option'.$i.'s';
									if (isset ($this->selectors_array[$selector][$var])) {echo $this->selectors_array[$selector][$var];}}
								else{$var = 'option'.$i;
									if (isset ($this->selectors_array[$selector][$var])) {echo $this->selectors_array[$selector][$var];}}
							}
							?>
							</select></td>
					<td><input type="text" name="navrole" value="<?php echo $role;?>" required/></td>
					<td>
						<input Type="submit" name="save" value="save">
						<input Type="submit" name="delete" value="L&ouml;schen">
					</td></form></tr>
				<?php
			}
			$newid = count ($this->navigation_array[0]);
			$newid++;
			echo '<tr><th colspan="4">Neu</th></tr>';
			?>
			<tr><form action="<?php $_SERVER['PHP_SELF'];?>" method="POST">
					<td>
						<input type="hidden" name="selector" value="<?php echo $GLOBALS['selector'];?>"/>
						<input type="hidden" name="new" value="1"/>
						<input type="text" style="width:25px;" name="navid" value="<?php echo $newid;?>" required readonly/>
					</td>
					<td><input type="text" name="navname" placeholder="Menüpunkt Name" required/></td>
					<td><input type="text" style="width:250px;" name="navlink" placeholder="Link" required/></td>
					<td><select name="navpos" size=""1">
						<?php
						$position=$position_count;
						$selector = 'position';
						for ($i = 0; $i < '20'; $i++){
							if ($i == $position ) {$var = 'option'.$i.'s';
								if (isset ($this->selectors_array[$selector][$var])) {echo $this->selectors_array[$selector][$var];}}
							else{$var = 'option'.$i;
								if (isset ($this->selectors_array[$selector][$var])) {echo $this->selectors_array[$selector][$var];}}
						}
						?>
						</select></td>
					<td><input type="text" name="navrole" value="<?php echo $role;?>" required readonly/></td>
					<td>
						<input Type="submit" name="insert" value="save">
					</td></form></tr>
			<?php
			echo '</table>';
		}
	}

	private function create_selectors (){
		$op_count = 0;
		$array_for = 'roles';
		foreach ($GLOBALS['roles_overwiew'] as $key){
			foreach ($GLOBALS['roles_overwiew'][$op_count] as $subkey => $subvalue){
				if ($subkey == 'role_desc'){$desc = $subvalue;}
				if ($subkey == 'leader_1'){$l1 = $subvalue;}
				if ($subkey == 'leader_2'){$l2 = $subvalue;}
				//print_r($subvalue);
			}
			$varname = 'option'.$op_count;
			$varname2 = $varname.'s';
			$this->selectors_array[$array_for][$varname] = '<option value="'.$op_count.'">'.$desc.'</option>';
			$this->selectors_array[$array_for][$varname2] = '<option value="'.$op_count.'"selected>'.$desc.'</option>';
			$op_count++;
		}
		$max = 20;
		// @todo:
		//if in array => nur selected
		//if !in array =>selectabel

		$op_count = 0;
		$array_for = 'position';
		for ($i=1 ; $i <= 20 ; $i++){
			$varname = 'option'.$i;
			$varname2 = $varname.'s';
			$this->selectors_array[$array_for][$varname] = '<option value="'.$i.'">'.$i.'</option>';
			$this->selectors_array[$array_for][$varname2] = '<option value="'.$i.'"selected>'.$i.'</option>';
			$op_count++;
		}

		//return $this->selectors_array; */
	}
}
?>