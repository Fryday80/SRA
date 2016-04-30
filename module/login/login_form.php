<?php 
if (basename($_SERVER['SCRIPT_FILENAME']) === 'login.php'){exit('This page may not be called directly !'); }

if ($_SESSION['uer_login'] !== 1){

	echo '<form action="?site=login" method="post">';
	echo '<p>Benutzername</p>';
	echo '<p><input type="text" size="10" name="user" placeholder="Benutzername" required /></p>';
	echo '<p>Passwort</p>';
	echo '<p><input type="password" size="10" name="pw" placeholder="passwort" required /></p>';
	echo '<input type="Submit" style="background-color:lightgreen" name="login" value="login" />';
	echo '</form>';
	br();
}
?>