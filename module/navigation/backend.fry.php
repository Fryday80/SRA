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
		bugfix ('final array<br>');
		//print_r($array);
		//ksort($array);
		$GLOBALS['navarray'] = $array;
	}

	private function makeup_roles ($items)
	{
		foreach ($items as $key => $value)	{
			foreach ($value as $key2 => $value2) {
			/*	bugfix();
				print_r($key2);
				br();
				print_r($value2);
				br();
			*/
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
		bugfix ('final array<br>');
		//print_r($array2);
		//ksort($array);
		$GLOBALS['roles_overwiew'] = $array2;

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
		$position_count= 0;
		if ($GLOBALS['roleswitch']) {
			$newid = 1;
			//print_r ($this->navigation_array);
			for ($i = 0; $i < '10'; $i++) {
				if (isset ($this->navigation_array[$i]))
				{

					echo '<table><tr><th colspan="4">User_Power '.$i.'</th></tr>';
					echo '<tr><td>id</td><td>Name</td><td>Link</td><td>Position</td><td>Sichtbarkeit</td><td></td></tr>';
					foreach ($this->navigation_array[$i] as $key => $value)
					{
						$count = count ($this->navigation_array[$i]);
						$newid = $newid+$count;
						$position = $key;
						$this->position_array[$position_count] = $position;
						$position_count++;
						$name = $this->navigation_array[$i][$key]['name'];
						$link = $this->navigation_array[$i][$key]['link'];
						$id = $this->navigation_array[$i][$key]['id'];
						$role = $i;
						?>
						<tr><form>
						<td>
							<input type="hidden" name="selector" value="<?php echo $GLOBALS['selector'];?>"/>
							<input type="text" name="navid" value="<?php echo $id;?>" required readonly/>
							<input type="hidden" name="navcount" value="<?php echo $i;?>" required/>
						</td>
						<td><input type="text" name="navname" value="<?php echo $name;?>" required/></td>
						<td><input type="text" name="navlink" value="<?php echo $link;?>" required/></td>
						<td><input type="text" name="navpos" value="<?php echo $position;?>" required/></td>
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
							<input type="hidden" name="savevar" value="<?php echo $id;?>" required/>
							<input Type="submit" name="save" value="save">
							<input Type="submit" name="delete" value="L&ouml;schen">
						</td></form></tr>
						<?php
					}

				}
			}
			echo '<tr><th colspan="4">Neu</th></tr>';
			?>
			<tr><form>
					<td>
						<input type="hidden" name="selector" value="<?php echo $GLOBALS['selector'];?>"/>
						<input type="text" name="navid" value="<?php echo $newid;?>" required readonly/>
					</td>
					<td><input type="text" name="navname" placeholder="Menüpunkt Name" required/></td>
					<td><input type="text" name="navlink" placeholder="Link" required/></td>
					<td><input type="text" name="navpos" placeholder="Position = Unique" required/>
						<?php
						$selector = 'position';
						for ($i = 0; $i < '20'; $i++){
							if ($i == $position ) {$var = 'option'.$i.'s';
								if (isset ($this->selectors_array[$selector][$var])) {echo $this->selectors_array[$selector][$var];}}
							else{$var = 'option'.$i;
								if (isset ($this->selectors_array[$selector][$var])) {echo $this->selectors_array[$selector][$var];}}
						}
						?>
					</td>
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
						<input Type="submit" name="save" value="save">
						<input Type="submit" name="delete" value="L&ouml;schen">
					</td></form></tr>
			</table>
			<?php
		} else{
			echo '<table><tr><th colspan="4">Hauptnavigation</th></tr>';
			echo '<tr><td>id</td><td>Name</td><td>Link</td><td>Position</td><td>Sichtbarkeit</td><td></td></tr>';
			foreach ($this->navigation_array[0] as $key => $value)
			{
				$position = $key;
				$name = $this->navigation_array[0][$key]['name'];
				$link = $this->navigation_array[0][$key]['link'];
				$id = $this->navigation_array[0][$key]['id'];
				$role = 'Hauptnavigation';
			//	$role = $this->navigation_array[$i][$key]['role'];
				?>
				<tr><form>
					<td>
						<input type="hidden" name="selector" value="<?php echo $GLOBALS['selector'];?>"/>
						<input type="text" name="navid" value="<?php echo $id;?>" required readonly/>
					</td>
					<td><input type="text" name="navname" value="<?php echo $name;?>" required/></td>
					<td><input type="text" name="navlink" value="<?php echo $link;?>" required/></td>
					<td><input type="text" name="navpos" value="<?php echo $position;?>" required/></td>
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
			<tr><form>
					<td>
						<input type="hidden" name="selector" value="<?php echo $GLOBALS['selector'];?>"/>
						<input type="text" name="navid" value="<?php echo $newid;?>" required readonly/>
					</td>
					<td><input type="text" name="navname" placeholder="Menüpunkt Name" required/></td>
					<td><input type="text" name="navlink" placeholder="Link" required/></td>
					<td><input type="text" name="navpos" placeholder="Position = Unique" required/></td>
					<td><input type="text" name="navrole" value="<?php echo $role;?>" required readonly/></td>
					<td>
						<input Type="submit" name="save" value="save">
						<input Type="submit" name="delete" value="L&ouml;schen">
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
		/* @todo:
		if in array => nur selected
		if !in array =>selectabel

		$op_count = 0;
		$array_for = 'position';
		foreach ($this->position_array as $key => $value){
			$varname = 'option'.$op_count;
			$varname2 = $varname.'s';
			$this->selectors_array[$array_for][$varname] = '<option value="'.$value.'">'.$value.'</option>';
			$this->selectors_array[$array_for][$varname2] = '<option value="'.$value.'"selected>'.$value.'</option>';
			$op_count++;
		}

		//return $this->selectors_array; */
	}
}
?>