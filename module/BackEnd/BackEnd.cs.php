<?php 
if (basename($_SERVER['SCRIPT_FILENAME']) === 'BackEnd.cs.php'){exit('This page may not be called directly !'); }

/************************************
 *  Classes 						*
 ************************************/

class menu{

	function show ()
	{
		$menuitems =  array("Navigation", "Module", "css");
		foreach ($menuitems as $k=>$v){
			echo '<form action="'.$target.'" method="POST">';
			echo '<input type="submit" name="selector" value="'.$v.'" />';
			echo '</form>';
		}
	}
}
?>