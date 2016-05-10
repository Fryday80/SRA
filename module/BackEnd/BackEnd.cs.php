<?php 
if (basename($_SERVER['SCRIPT_FILENAME']) === 'BackEnd.cs.php'){exit('This page may not be called directly !'); }

/************************************
 *  Classes 						*
 ************************************/

class backend{
	public $menu, $sel, $left_menu;
	protected $i;

	function __construct ()
	{
		if (isset ($_POST['selector'])) {$this->sel = $_POST['selector'];}
		$this->left_menu = array();
		$this->menu =  array("css", "Templates", "content", "mainnav", "memnav", "Members", "module");
		$this->create_left_menu();
	}

	protected function create_left_menu ()
	{
		if (!isset ($_POST['selector']) OR $_POST['selector'] == 'home') {
			$i = 0;

			foreach ($this->menu as $items) {
				$this->left_menu[$i] = '<form action="?site=admin" method="POST">';
				$this->left_menu[$i] .= '<input type="submit" name="selector" value="' . $items . '" />';
				$this->left_menu[$i] .= '</form>';
				$i++;
			}

			$this->left_menu[$i] = '<br><br><br><a href="?site=profil"> zur Homepage</a>';
		} else {
			$this->left_menu[0] = '<form action="?site=admin" method="POST">';
			$this->left_menu[0] .= '<input type="submit" name="selector" value="home" />';
			$this->left_menu[0] .= '<input style="width:100px;" type="text" value="'.$this->sel.'" readonly />';
			$this->left_menu[0] .= '</form>';
			$this->i = 1;
			$this->switch_all();
		}
	}
	protected function switch_all ()
	{
		switch ($this->sel)
		{
			case 'module':
				$GLOBALS['p'] = 'module/';
				$GLOBALS['sel'] = $this->sel;
				bugfix ('->module');
				$dir = scandir($GLOBALS['p']);
				foreach ($dir as $files)
				{
					if ($files !== "." && $files !== "..")
					{
						$this->left_menu[$this->i] = '<form action="?site=admin" method="POST">';
						$this->left_menu[$this->i] .=  '<input type="hidden" name="selector" value="'.$GLOBALS['sel'].'"/>';
						$this->left_menu[$this->i] .= '<input type="hidden" name="path" value="'.$GLOBALS['p'].'"/>';
						$this->left_menu[$this->i] .= '<input type="submit" name="modul" value="'.$files.'" />';
						$this->left_menu[$this->i] .= '</form>';
					}
					$this->i++;
				}
				break;
			case 'Templates':
				$GLOBALS['p'] = 'html/template/';
			case 'css':
				if ($this->sel == 'css') {$GLOBALS['p'] = 'html/css/';}
			case 'content':
				if ($this->sel == 'content') {$GLOBALS['p'] = 'html/content/';}
				$GLOBALS['sel'] = $this->sel;
				$this->left_menu[$this->i] = '<form action="?site=admin" method="POST">';
				$this->left_menu[$this->i] .= '<input type="hidden" name="selector" value="'.$GLOBALS['sel'].'"/>';
				$this->left_menu[$this->i] .= '<input type="hidden" name="path" value="'.$GLOBALS['p'].'"/>';
				$this->left_menu[$this->i] .= '<input type="submit" name="select" value="Neu" />';
				$this->left_menu[$this->i] .= '</form><br>';
				$this->i++;
				$dir = scandir($GLOBALS['p']);
				foreach ($dir as $files)
				{
					if ($files !== "." && $files !== "..")
					{
						$this->left_menu[$this->i] = '<form action="?site=admin" method="POST">';
						$this->left_menu[$this->i] .= '<input type="hidden" name="selector" value="'.$GLOBALS['sel'].'"/>';
						$this->left_menu[$this->i] .= '<input type="hidden" name="path" value="'.$GLOBALS['p'].'"/>';
						$this->left_menu[$this->i] .= '<input type="submit" name="select" value="'.$files.'" />';
						$this->left_menu[$this->i] .= '</form>';
					}
					$this->i++;
				}
				break;
			case 'mainnav':
				$GLOBALS['p'] = 'module/navigation/backend.fry.php';
				$GLOBALS['sel'] = $this->sel;
				$GLOBALS['nav'] = 'main';
				break;
			case 'memnav':
				$GLOBALS['p'] = 'module/navigation/backend.fry.php';
				$GLOBALS['sel'] = $this->sel;
				$GLOBALS['nav'] = 'mem';
				break;
			case 'Members':
				$GLOBALS['p'] = 'module/members/members.index.php';
				$GLOBALS['sel'] = $this->sel;
				break;
			default:
				break;
		}
	}
}
class backend_show {
	protected $backend;

	function __construct ($backend) {
		$this->backend = $backend;
	}
	function show_left_menu () {
		foreach ($this->backend->left_menu as $k=>$v) {
			echo $v;
		}
	}
}
class backend_filehandler
{


	function __construct()
	{
		if (isset($_POST['select'])) {
			$this->show();
		}
	}

	private function show()
	{
		switch ($_POST['selector']) {
			case 'mainnav':
			case 'memnav':
				echo 'navi';
				include $GLOBALS['p'];
				break;
			case 'Members':
				include $GLOBALS['p'];
			break;
			default:
				$datei = $_POST['path'] . $_POST['select'];
				if (isset ($_POST['select'])) {
					$dat = $_POST['select'];
					if ($_POST['select'] == 'Neu') {
						$datei = $_POST['path'] . $_POST['new_name'] . '.' . $GLOBALS['sel'];
					}
					if (isset($_POST['save'])) {
						if ($_POST['save'] == 'speichern') {
							$filehandler = fopen("$datei", "w");
							$update = fwrite($filehandler, $_POST['file']);
							fclose($filehandler);
						}
					}
					$filehandler = fopen("$datei", "r");
					$text = fread($filehandler, filesize($datei));
					echo $GLOBALS['p'] . $dat;
					?>
					<form action="?site=admin" method="POST">
				<textarea cols="100" rows="24" name="file">
					<?php
					echo $text;
					echo '</textarea>';
					echo '<input type="hidden" name="path" value="'.$GLOBALS['p'].'"/>';
					echo '<input type="hidden" name="selector" value="'.$GLOBALS['sel'].'"/>';
					echo '<input type="hidden" name="select" value="'.$dat.'"/>';
					if ($_POST['select'] == 'Neu') {
						echo '<input type="text" name="new_name" placeholder="Neuer Name"/>';
						switch ($GLOBALS['sel']) {
							case 'content':
								$fileex = '.php';
								echo $fileex;
								break;
							default:
								echo '.' . $GLOBALS['sel'];
						}
					}
					echo '<input type="submit" name="save" value="speichern" />';
					echo '</form>';
				}
		}
		fclose($filehandler);
	}
}