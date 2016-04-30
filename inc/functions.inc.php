<?php
if (basename($_SERVER['SCRIPT_FILENAME']) === 'functions.inc.php'){exit('This page may not be called directly !'); }

function jetzt () {

	global $date, $dateTimestamp, $day, $month, $year;
	
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


function br ($br)
{
	if (isset ($br)){
		for ($i = 1; $i <= $br; $i++){
			echo '<br>';
		}
	}else {
		echo '<br>';
	}
}

