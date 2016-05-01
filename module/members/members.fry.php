<?php
$mem_back = new memberBackend($db_link);

foreach ($mem_back->members as $key){
	echo $mem_back->members->$key.'  1.key <br>';
// 	print_r ($key);
}

?>