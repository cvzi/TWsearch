<?php
function searchAccPlayer($key,$type,$rawdata,$number)
  {
// Text - Translation
// ##################

require("../translation.php");

// ##################





// Weltdaten bekommen
$settingstable = "tw5_settings";
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
    elseif ($rawdata == 'html') { $playerLocation = htmlentities(urldecode($rowp->location)); }





// Stamm über StammID [$allyId] bekommen


$ab = "SELECT * FROM $allytable WHERE id LIKE $allyId";
$er = mysql_query($ab);
$ro = mysql_fetch_object($er);

    if ($rawdata == 'raw') { $allyName = $ro->tag; }
    elseif ($rawdata == 'html') { $allyName = htmlentities(urldecode($ro->tag))." (".htmlentities(urldecode($ro->name)).")"; }

    $allyId = $ro->id;

    if ($rawdata == 'raw') { $allyPoints = $ro->points.",".$ro->all_points; }
    elseif ($rawdata == 'html') { $allyPoints = $ro->points." (".$text['totalPoints'].$ro->all_points.")"; }

    $allyMembers = $ro->members;

    $allyRank = $ro->rank;



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
                 "allyName" => $allyName,
                 "allyId" => $allyId,
                 "allyPoints" => $allyPoints,
                 "allyMembers" => $allyMembers,
                 "allyRank" => $allyRank,
                 "noResult" => "false");




}
}
?>