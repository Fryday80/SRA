<?php
if (basename($_SERVER['SCRIPT_FILENAME']) === 'login.cs.php'){exit('This page may not be called directly !'); }


class login_check{
	protected $input_user, $input_pw, $trans_in, $trans_out;
	public $user = array (); 
	public $user_role, $valid;
	
	public function __construct()
	{
		$input_user = $_POST['user'];
		$inpu_pw = $_POST['pw'];
		$trans_in = $_POST['login'];
		$trans_out = $_POST['logout'];
	}

	public function check (){

		if ($this->trans_out == 'logout')
		{
				unset ($user_login);
				unset ($user);
				unset ($user_role);
				session_destroy();
		}
		elseif ($this->trans_in !== 'login' OR $this->trans_out !== 'logout'){}
		else 
		{
				$sql = "SELECT * FROM `login` WHERE `login` = '".$this->input_user."'";
				$db_erg = mysqli_query( $db_link, $sql );
				while ($daten = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
				{
					$pw = $daten['pw'];
					$this->user = array (
							"user" => $daten['login'],
							"user_id" => $daten['usr_id'],
							"role" => $daten['role']
					);
				}
				mysqli_free_result( $db_erg );
				$hash = hash(md5, $this->input_pw);
				if ($pw == $hash)
				{
					unset ($pw);
					$this->valid = 1;
					$_SESSION['user_login'] = 1;
					$sql = "SELECT * FROM `member` WHERE usr_id = '".$user['user_id']."'";
					$db_erg = mysqli_query( $db_link, $sql );
					//if ( ! $db_erg ) {('Ung&uuml;ltige Login-Abfrage2: ' .mysqli_errno($db_link));}
					while ($daten = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
					{
						foreach ($daten as $k => $v)
						{
							if ($k !== "id" && $k !== "usr_id")
							{
								$this->user = array ( "$k" => "$v");
							}
						}
					}
					mysqli_free_result( $db_erg );
				}
				$this->user_role = $this->user['role'];
		}
	}
}


class logout{
	
	protected $action, $valid, $benutzer;
	
	public function __construct()
	{
		$action = $_SERVER['PHP_SELF'];
		$valid = $_SESSION['user_login'];
		$benutzer = $_SESSION['user'];
	}
	
	public function show_logout () 
	{
		if ($this->valid == 1)
		{
			echo '<form action="'.$this->action.'" method="post">';
			echo '<input type="Submit" style="background-color:lightgreen" name="logout" value="logout" />';
			echo '</form>';
		}
	}
}
class login{

	protected $action, $valid, $benutzer;

	public function __construct()
	{
		$action = $_SERVER['PHP_SELF'];
		$valid = $_SESSION['user_login'];
		$benutzer = $_SESSION['user'];
	}
	public function show_login () 
	{
		if ($this->valid == 1)
		{
			echo '<form action="'.$this->action.'" method="post">';
			echo '<table width="100px"><tr><th>Benutzername</th></tr>';
			echo '<tr><td><input type="text" name="user" placeholder="Benutzername" required /></td></tr>';
			echo '<tr><th>Passwort</th></tr>';
			echo '<tr><td><input type="password" name="pw" placeholder="Passwort" required /></td></tr></table>';
			echo '<input type="Submit" style="background-color:lightgreen" name="login" value="login" />';
			echo '</form>';
		}
	}
}
class greet{

	protected $action, $valid, $benutzer;

	public function __construct()
	{
		$action = $_SERVER['PHP_SELF'];
		$valid = $_SESSION['user_login'];
		$benutzer = $_SESSION['user'];
	}
	public function show_greetings ()
	{
		if ($this->valid == 1)
		{
			echo 'Hallo '.$this->benutzer;
		}
	}
}
?>