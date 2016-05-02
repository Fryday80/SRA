<?php
if (basename($_SERVER['SCRIPT_FILENAME']) === 'all.inc.php'){exit('This page may not be called directly !'); }
//sers new auth
include_once 'inc/functions.inc.php';
//include_once 'inc/db.connect.php';
require_once ('inc/db.inc.php');
include_once 'inc/module.inc.php';