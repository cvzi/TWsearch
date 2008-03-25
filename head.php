<?php
// Zeit für die Aufbauzeit speichern
$time_start = microtime(true);
// ############################

// Array für Debug erstellen
$debug = array();
#$debugmode = true;

// Statistik
$debug['ReqStats'] = require("include/function.stats.php");

// Eigener Dateiname für Formulare
if(isset($debugmode)) { $selffile = $_SERVER['PHP_SELF']."?debugmode"; }
else { $selffile = $_SERVER['PHP_SELF']; }
$debug['selffile'] = $selffile;

// HTML ein? (Für diverse Funktionen nötig)
$rawShifter = 'html';

// Text - Translation
// ##################

$debug['ReqTranslation'] = require("translation.php");

// Number Format
// #############
require("include/function.wash_number.php");

// Verbinden mit MySQL
require("include/mysql.php");

// Tabellennamen
require("include/getTableNames.php");
?>