<?php
function searchAccPlayer($key,$type,$rawdata,$number=false)
  {
// Text - Translation
// ##################

require("translation.php");

// ##################


if($rawdata == "xml") { $rawdata = "html"; $xml = true; }


// Weltdaten bekommen
require("include/getTableNames.php");

if ($type == 'ByPlayerName')
  {
  $key  = urlencode($key);
  $abfrage = "SELECT * FROM $playertable WHERE name LIKE '".$key."'";
  }
elseif ($type == 'ByPlayerId')
  {
  $abfrage = "SELECT * FROM $playertable WHERE id LIKE '".$key."'";
  }



  $ergebnis = mysql_query($abfrage);
  $row = mysql_fetch_object($ergebnis);

    $playerId = $row->id;

if($row->id=="")
  {
  $noresult=1;;
  return array("noResult" => $noResult);
  }
else
  {



    if ($rawdata == 'raw') { $playerName = $row->name; } elseif ($rawdata == 'html') { $playerName = urldecode($row->name); }; // $playerName

    $playerVillages = $row->villages;

    $playerPoints = $row->points;


    $playerRanking = $row->rank;

    $allyId = $row->ally;


 // Profil über ID [$playerId] bekommen


  $abfragep = "SELECT * FROM $profiletable WHERE id LIKE '".$playerId."'";
  $ergebnisp = mysql_query($abfragep);
  $rowp = mysql_fetch_object($ergebnisp);


    if ($rawdata == 'raw') {
           $playerBirthday = $rowp->birthday;
         }
    elseif ($rawdata == 'html') {
           if($rowp->birthday == "0000-00-00") {
             $playerBirthday = $text['unknown'];
             }
           else {
             $tempBirthday = $rowp->birthday;
             list($year, $month, $day) = explode("-",$tempBirthday);
             $playerBirthday = $day." ".$text['monthsname'][$month]." ".$year;
             }
         }

    if ($rawdata == 'raw') {
           $playerSex = $rowp->sex;
         }
    elseif ($rawdata == 'html')
         { if($rowp->sex == 'f') { $playerSex = $text['female']; }
           elseif($rowp->sex == 'm') { $playerSex = $text['male']; }
           elseif($rowp->sex == '') { $playerSex = $text['unknown']; }
         }


    if ($rawdata == 'raw') { $playerLocation = $rowp->location; }
    elseif ($rawdata == 'html' and $rowp->location != "") { $playerLocation = htmlentities(urldecode($rowp->location)); }
    elseif ($rawdata == 'html' and $rowp->location == "") { $playerLocation = $text['unknown']; }


// Basher Data bekommen
  // All
  $abfrageall = "SELECT * FROM $killalltable WHERE id LIKE '".$playerId."'";
  $ergebnisall = mysql_query($abfrageall);
  $rowall = mysql_fetch_object($ergebnisall);

  $playerKillAll = $rowall->allkills;
  $playerKillAllRank = $rowall->rank;

  // Attack
  $abfrageatt = "SELECT * FROM $killatttable WHERE id LIKE '".$playerId."'";
  $ergebnisatt = mysql_query($abfrageatt);
  $rowatt = mysql_fetch_object($ergebnisatt);

  $playerKillAtt = $rowatt->attkills;
  $playerKillAttRank = $rowatt->rank;

  // Defensive
  $abfragedef = "SELECT * FROM $killdeftable WHERE id LIKE '".$playerId."'";
  $ergebnisdef = mysql_query($abfragedef);
  $rowdef = mysql_fetch_object($ergebnisdef);

  $playerKillDef = $rowdef->defkills;
  $playerKillDefRank = $rowdef->rank;




// Stamm über StammID [$allyId] bekommen


$ab = "SELECT * FROM $allytable WHERE id LIKE $allyId";
$er = mysql_query($ab);
$ro = mysql_fetch_object($er);

    if ($rawdata == 'raw') { $allyName = $ro->tag.",".$roname; }
    elseif ($rawdata == 'html') { $allyName = htmlentities(urldecode($ro->tag))." (".htmlentities(urldecode($ro->name)).")"; }

    if ($rawdata == 'raw') { $allyTag = $ro->tag; }
    elseif ($rawdata == 'html') { $allyTag = htmlentities(urldecode($ro->tag)); }

    if ($rawdata == 'raw') { $allyFullname = $ro->name; }
    elseif ($rawdata == 'html') { $allyFullname = htmlentities(urldecode($ro->name)); }

    $allyId = $ro->id;

    if ($rawdata == 'raw') { $allyPoints = $ro->points.",".$ro->all_points; }
    elseif ($rawdata == 'html') { $allyPoints = number_format($ro->points)." (".$text['totalPoints'].number_format($ro->all_points).")"; }

    $allyMembers = $ro->members;

    $allyRank = $ro->rank;






/* Return der Daten per Ausgabe über XML, mit den Werten
   playerId,playerName,playerVillages,playerPoints,
   playerRanking,playerBirthday,playerSex,playerLocation,
   allyYes,allyName,allyId,allyPoints,allyMembers,allyRank
*/
if($xml)
  {
  echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
  echo "<tw>\n";
  echo "<player>\n";
  echo "    <id>".$playerId."</id>\n";
  echo "    <name>".$playerName."</name>\n";
  echo "    <villages>".$playerVillages."</villages>\n";
  echo "    <points>".$playerPoints."</points>\n";
  echo "    <rank>".$playerRanking."</rank>\n";
  echo "    <birth>".$playerBirthday."</birth>\n";
  echo "    <sex>".$playerSex."</sex>\n";
  echo "    <location>".$playerLocation."</location>\n";
  echo "</player>\n";
  echo "<tribe>\n";
  echo "    <id>".$allyId."</id>\n";
  echo "    <name>".$allyName."</name>\n";
  echo "    <points>".$ro->points."</points>\n";
  echo "    <allpoints>".$ro->all_points."</allpoints>\n";
  echo "    <members>".$allyMembers."</members>\n";
  echo "    <rank>".$allyRank."</rank>\n";
  echo "</tribe>\n";
  echo "</tw>\n";
  return true;
  }



/* Return der Daten in einem Array, mit den Werten
   playerId,playerName,playerVillages,playerPoints,
   playerRanking,playerBirthday,playerSex,playerLocation,
   allyYes,allyName,allyId,allyPoints,allyMembers,allyRank
*/

    return array("playerId" => $playerId,
                 "playerName" => $playerName,
                 "playerVillages" => $playerVillages,
                 "playerPoints" => $playerPoints,
                 "playerRanking" => $playerRanking,
                 "playerBirthday" => $playerBirthday,
                 "playerSex" => $playerSex,
                 "playerLocation" => $playerLocation,
                 "playerAllKills" => $playerKillAll,
                 "playerAllRank" => $playerKillAllRank,
                 "playerAttKills" => $playerKillAtt,
                 "playerAttRank" => $playerKillAttRank,
                 "playerDefKills" => $playerKillDef,
                 "playerDefRank" => $playerKillDefRank,
                 "allyName" => $allyName,
                 "allyTag" => $allyTag,
                 "allyFullname" => $allyFullname,
                 "allyId" => $allyId,
                 "allyPoints" => $allyPoints,
                 "allyMembers" => $allyMembers,
                 "allyRank" => $allyRank,
                 "noResult" => "false");


}
}
?>