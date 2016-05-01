<?php
ini_set('session.gc_maxlifetime', 3600);
ini_set('session.gc_divisor', 1);
session_start();

include_once 'all.inc.php';
include_once 'html/template/header.php';

if (!isset ($_GET['site'])){$_GET['site']='profil';}
if ($_GET['site'] !== 'admin')
{
?>
<body>
<?php 
jetzt ();
$auth = new authentication($db_link);
$navigation = new navigation($db_link);
$show_navi = new nav_show();
echo 'bugfix<br>';
print_r ($_POST);
br (1);
echo 'bugfix<br>';
print_r ($_SESSION);
?>

<div id="site">
	<div id="head">
		<?php include ('html/template/head.php');?>
	</div>
	<div id="view1">
		<div id="up">
			<div id="left1">
				<?php
				include ('html/template/left1.php');
				?>
			</div>
			<div id="second1">
				<div id="right1">
					<?php
					
					include ('html/template/right1.php');
					?>
				</div>
				<div id="middle1">
					<?php
					include ('html/template/middle1.php');
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
<?php }else{include 'module/BackEnd/indexA.php';}mysqli_close($db_link);
?>
</body>
</html>