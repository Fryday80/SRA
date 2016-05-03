<?php
define("DATA_MOCKING", true);
$path = 'module/data/';
include $path.'DataAccessObject.cs.php';
include $path.'UserDAO.cs.php';
include $path.'RolesDAO';
include $path.'MembersDAO';
include $path.'WappenDAO';

DataGrabber::init();