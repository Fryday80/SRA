<?php
if (basename($_SERVER['SCRIPT_FILENAME']) === 'functions.inc.php'){exit('This page may not be called directly !'); }

/**
 * Zeigt Bugfix, je nach Level
 * @param string $comment Anzeigestring
 * @param integer $level des debugs
 */

function bugfix ($comment = 'here', $level=1){
	$debug_level = 'bugfix_level'.$level;
	if ($GLOBALS["$debug_level"] == 'on'){
		if (is_array($comment)){
			echo 'bugfix with array:';
			pre_on();
			print_r ($comment);
			pre_off();
		}elseif (is_object($comment)){
			echo 'Bugfix with object';
			pre_on();var_dump($comment);pre_off();
		}else {
			echo 'bugfix ' . $comment . ' @ ';
			br();
		}
	}
}

function pre_on () {
	echo '<pre>';
}

function pre_off ()
{
	echo '</pre>';
}

function bugfix_expression ($expression = 'br(2);'){
	if ($GLOBALS['bugfix'] == 'on'){
		return $expression;
	}
}

function jetzt () {

	global $date, $dateTimestamp, $day, $month, $year;
	date_default_timezone_set('Europe/Berlin');
	$date = date('d-m-Y H:i:s');
	$dateTimestamp = strtotime($date);
	$explode = explode(" ", $date);
	$explosion = explode("-", $explode[0]);
	$day = $explosion[0];
	$month = $explosion[1];
	$year = $explosion[2];
}

function get_plugin_css (){
	$handle = opendir('./module/');
	while (($file = readdir($handle)) !== false)
	{
		if ($file !== "." && $file !== ".." && $file !== "zzznew")
		{
			if (file_exists('./module/'.$file.'/'.$file.'.cs.css')){
				echo '<link href="./module/'.$file.'/'.$file.'.cs.css" rel="stylesheet" type="text/css">';
			}
			
		}
	}
	closedir($handle);
}

function get_plugin_files (){
	global $plugins;
	$handle = opendir('./module/');
	$inc = 0;
	while (($file = readdir($handle)) !== false)
	{
		if ($file != "." && $file != ".." && $file != "zzznew")
		{
			$plugins[$inc]= $file;
			$inc++;
		}
	}
	closedir($handle);
}

function get_html_files (){
	global $contents;
	$handle = opendir('./html/');
	$inc = 0;
	while (($file = readdir($handle)) !== false)
	{
		if ($file !== "." && $file !== "..")
		{
			$contents[$inc]= $file;
			$inc++;
		}
	}
	closedir($handle);
}


function br ($br=1)
{
	if (isset ($br)){
		for ($i = 1; $i <= $br; $i++){
			echo '<br>';
		}
	}else {
		echo '<br>';
	}
}

