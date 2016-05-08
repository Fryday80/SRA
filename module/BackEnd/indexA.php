<?php 
if (basename($_SERVER['SCRIPT_FILENAME']) === 'indexA.php')
{exit('This page may not be called directly !'); }
if ($_SESSION['user_role'] !== '6'){exit ('Zugriff nicht erlaubt');}

?>
<body>
<?php 
jetzt ();

?>

<div id="site">
	<div id="head">
		<img src="module/BackEnd/be.png" height=100%>
	</div>
	<div id="view1">
		<div id="up">
			<div id="left1">
				<?php
				$backend = new backend();
				$backend_show = new backend_show($backend);
				$backend_show->show_left_menu();
				/*
				$sel = $_POST['selector'];
				$menu = array ("css", "module", "content", "mainnav", "memnav", "Members", "Templates");
				foreach ($menu as $items)
				{
					echo '<form action="?site=admin" method="POST">';
					echo '<input type="submit" name="selector" value="'.$items.'" />';
					echo '</form>';
				}
				switch ($_POST['selector'])
				{
					case 'css':
						$p = 'html/css/';
						$sel = $_POST['selector'];
						break;
					case 'module':
						$p = 'module/';
						$sel = $_POST['selector'];
						br (2);
						$dir = scandir($p);
						foreach ($dir as $files)
						{
							if ($files !== "." && $files !== "..")
							{
								echo '<form action="?site=admin" method="POST">';
								echo '<input type="hidden" name="selector" value="'.$sel.'"/>';
								echo '<input type="hidden" name="path" value="'.$p.'"/>';
								echo '<input type="submit" name="modul" value="'.$files.'" />';
								echo '</form>';
							}
						}
						break;
					case 'content':
						$p = 'html/content/';
						$sel = $_POST['selector'];
						break;
					case 'mainnav':
						$p = 'module/navigation/backend.fry.php';
						$sel = $_POST['selector'];
						$nav = 'main';
						break;
					case 'memnav':
						$p = 'module/navigation/backend.fry.php';
						$sel = $_POST['selector'];
						$nav = 'mem';
						break;
					case 'Members':
						$p = 'html/css/';
						$sel = $_POST['selector'];
						break;
					case 'Templates':
						$p = 'html/template/';
						$sel = $_POST['selector'];
						break;
					default:
					break;
				}
				br(3);
				echo '<a href="?site=profil"> zur Homepage</a>'; */
				?>
			</div>
			<div id="second1">
				<div id="right1">
					<?php
					switch ($_POST['selector'])
					{
						case 'css':
						case 'Templates':
						case 'content':

							echo '<form action="?site=admin" method="POST">';
							echo '<input type="hidden" name="selector" value="'.$sel.'"/>';
							echo '<input type="hidden" name="path" value="'.$p.'"/>';
							echo '<input type="submit" name="select" value="Neu" />';
							echo '</form>';
							br ();
							$dir = scandir($p);
							foreach ($dir as $files)
							{
								if ($files !== "." && $files !== "..")
								{
									echo '<form action="?site=admin" method="POST">';
									echo '<input type="hidden" name="selector" value="'.$sel.'"/>';
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
												
					}
					?>
				</div>
				<div id="middle1" Style="background: none;">
<?php
				$backend_files = new backend_filehandler();

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
				$memman = new Member_Manager();
				$member_cloud = $memman->get_All_Data();
				bugfix('here mem');
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