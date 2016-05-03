<div>
<?php


$show_navi->show_main();
?>
</div>
<div class="black_deko">
</div>
<div>
<?php 
$auth_show = new auth_shows($auth);
$auth_show->show_greetings($auth);
$auth_show->show_login($auth);
$show_navi->show_mem($navigation, $role);
br();

$auth_show->show_logout($auth);
print_r ($user);
?>
</div>