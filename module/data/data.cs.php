<?php
define("DATA_MOCKING", true);
define("LOGIN_MOCKING", true);
$path = 'module/data/';
$classExtention = '.cs.php';
$classArray = array ("UserDAO", "RolesDAO", "MembersDAO", "MembersDAO");

foreach ($classArray as $key => $classtype){
    include_once $path.$classtype.$classExtention;
}


//UserDAO::init();