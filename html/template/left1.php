<div>
<?php
$navigation = new navigation();
$show_navi = new nav_show();

$show_navi->show_main($navigation);
?>
</div>
<div class="black_deko">
</div>
<div>
<?php 
$auth_show = new auth_shows();
$auth_show->show_greetings();
$auth_show->show_login();
$show_navi->show_mem($navigation, $role);
br();

$auth_show->show_logout();
?>
</div>