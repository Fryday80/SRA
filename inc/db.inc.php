<?php
if (basename($_SERVER['SCRIPT_FILENAME']) === 'db.inc.php'){exit('This page may not be called directly !'); }

// die Konstanten auslagern in eigene Datei
// die dann per require_once ('db.inc.php'); 
// geladen wird.
 
// Damit alle Fehler angezeigt werden
error_reporting(E_ALL);
 
// Zum Aufbau der Verbindung zur Datenbank
// die Daten erhalten Sie von Ihrem Provider
// define ( 'MYSQL_HOST', 'rdbms.strato.de' );
define ( 'MYSQL_HOST', '127.0.0.1' );
define ('MYSQL_PORT', '3307');
 
// bei XAMPP ist der MYSQL_Benutzer: root
// define ( 'MYSQL_BENUTZER',  'U2531041' );
// define ( 'MYSQL_KENNWORT',  'memberSRA2016' );
define ( 'MYSQL_BENUTZER',  'root' );
define ( 'MYSQL_KENNWORT',  'usbw' );

// für unser Bsp. nennen wir die DB adressverwaltung
define ( 'MYSQL_DATENBANK', 'DB2531041' );

/*
define ( 'MYSQL_HOSTA', 'rdbms.strato.de');      // Server
define ( 'MYSQL_BENUTZERA', 'U2452621');        // User
define ( 'MYSQL_KENNWORTA', 'dbsra2016');    // Password
define ( 'MYSQL_DATENBANKA', 'DB2452621');
*/
?>

