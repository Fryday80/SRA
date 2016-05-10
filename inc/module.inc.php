<?php
if (basename($_SERVER['SCRIPT_FILENAME']) === 'module.inc.php'){exit('This page may not be called directly !'); }

$handle = opendir('module/');
while (($file = readdir($handle)) !== false) {
	if ($file != "." && $file != "..") {
		$path = 'module/' . $file . '/' . $file . '.cs.php';
		if (file_exists($path))
			include($path);
	}
}

closedir($handle);