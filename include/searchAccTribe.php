<?php
function searchAccTribe($key,$type)
  {
// Text - Translation
// ##################

require("translation.php");

// ##################


if($rawdata == "xml") { $rawdata = "html"; $xml = true; }


// Weltdaten bekommen
require("include/getTableNames.php");

if($type == "id")
  {
  $abfrage = "SELECT * FROM `".$allytable."` WHERE `id` LIKE '".$key."'";
  }
elseif ($type == "tribe")
  {
  $key = urlencode($key);
  $abfrage = "SELECT * FROM `".$allytable."` WHERE `name` LIKE '".$key."' OR `tag` LIKE '".$key."'";
  }
$ergebnis = mysql_query($abfrage);
$row = mysql_fetch_object($ergebnis);

if($row->id == "")
  {
  return array("noResult" => true);
  }
else
  {
  $allyId = $row->id;

  $allyName = htmlentities(urldecode($row->name));

  $allyTag = htmlentities(urldecode($row->tag));

  $allyMembers = $row->members;

  $allyVillages = $row->villages;

  $allyPoints = $row->points;

  $allyAll_points = $row->all_points;

  $allyRanking = $row->rank;

// Finde Spieler heraus ID und Name

  $playerabfrage = "SELECT `id`,`name`,`points` FROM `".$playertable."` WHERE `ally` LIKE '".$allyId."' ORDER BY `points` DESC LIMIT 0 , ".$allyMembers;
  $playerergebnis = mysql_query($playerabfrage);
  $allyMembernames = array();
  $i = 0;
  while($playerrow = mysql_fetch_object($playerergebnis))
    {
    $allyMembernames[$i] = array();
    $allyMembernames[$i]['id'] = $playerrow->id;
    $allyMembernames[$i]['name'] = htmlentities(urldecode($playerrow->name));
    $allyMembernames[$i]['points'] = $playerrow->points;        
    $i++;
    }



  return array("allyId" => $allyId,
	      "allyName" => $allyName,
               "allyTag" => $allyTag,
               "allyMembers" => $allyMembers,
               "allyVillages" => $allyVillages,
               "allyPoints" => $allyPoints,
               "allyAll_points" => $allyAll_points,
               "allyRank" => $allyRanking,
               "allyMembernames" => $allyMembernames,
               "noResult" => false);


  }
}
?>