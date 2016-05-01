<?php 
if (basename($_SERVER['SCRIPT_FILENAME']) === 'indexA.php')
{exit('This page may not be called directly !'); }
if ($_SESSION['role'] !== '6' && $_SESSION['user_login'] !== 1){exit ('Zugriff nicht erlaubt');}

?>
<body>
<?php 
jetzt ();
// print_r ($_POST);
if (isset ($_POST['selector'])){$selector = $_POST['selector'];}
if (isset ($_POST['select'])){$select = $_POST['select'];}
if (isset ($_POST['save']) && ($_POST['save'] == 'speichern')){
		if (!isset ($_POST['new_name'])){
			$datei = $_POST['path'].$_POST['select'];
		}
		else {
			$file_content = $_POST['file'];
			$new_name = $_POST['new_name'];
			$file_ending = $_POST['new_name_file_ex'];
			$new_path = $_POST['path'];
			
			$datei = $new_path.$new_name.$file_ending;
		}
	$filehandler = fopen("$datei", "w");
	$update = fwrite($filehandler, $_POST['file']);
	fclose($filehandler);
}

?>

<div id="site">
	<div id="head">
		<img src="module/BackEnd/be.png" height=100%>
	</div>
	<div id="view1">
		<div id="up">
			<div id="left1">
				<?php
				$menu = array ("index", "css", "Templates", "mainnav", "memnav", "content", "members"  );
				foreach ($menu as $items)
				{
					echo '<form action="?site=admin" method="POST">';
					echo '<input type="submit" name="selector" value="'.$items.'" />';
					echo '</form>';
				}
			if (isset ($selector)){	
				switch ($selector)
				{
					case 'css':
						$p = 'html/css/';
						break;
					case 'module':
						$p = 'module/';
						br (2);
						$dir = scandir($p);
						foreach ($dir as $files)
						{
							if ($files !== "." && $files !== "..")
							{
								echo '<form action="?site=admin" method="POST">';
								echo '<input type="hidden" name="selector" value="'.$selector.'"/>';
								echo '<input type="hidden" name="path" value="'.$p.'"/>';
								echo '<input type="submit" name="modul" value="'.$files.'" />';
								echo '</form>';
							}
						}
						break;
					case 'content':
						$p = 'html/content/';
						break;
					case 'mainnav':
						$p = 'module/navigation/backend.fry.php';
						$nav = 'main';
						break;
					case 'memnav':
						$p = 'module/navigation/backend.fry.php';
						$nav = 'mem';
						break;
					case 'members':
						$p = 'module/members/members.fry.php';
						break;
					case 'Templates':
						$p = 'html/template/';
						break;
					case 'index':
						$p = './';
						break;
					default:
					break;
				}
			}
				br(3);
				echo '<a href="?site=profil"> zur Homepage</a>';
				?>
			</div>
			<div id="second1">
				<div id="right1">
					<?php
				if (isset ($selector)){
					switch ($selector)
					{
						case 'css':
						case 'Templates':
						case 'content':
					
							echo '<form action="?site=admin" method="POST">';
							echo '<input type="hidden" name="selector" value="'.$selector.'"/>';
							echo '<input type="hidden" name="path" value="'.$p.'"/>';
							echo '<input type="submit" name="select" value="Neu" />';
							echo '</form>';
							br (1);
							$dir = scandir($p);
							foreach ($dir as $files)
							{
								if ($files !== "." && $files !== "..")
								{
									echo '<form action="?site=admin" method="POST">';
									echo '<input type="hidden" name="selector" value="'.$selector.'"/>';
									echo '<input type="hidden" name="path" value="'.$p.'"/>';
									echo '<input type="submit" name="select" value="'.$files.'" />';
									echo '</form>';
								}
							}
							break;
						case 'mainnav':
						case 'memnav':
							$sql_roles = "SELECT * FROM `roles` ";
							$db_roles = mysqli_query($db_link, $sql_roles);
							while ($daten = mysqli_fetch_array( $db_roles, MYSQL_ASSOC))
							{
								$nr = $daten['role_nr'];
								$desc = $daten['role_desc'];
								echo "$nr = $desc<br>";
							}
							break;
						case 'index':
							echo '<form action="?site=admin" method="POST">';
							echo '<input type="hidden" name="selector" value="'.$selector.'"/>';
							echo '<input type="hidden" name="path" value="'.$p.'"/>';
							echo '<input type="submit" name="select" value="index.php" />';
							echo '</form>';
												
					}
				}
					?>
				</div>
				<div id="middle1" Style="background: none;">
<?php
			if (isset($selector)){
				switch ($selector)
				{
					case 'members':
					case 'mainnav':
					case 'memnav':
						include "$p";
						break;
					default:
					
					if (isset ($select))
					{
						
						if ($select == 'Neu')
						{
							$text = '';
							echo 'Neue Datei erstellen';
							
						}else{
							$datei = $p.$select;
							$filehandler = fopen("$datei", "r");
							$text = fread($filehandler, filesize($datei));
							echo $datei;
							fclose($filehandler);
						}
?>
						<form action="?site=admin" method="POST">
						<textarea cols="100" rows="24" name="file">
<?php 					
						echo $text;
?>
						</textarea>
						<input type="hidden" name="path" value="<?php echo $p; ?>"/>
						<input type="hidden" name="selector" value="<?php echo $selector; ?>"/>
						<input type="hidden" name="select" value="<?php echo $select; ?>"/>
						<?php 
						
						if ($select == 'Neu')
						{
							switch ($selector)
							{
								case 'content':
									$fileex = '.php';
									echo '<input type="text" name="new_name" placeholder="Neuer Name"/>';
									echo '<input type="hidden" name="new_name_file_ex" value="'.$fileex.'"/>';
									echo $fileex;
								break;
								default:
									echo '<input type="text" name="new_name" placeholder="Neuer Name"/>';
									echo '<input type="hidden" name="new_name_file_ex" value="'.$selector.'"/>';
									echo '.'.$selector;
							}
						}
						?>
						<input type="submit" name="save" value="speichern" />
						</form>
<?php 
						break;
						}
				}
						?>
<?php 
						}
?>
				</div>
			</div>
		</div>
	</div>
	<div class="clear"> <br><br><br></div>
	<div id="view2">
		<div id="down">
			<div id="left2">
				<?php
				include ('html/template/left2.php');
				?>
			</div>
			<div id="second2">
				<div id="right2">
					<?php
					include ('html/template/right2.php');
					?>
				</div>
				<div id="middle2">
					<?php
					include ('html/template/middle2.php');
					?>
					<div id="down_left1">
						<?php
						include ('html/template/down_left1.php');
						?>
					</div>
					<div id="down_right1">
						<?php
						include ('html/template/down_right1.php');
						?>
					</div>
					<div id="down_left2">
						<?php
						include ('html/template/down_left2.php');
						?>
						</div>
					<div id="down_right2">
						<?php
						include ('html/template/down_right2.php');
						echo $date;
						?>	
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
	<div id="foot">
		<?php include ('html/template/foot.php');?>
	</div>
</div>
</body>
</html>