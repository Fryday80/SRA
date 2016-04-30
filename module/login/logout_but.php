<?php 
if (basename($_SERVER['SCRIPT_FILENAME']) === 'logout.php'){exit('This page may not be called directly !'); }

echo '<form action="?site=logout" method="post">';
echo '<input type="Submit" style="background-color:lightgreen" name="logout" value="logout" />';
echo '</form>';

?>