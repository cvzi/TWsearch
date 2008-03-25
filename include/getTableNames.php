<?php
$settingstable = $text['setting_mysqlTabelPrefix']."_settings";
  $abfrage = "SELECT * FROM $settingstable";
  $ergebnis = mysql_query($abfrage);
$row = mysql_fetch_object($ergebnis);

$worldname = $row->worldname;
$worldtoken = $row->worldtoken;
$urltoken = $row->worldurltoken;

$playertable = $worldtoken."_player";
$profiletable = $worldtoken."_profile";
$villagetable = $worldtoken."_village";
$allytable = $worldtoken."_ally";
$conquertable = $worldtoken."_conquer";
$killalltable = $worldtoken."_killall";
$killatttable = $worldtoken."_killatt";
$killdeftable = $worldtoken."_killdef";
?>