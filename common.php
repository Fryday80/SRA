<?php
include_once 'all.inc.php';



DataAccessObject::initDB();

jetzt ();
$auth = new authentication();

$nav= new NavigationDAO();
$nav = $nav->getNavigation();

$memnav = new MembersNavigationDAO();
$memnav = $memnav->getNavigation();

$show_navi = new nav_show($nav, $memnav);