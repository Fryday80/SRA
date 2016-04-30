<?php
if (basename($_SERVER['SCRIPT_FILENAME']) === 'db.connect.php'){exit('This page may not be called directly !'); }

require_once ('db.inc.php');
$db_link = mysqli_connect (
                     MYSQL_HOST, 
                     MYSQL_BENUTZER, 
                     MYSQL_KENNWORT, 
                     MYSQL_DATENBANK
                    );
mysqli_set_charset($db_link, 'utf8');

if ( ! $db_link )
{
    // hier sollte dann später dem Programmierer eine
    // E-Mail mit dem Problem zukommen gelassen werden
    // die Fehlermeldung für den Programmierer sollte
    // das Problem ausgeben mit: mysql_error()
    die('keine Verbindung zur Zeit m&ouml;glich - sp&auml;ter probieren ');
}

?>