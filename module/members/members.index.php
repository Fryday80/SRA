<?php
if (basename($_SERVER['SCRIPT_FILENAME']) === 'members.index.php'){exit('This page may not be called directly !'); }

include_once 'common.php';

bugfix('hallo');
$membermanager = new MemberManager_Views();
$membermanager->show_list('all');

?>