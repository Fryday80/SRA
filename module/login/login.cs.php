<?php
if (basename($_SERVER['SCRIPT_FILENAME']) === 'login.cs.php'){exit('This page may not be called directly !'); }


//userDataGrabber ist ja eine art data grabber und deshalb lasen wir ihn von dem erben


class authentication{
	protected $input_user, $input_pw, $trans_in, $trans_out, $pw, $no_change, $user_intern, $dataGrabber;
	public $usr = array ();
	public $valid_user, $db_link;
	
	public function __construct($db_link)
	{
		if (isset ($_POST['user'])){$this->input_user = $_POST['user'];}
		if (isset ($_POST['pw'])){$this->input_pw = $_POST['pw'];}
		if (isset ($_POST['login'])){$this->trans_in = $_POST['login'];} //hier ist quasi der check ob login oder logout gedrückt wird wie wird die im form gesetzt
		if (isset ($_POST['logout'])){$this->trans_out = $_POST['logout'];}
		if (!isset ($_POST['login']) OR !isset ($_POST['logout'])){$this->no_change = 1;}
// 		if (isset ($logindata)) {$this->dataGrabber = $logindata;}
		$this->db_link = $db_link;
// 		print_r($_POST);
		$this->auth();
	}
	public function auth() {
		//später
// 		echo $this->input_user;
		$this->findUser("$this->input_user");
		$this->comparePass($this->input_pw, $this->user_intern->pw);
 		$this->set_vars();
		//hier mal ausgeben was sache ist
		print_r ("#######");
	}
	
	public function hasPower($power) {
		if ($this->user['role'] >= $power) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
	private function findUser ($name){
		// mir fält gerade auf, das wird nur ausgeführt, wenn man login drückt... das muss ja immer ausgeführt werden
		//if (isset($this->trans_in)){
			$this->dataGrabber = new UserDataGrabber($this->db_link);
			$this->user_intern = $this->dataGrabber->getByName("$name");
// 			print_r($this->user_intern->pw);
			
			
		//}else{
		//	echo 'Login nicht gesetzt';
		//}
	}
	private function comparePass ($pw_set, $pw_db){
		$hash = md5($pw_set);

		if ($pw_db == $hash)
		{
			print_r("pass correct \n");
			$this->valid_user = 1;
// 			unset ($this->user_intern['pw']);
		}
	}
	
	private function set_vars (){
// 		global $valid_login, $user, $role, $user_id;
		if ($this->valid_user == 1)
		{
			echo 'success<br>';
			$_SESSION['user_login'] = $this->valid_user;			
			foreach ($this->user_intern as $k => $v){
			$_SESSION["$k"] = $v;
			}
// 			$$k = $v; //hier sllte ja $user gesetzt werden
		}
		/*
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
		} */
		
	}
	
	public function logout() {
		if ($_POST['logout'] == 'logout'){
			session_destroy();
			unset ($valid_login, $user, $role, $user_id);
		}
	}
	
}

class auth_shows {
	
	public function show_logout ($auth_object) 
	{
		if ($_SESSION['user_login'] == 1)
		{
			echo '<form action="'.$this->action.'" method="post">';
			echo '<input type="Submit" style="background-color:lightgreen" name="logout" value="logout" />';
			echo '</form>';
		}
	}

	public function show_login ($auth_object) 
	{
		if ($_SESSION['user_login'] !== 1)
		{
			echo '<form action="?site=profil" method="post">';
			echo '<table width="100px"><tr><th>Benutzername</th></tr>';
			echo '<tr><td><input type="text" name="user" placeholder="Benutzername" required /></td></tr>';
			echo '<tr><th>Passwort</th></tr>';
			echo '<tr><td><input type="password" name="pw" placeholder="Passwort" required /></td></tr></table>';
			echo '<input type="hidden" name="login" value="login"></input><input type="Submit" style="background-color:lightgreen" value="login" />';
			echo '</form>'; // ah verstehe aber warum das ? weil sich type submit dabei komisch verhält ... hatte ich auch mal aber kann mich nichmehr genau errinern okprobiers
		}
	}

	public function show_greetings ($auth_object)
	{
		if ($_SESSION['user_login'] == 1)
		{
			echo 'Hallo '.$_SESSION['login'];
		}
	}
}
?>