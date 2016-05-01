<?php
if (basename($_SERVER['SCRIPT_FILENAME']) === 'module.inc.php'){exit('This page may not be called directly !'); }

$handle = opendir('module/');
	while (($file = readdir($handle)) !== false)
	{
		if ($file != "." && $file != ".." && $file !== 'zzznew')
		{
			include ('module/'.$file.'/'.$file.'.cs.php');
		}
	}
	closedir($handle);