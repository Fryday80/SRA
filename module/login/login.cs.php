<?php
if (basename($_SERVER['SCRIPT_FILENAME']) === 'login.cs.php'){exit('This page may not be called directly !'); }


class authentication{
	protected $input_user, $input_pw, $trans_in, $trans_out, $pw;
	public $usr = array ();
	public $valid_user;
	
	public function __construct()
	{
		$input_user = $_POST['user'];
		$inpu_pw = $_POST['pw'];
		$trans_in = $_POST['login'];
		$trans_out = $_POST['logout'];
		$this->auth();
	}
	public function auth() {
		$this->findUser($this->input_user);
		$this->comparePass($this->input_pw, $pw);
		$this->set_vars();
	}
	
	public function hasPower($power) {
		if ($this->user['role'] >= $power) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	private function findUser ($name){
		if (isset($this->trans_in)){
			$sql = "SELECT * FROM `login` WHERE `login` = '".$name."'";
			$db_erg = mysqli_query( $db_link, $sql );
			while ($daten = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
			{
				$pw = $daten['pw'];
				$this->usr = array (
						"user" => $daten['login'],
						"user_id" => $daten['usr_id'],
						"role" => $daten['role']
				);
			}
		
		}else{
			echo 'Login nicht gesetzt';
		}
	}
	private function comparePass ($pw_set, $pw_db){
		$hash = hash(md5, $this->input_pw);
		if ($pw == $hash)
		{
			$this->valid_user = 1;
			unset ($this->pw);
		}
	}
	
	private function set_vars (){
		global $valid_login, $user, $role, $user_id;
		if ($this->valid_user == 1)
		{
			$valid_login= $this->valid_user;
			$_SESSION['user_login'] = $this->valid_user;
			foreach ($this->usr as $k => $v)
			$_SESSION["$k"] = $v;
			$$k = $v;
		}
		$sql = "SELECT * FROM `member` WHERE usr_id = '".$user['user_id']."'";
		$db_erg = mysqli_query( $db_link, $sql );
		//if ( ! $db_erg ) {('Ung&uuml;ltige Login-Abfrage2: ' .mysqli_errno($db_link));}
		while ($daten = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
		{
			foreach ($daten as $k => $v)
			{
				if ($k !== "id" && $k !== "usr_id")
				{
					$this->usr = array ( "$k" => "$v");
				}
			}
		}
		
	}
	
	public function logout() {
		if ($_POST['logout'] == 'logout'){
			session_destroy();
			unset ($valid_login, $user, $role, $user_id);
		}
	}
	
}

class auth_shows {
	
	public function show_logout () 
	{
		if ($valid_login == 1)
		{
			echo '<form action="'.$this->action.'" method="post">';
			echo '<input type="Submit" style="background-color:lightgreen" name="logout" value="logout" />';
			echo '</form>';
		}
	}

	public function show_login () 
	{
		if ($valid_login !== 1)
		{
			echo '<form action="?site=profil" method="post">';
			echo '<table width="100px"><tr><th>Benutzername</th></tr>';
			echo '<tr><td><input type="text" name="user" placeholder="Benutzername" required /></td></tr>';
			echo '<tr><th>Passwort</th></tr>';
			echo '<tr><td><input type="password" name="pw" placeholder="Passwort" required /></td></tr></table>';
			echo '<input type="Submit" style="background-color:lightgreen" name="login" value="login" />';
			echo '</form>';
		}
	}

	public function show_greetings ()
	{
		if ($valid_login == 1)
		{
			echo 'Hallo '.$user;
		}
	}
}
?>