<?php 
//if (basename($_SERVER['SCRIPT_FILENAME']) === 'check.php'){exit('This page may not be called directly !'); }
if ($_POST['logout'] == 'logout'){
		session_destroy();
		unset ($valid);
		unset ($user);
		unset ($role);
}
	//if (!isset ($_POST['login'])){ echo 'bereits eingeloggt';}
	//elseif ($_SESSION['user_login'] == 1) {}
if ($_POST['login'] && $_POST['pw'] !== '' && $_POST['user'] !== ''){
		$check['user'] = $_POST['user'];
		$check['pw'] = $_POST['pw'];
		$sql = "SELECT * FROM `login` WHERE `login` = '";
		$sql .= $check['user'];
		$sql .= "'";
		$db_erg = mysqli_query( $db_link, $sql );
		while ($daten = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
		{
			$pw = $daten['pw'];
			$_SESSION['user'] = array (
					"user" => $daten['login'],
					"user_id" => $daten['usr_id'],
					"role" => $daten['role']
			);
		}
		mysqli_free_result( $db_erg );
		$hash = hash(md5, $check['pw']);
		if ($pw == $hash){
			$_SESSION['user_login'] = 1;
			$valid = 1;
			$sql = "SELECT * FROM `member` WHERE `usr_id` = '";
			$sql .= $user['user_id'];
			$sql .= "'";
			$db_erg = mysqli_query( $db_link, $sql );
			while ($daten = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
			{
				foreach ($daten as $k => $v){
					if ($k !== "id" && $k !== "usr_id"){
						$_SESSION['user']= array (
								"$k" => "$v"
						);
					}
				}
			}
			mysqli_free_result( $db_erg );
			$_SESSION[user_role] = $_SESSION['user']['role'];
		}
} 


/*
 * So hashen Sie ein Passwort:

$hash=password_hash($password, PASSWORD_DEFAULT);

[Bearbeiten] So prüfen Sie das Passwort gegen den Hash:

if ( password_verify( $password, $hash ) ) { ... }
 */
?>