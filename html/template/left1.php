<div>
<?php
$mainnavi = new navigation();

$sql = 'SELECT * FROM `navigation` ORDER BY "position"';
$db_erg = mysqli_query( $db_link, $sql );
if ( ! $db_erg ) {die('Ung&uuml;ltige Abfrage: ' .mysqli_errno($db_link));}
while ($daten = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
{
	$mainnavi->add($daten['name'], $daten['link'], $daten['position']);
}
mysqli_free_result( $db_erg );

$mainnavi->show();
?>
</div>
<div class="black_deko">
</div>
<div>
<?php 
if ($_SESSION['user_login'] == '1') {
	echo 'Hallo '.$_SESSION['user']['user'];
	
	$membernavi = new memnav();

	$sql = "SELECT * FROM `membernav` ORDER BY 'position'";
	$db_erg = mysqli_query( $db_link, $sql );
	if ( ! $db_erg ) {echo 'Ung&uuml;ltige Abfrage: ' .mysqli_errno($db_link);}
	while ($daten = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
	{
		$membernavi->add($daten['name'], $daten['link'], $daten['position'], $daten['role']);
	}
	mysqli_free_result( $db_erg );
	$membernavi->show($_SESSION['user_role']);
	br();
	include 'module/login/logout_but.php';
} else {
	include 'module/login/login_form.php';
}
?>
</div>