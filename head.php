<?php
// Zeit f�r die Aufbauzeit speichern
$time_start = microtime(true);
// ############################

// Array f�r Debug erstellen
$debug = array();
#$debugmode = true;

// Statistik
$debug['ReqStats'] = require("include/function.stats.php");

// Eigener Dateiname f�r Formulare
if(isset($debugmode)) { $selffile = $_SERVER['PHP_SELF']."?debugmode"; }
else { $selffile = $_SERVER['PHP_SELF']; }
$debug['selffile'] = $selffile;

// HTML ein? (F�r diverse Funktionen n�tig)
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