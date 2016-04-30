<?php
if (basename($_SERVER['SCRIPT_FILENAME']) === 'memnav.db.php')
{exit('This page may not be called directly !'); }

$working_db = 'navigation';
$working_set= 'mainnav';

if (isset ($_POST['save']))
{
	$id = $_POST['navcount'];
	$savid= $_POST['navid'];
	$savname = $_POST['navname'];
	$savlink = $_POST['navlink'];
	$savpos = $_POST['navpos'];
	
	switch ($_POST['savevar'])
	{
		case 'all':
			break;
		case 'new':
						
			$sql = "INSERT INTO `$working_db` (`id`, `name`, `link`, `position`)";
			$sql .= " VALUES ( ";
			$sql .= $id.',';
			$sql .= '"'.$savname.'",';
			$sql .= '"'.$savlink.'",';
			$sql .= '"'.$savpos.'")';
			 
			$db_erg = mysqli_query( $db_link, $sql );
			break;
		default:  //update
			 
			
			$sql = "SELECT * FROM `$working_db` WHERE id='$savid'";
			$db_erg = mysqli_query( $db_link, $sql );
			
			$sql_befehl = " `name` = '".$savname."', `link` = '".$savlink."', ";
			$sql_befehl .= "`position` = '".$savpos."'";
			
			$sql_update = "UPDATE `$working_db` SET ";
			$sql_update .= $sql_befehl;  
			$sql_update .= " WHERE `$working_db`.`id`=$savid ";
			echo $sql_update;
			$db_erg = mysqli_query( $db_link, $sql_update );
			
			break;
	}
	
	
}
if (isset($_POST['delete']))
{
	$id = $_POST['navcount'];
	$savid= $_POST['navid'];
	
	mysqli_select_db($db_link, MYSQL_DATENBANK);
			
	$sql = "DELETE FROM `$working_db` WHERE `id` = $savid";
	$db_del = mysqli_query( $db_link, $sql );
	if ( ! $db_del ) {die('L&ouml;schen nicht m&ouml;glich ' . mysql_error());}
	else {
		echo 'Daten gel&ouml;scht!';
	}		
}

$sql = "SELECT * FROM `$working_db` ORDER BY `position`";
$db_erg = mysqli_query( $db_link, $sql );
if ( ! $db_erg ) {echo 'Ung&uuml;ltige Abfrage: ' .mysqli_errno($db_link);}
$i = 1;
while ($daten = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
{ 
	$navid = $daten['id'];
	$navname = $daten['name'];
	$navlink = $daten['link'];
	$navpos = $daten['position'];
	?>
	<form action="?site=admin" method="POST">
	<table>
	<tr><th width="25%">Name</th><th width="25%">Link</th><th width="15%">Position</th><th width="20%"></th></tr>
	<tr>
		<td>
		<input type="hidden" name="selector" value="<?php echo $working_set;?>"/>
		<input type="hidden" name="navid" value="<?php echo $navid;?>" required/>
		<input type="hidden" name="navcount" value="<?php echo $i;?>" required/>
		<input type="text" name="navname" value="<?php echo $navname;?>" required/></td>
		<td><input type="text" name="navlink" value="<?php echo $navlink;?>" required/></td>
		<td><input type="text" name="navpos" value="<?php echo $navpos;?>" required/></td>
		<td><input type="hidden" name="savevar" value="<?php echo $navid;?>" required/>
		<input Type="submit" name="save" value="save">
		<input Type="submit" name="delete" value="L&ouml;schen">
		</td>
	</tr>
	</table></form>
<?php $i++; }?>

Neuer Eintrag:<br>
<form name="new" action="?site=admin" method="POST"><table>
<tr><th>Name</th><th>Link</th><th>Position</th></tr><tr>
		<td>
		<input type="hidden" name="selector" value="<?php echo $working_set;?>"/>
		<input type="hidden" name="navcount" value="<?php echo $i;?>" required/>
		<input type="text" name="navname" placeholder="Neuer Name" required/></td>
		<td><input type="text" name="navlink" placeholder="Neuer Link ?site=" required/></td>
		<td><input type="text" name="navpos" placeholder="Position" required/></td>
		<td><input Type="submit" name="save" value="save">
		<input type="hidden" name="savevar" value="new" required/></td>
	</tr>
</table>
	</form>
