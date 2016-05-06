<div>
<?php


$show_navi->show_main();
?>
</div>
<div class="black_deko">
</div>
<div>
<?php 

$auth_show->show_greetings();
$auth_show->show_login();
if (isset ($_SESSION['user_role'])){ $show_navi->show_mem($_SESSION['user_role']);}
br();

$auth_show->show_logout();

?>
</div>