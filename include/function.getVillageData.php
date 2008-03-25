<?php
function getVillageData($key,$villagenumber,$rawdata)
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

$playerArray = array();
  $keythree  = urlencode($keythree);

$abfragep =  "SELECT * FROM `".$villagetable."` WHERE `player` LIKE '".$key."' ORDER BY `name` ASC LIMIT 0 , ".$villagenumber;

$ergebnisp = mysql_query($abfragep);
$i = 0;
while($rowp = mysql_fetch_object($ergebnisp))
{
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

$villagePoints = $rowp->points;

$playerArray[$i] = array("villageID" => $villageID,
                 "villageName" => $villageName,
                 "villageX" => $villageX,
                 "villageY" => $villageY,
                 "villagePoints" => $villagePoints);
$i++;
}



if($xml)
  {
  echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
  echo "<".$key.">\n";

  foreach($playerArray as $line)
    {
    echo "  <".$line['villageID'].">\n";
    echo "    <name>".$line['villageName']."</name>\n";
    echo "    <x>".$line['villageX']."</x>\n";
    echo "    <y>".$line['villageY']."</y>\n";
    echo "    <points>".$line['villagePoints']."</points>\n";
    echo "  </".$line['villageID'].">\n";
    }

  echo "</".$key.">\n";
  return true;
  }




return $playerArray;
}
?>