<?php
if (basename($_SERVER['SCRIPT_FILENAME']) === 'login.cs.php'){exit('This page may not be called directly !'); }


//userDataGrabber ist ja eine art data grabber und deshalb lasen wir ihn von dem erben


class authentication{
	protected $input_user, $input_pw, $trans_in, $trans_out, $pw;
	public $usr = array ();
	public $valid_user, $user, $role, $usr_id;
	
	public function __construct()
	{
		if (isset ($_POST)) {
			if (isset($_POST['login'])) {
				$this->input_user = $_POST['user'];
				$this->input_pw = $_POST['pw'];
				$this->trans_in = $_POST['login'];
				$this->auth();
				bugfix('hallllllooo');
			}
			if (isset($_POST['logout'])) {
				$this->trans_out = $_POST['logout'];
				$this->logout();
			}
		}
	}
	protected function auth() {
		$this->findUser($this->input_user);
		$this->comparePass($_POST['pw'], $this->pw);
		$this->set_vars();

	}

	protected function findUser ($name){
		$userDAO = new UserDAO();
		$userVO = $userDAO->getByName($name);
		if ($userVO) {
			foreach ($userVO as $k => $v){
				foreach ($v as $k2 => $v2) {
					if ($k2 == 'pw'){$this->pw = $v2;}
					if ($k2 == 'login'){$this->user = $v2;}
					if ($k2 == 'role'){$this->role = $v2;}
					if ($k2 == 'usr_id'){$this->usr_id = $v2;}
				}
			}

		} else {
			//@todo name not found
		}
	}
	protected function comparePass ($pw_set, $pw_db){
		$hash = hash('md5', $pw_set);
		if ($pw_db == $hash)
		{
			bugfix("pass correct \n");
			$this->valid_user = 1;
		}
	}
	
	protected function set_vars (){

		if ($this->valid_user == 1) {
			$_SESSION['valid_login'] = $this->valid_user;
			$_SESSION['user'] = $this->user;
			$_SESSION['user_role'] = $this->role;
			$_SESSION['usr_id'] = $this->usr_id;
		}
	}
	
	protected function logout() {
		if ($_POST['logout'] == 'logout'){
			$_SESSION['valid_login']=false;
			session_destroy();
			unset ($valid_login, $user, $role, $user_id);
		}
	}
	
}

class auth_shows {
	protected $authentication_object, $valid_login;


	function __construct($auth_object)
	{
		$this->authentication_object = $auth_object;
		if (isset($_SESSION['valid_login'])) {$this->valid_login = $_SESSION['valid_login'];}
		else {$this->valid_login = false;}
	}

	public function show_logout ()
	{
		if ($this->valid_login == 1)
		{
			echo '<form action="'.$_SERVER['PHP_SELF'].'" method="post">';
			echo '<input type="hidden" name="logout" value="logout">';
			echo '<input type="Submit" style="background-color:lightgreen" value="logout" />';
			echo '</form>';
		}
	}

	public function show_login ()
	{
		if ($this->valid_login !== 1) {
			echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">';
			echo '<table width="100px"><tr><th>Benutzername</th></tr>';
			echo '<tr><td><input style="width:123px;" type="text" name="user" placeholder="Benutzername" required /></td></tr>';
			echo '<tr><th>Passwort</th></tr>';
			echo '<tr><td><input style="width:123px;" type="password" name="pw" placeholder="Passwort" required /></td></tr></table>';
			echo '<input type="hidden" name="login" value="login">';
			echo '<input type="Submit" style="background-color:lightgreen" value="login" />';
			echo '</form>';
		}
	}

	public function show_greetings ()
	{
		if ($this->valid_login == 1)
		{
			echo 'Hallo '.$_SESSION['user'];
		}
	}
}
?>