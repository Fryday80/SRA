<?php
if (basename($_SERVER['SCRIPT_FILENAME']) === 'backend.fry.php'){exit('This page may not be called directly !'); }

switch ($nav)
{
	case 'main':
		include 'module/navigation/nav.db.php';
		break;
	case 'mem':
		include 'module/navigation/memnav.db.php';
		break;
}
?>