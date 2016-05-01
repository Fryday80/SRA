<div>
<?php
$navigation = new navigation($db_link);
$show_navi = new nav_show();

$show_navi->show_main($navigation);
?>
</div>
<div class="black_deko">
</div>
<div>
<?php 
$auth_show = new auth_shows($auth);
$auth_show->show_greetings($auth);
$auth_show->show_login($auth);

// print_r ($auth->valid_user);
// echo 'valid<br>';
// print_r ($_SESSION);
// echo 'ses<br>';
$show_navi->show_mem($navigation, $_SESSION['role']);
br(1);

$auth_show->show_logout();
print_r ($user);
?>
</div>