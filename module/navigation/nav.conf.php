<?php
$site = $_GET['site'];
switch ($site)
{
	case 'login':
	case 'logout':
		$path = 'module/login/';
		break;
	default:
		$path = 'html/content/';
		break;
}
include ($path.$site.'.php');
?>