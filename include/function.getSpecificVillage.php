<?php
function getSpecificVillage($key,$searchtype,$rawdata)
  {
// Text - Translation
// ##################

require("translation.php");

if($rawdata == "xml") { $rawdata = "html"; $xml = true; }


// Weltdaten bekommen
$settingstable = "tw5_settings";
  $abfrage = "SELECT * FROM $settingstable";
  $ergebnis = mysql_query($abfrage);
$row = mysql_fetch_object($ergebnis);

$worldname = $row->worldname;
$worldtoken = $row->worldtoken;
$urltoken = $row->worldurltoken;

$villagetable = $worldtoken."_village";
$playertable = $worldtoken."_player";
$conquertable = $worldtoken."_conquer";

$playerArray = array();

if($searchtype == "coords")
  {
  $key = explode("|",$key);
  $key = str_replace("(","",$key);
  $key = str_replace(")","",$key);
  $abfragep = "SELECT * FROM `".$villagetable."` WHERE `x` LIKE '".$key[0]."' HAVING `y` LIKE '".$key[1]."' LIMIT 0 , 1";
  }

$ergebnisp = mysql_query($abfragep);

$rowp = mysql_fetch_object($ergebnisp);

if($rowp->id)
  {
  $noResult = false;
  }
else
  {
  $noResult = true;
  }

$villageID = $rowp->id;

if($rawdata == 'raw')
  {
  $villageName = $rowp->name;
  }
elseif($rawdata == 'html')
  {
  $villageName = htmlentities(urldecode($rowp->name));
  }

$villageX = $rowp->x;

$villageY = $rowp->y;

$villagePlayer = $rowp->player;

$villagePoints = $rowp->points;

// Hole Spielername

$villagePlayerName = getPlayerById($villagePlayer,$rawdata);


// Hole Adelungen


$abfrage = "SELECT * FROM $conquertable WHERE id LIKE '".$villageID."' ORDER BY `timestamp` ASC";
$ergebnis = mysql_query($abfrage);

$i = 0;
while($row = mysql_fetch_object($ergebnis))
  {
  $conquer[$i]['timestamp'] = $row->timestamp;
  $conquer[$i]['oldPlayer'] = $row->old;
  $conquer[$i]['newPlayer'] = $row->new;
  $conquer[$i]['oldPlayerName'] = getPlayerById($row->old,$rawdata);
  $conquer[$i]['newPlayerName'] = getPlayerById($row->new,$rawdata);

  $i++;
  }


$playerArray = array("villageID" => $villageID,
                 "villageName" => $villageName,
                 "villageX" => $villageX,
                 "villageY" => $villageY,
                 "villagePlayer" => $villagePlayer,
                 "villagePlayerName" => $villagePlayerName,
                 "villagePoints" => $villagePoints,
                 "conquer" => $conquer,
                 "noResult" => $noResult);


if(isset($xml) and $xml)
  {
  echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
    echo "  <".$villageID.">\n";
    echo "    <name>".$villageName."</name>\n";
    echo "    <x>".$villageX."</x>\n";
    echo "    <y>".$villageY."</y>\n";
    echo "    <points>".$villagePoints."</points>\n";
    echo "    <player>".$villagePlayerName."</player>\n";
    echo "    <playerid>".$villagePlayer."</playerid>\n";
    echo "  </".$villageID.">\n";
  return true;
  }




return $playerArray;
}


function getPlayerById($key,$rawdata)
  {
  // Weltdaten bekommen
  $settingstable = "tw5_settings";
  $abfrage = "SELECT * FROM $settingstable";
  $ergebnis = mysql_query($abfrage);
  $row = mysql_fetch_object($ergebnis);

  $worldname = $row->worldname;
  $worldtoken = $row->worldtoken;
  $urltoken = $row->worldurltoken;
  $playertable = $worldtoken."_player";


  // Hole Spielername
  if($key == "0")
    {
    $name = "-aband";
    }
  else
    {
    $abfrage = "SELECT * FROM $playertable WHERE id LIKE '".$key."'";
    $ergebnis = mysql_query($abfrage);
    $row = mysql_fetch_object($ergebnis);
    if($row->name != "")
      {
      if($rawdata == 'raw')
        {
        $name = $row->name;
        }
      elseif($rawdata == 'html')
        {
        $name = urldecode($row->name);
        }
      }
    else
      {
      $name = "-del";
      }
    }
  return $name;
  }

#mysql_error();
?>