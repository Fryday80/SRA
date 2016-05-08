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
				?>
			</div>
			<div id="second1">
				<div id="right1">
					<?php
					/*
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
					*/?>
				</div>
				<div id="middle1" Style="background: none;">
<?php
				$backend_files = new backend_filehandler();
				$alternate_array = array ('mainnav','memnav','Members');
				if (isset ($_POST['selector']) AND in_array($_POST['selector'], $alternate_array) )
				{
					include $p;
					if ($_POST['selector'] == 'mainnav' OR $_POST['selector'] == 'memnav') {
						$navigon = new backend_Navigation_Data($_POST['selector']);
						//print_r ($navigon);
						$backend_show = new backend_Navigation_View();
						$backend_show->create_View();
					}
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
				$memman = new Member_Manager();
				$member_cloud = $memman->get_All_Data();
				print_r ($member_cloud);
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