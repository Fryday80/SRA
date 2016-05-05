<?php
if (basename($_SERVER['SCRIPT_FILENAME']) === 'login.cs.php'){exit('This page may not be called directly !'); }


//userDataGrabber ist ja eine art data grabber und deshalb lasen wir ihn von dem erben


class authentication{
	protected $input_user, $input_pw, $trans_in, $trans_out, $pw;
	public $usr = array ();
	public $valid_user;
	
	public function __construct()
	{
		if (isset ($_POST)) {
			if (isset($_POST['login'])) {
				$this->input_user = $_POST['user'];
				$this->input_pw = $_POST['pw'];
				$this->trans_in = $_POST['login'];
				$this->auth();
				print_r('hallllllooo');
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
		print_r ($userVO);
		if ($userVO) {
			$this->pw = $userVO->pw;
			$this->usr = $userVO;
		} else {
			//@todo name not found
		}
	}
	protected function comparePass ($pw_set, $pw_db){
		$hash = hash('md5', $pw_set);
		if ($pw_db == $hash)
		{
			print_r("pass correct \n");
			$this->valid_user = 1;
		}
	}
	
	protected function set_vars (){

		if ($this->valid_user == 1) {
			$_SESSION['valid_login'] = $this->valid_user;
			foreach ($this->usr as $k => $v)
				$_SESSION["$k"] = $v;
		}
	}
	
	protected function logout() {
		if ($_POST['logout'] == 'logout'){
			session_destroy();
			unset ($valid_login, $user, $role, $user_id);
		}
	}
	
}

class auth_shows {
	
	public function show_logout ($auth_object) 
	{
		if ($_SESSION['valid_login'] == 1)
		{
			echo '<form action="'.$_SERVER['PHP_SELF'].'" method="post">';
			echo '<input type="Submit" style="background-color:lightgreen" name="logout" value="logout" />';
			echo '</form>';
		}
	}

	public function show_login ($auth_object) 
	{
		if ($_SESSION['valid_login'] !== 1) {
			echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">';
			echo '<table width="100px"><tr><th>Benutzername</th></tr>';
			echo '<tr><td><input type="text" name="user" placeholder="Benutzername" required /></td></tr>';
			echo '<tr><th>Passwort</th></tr>';
			echo '<tr><td><input type="password" name="pw" placeholder="Passwort" required /></td></tr></table>';
			echo '<input type="hidden" name="login" value="login"><input type="Submit" style="background-color:lightgreen" value="login" />';
			echo '</form>';
		}
	}

	public function show_greetings ($auth_object)
	{
		if ($_SESSION['valid_login'] == 1)
		{
			echo 'Hallo '.$_SESSION['login'];
		}
	}
}
?>