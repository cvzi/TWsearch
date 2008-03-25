<?php
function searchRankingByPage($page, $rawdata="raw", $adv=false)
{

// Translation
require("translation.php");

// Weltdaten/Tabellen holen
require("include/getTableNames.php");

  $upToRank = ($page-1) * 20 + 20;
  $firstRank = ($page-1) * 20;
  if($page == "1")
    {
    $firstRank = 0;
    $upToRank = 20;
    }

  $sql = "SELECT * "
        . " FROM `".$playertable."` "
        . " WHERE (`rank` <= ".$upToRank.")"
        . " ORDER BY `rank` ASC"
        . " LIMIT ".$firstRank." , ".$upToRank."";

  $ergebnis = mysql_query($sql);
  $playerArray = array();
  while($row = mysql_fetch_object($ergebnis))
    {
    if ($rawdata == 'raw') { $playerName = $row->name; } elseif ($rawdata == 'html') { $playerName = urldecode($row->name); }; // $playerName

    $playerId = $row->id;

    $playerVillages = $row->villages;

    $playerPoints = $row->points;

    $playerRanking = $row->rank;

    $allyId = $row->ally;

    if($adv)
    {
    require_once("include/searchByAccPlayer.php");
    $quest = searchAccPlayer($playerId,"ByPlayerId","html");

    $allyName = "<td class=\"preferencesListTD\"><a class=\"intLink\" href=\"".$link['tribe']."?id=".$quest['allyId']."\">".$quest['allyTag']."</a></td>";
    $allyNameMark = "<td style=\"background-color:rosybrown\" class=\"preferencesListTD\"><a class=\"intLink\" href=\"".$link['tribe']."?id=".$quest['allyId']."\">".$quest['allyTag']."</a></td>";

    // Bashing Crap:

    $allKills =  "<td class=\"preferencesListTD\">".wash_number($quest['playerAllRank'])."</td><td nowrap=\"nowrap\" class=\"preferencesListTD\">".wash_number($quest['playerAllKills'])." (".round($quest['playerAllKills']/$quest['playerPoints']*100)."%)</td>";

    $attKills =  "<td class=\"preferencesListTD\">".wash_number($quest['playerAttRank'])."</td><td nowrap=\"nowrap\" class=\"preferencesListTD\">".wash_number($quest['playerAttKills'])." (".round($quest['playerDefKills']/$quest['playerPoints']*100)."%)</td>";


    $defKills =  "<td class=\"preferencesListTD\">".wash_number($quest['playerDefRank'])."</td><td nowrap=\"nowrap\" class=\"preferencesListTD\">".wash_number($quest['playerDefKills'])." (".round($quest['playerDefKills']/$quest['playerPoints']*100)."%)</td>";

      // Falls Spieler gewählt ist
    $allKillsMark =  "<td style=\"background-color:rosybrown\" class=\"preferencesListTD\">".wash_number($quest['playerAllRank'])."</td><td style=\"background-color:rosybrown\" nowrap=\"nowrap\" class=\"preferencesListTD\">".wash_number($quest['playerAllKills'])." (".round($quest['playerAllKills']/$quest['playerPoints']*100)."%)</td>";

    $attKillsMark =  "<td style=\"background-color:rosybrown\" class=\"preferencesListTD\">".wash_number($quest['playerAttRank'])."</td><td style=\"background-color:rosybrown\" nowrap=\"nowrap\" class=\"preferencesListTD\">".wash_number($quest['playerAttKills'])." (".round($quest['playerDefKills']/$quest['playerPoints']*100)."%)</td>";


    $defKillsMark =  "<td style=\"background-color:rosybrown\" class=\"preferencesListTD\">".wash_number($quest['playerDefRank'])."</td><td style=\"background-color:rosybrown\" nowrap=\"nowrap\" class=\"preferencesListTD\">".wash_number($quest['playerDefKills'])." (".round($quest['playerDefKills']/$quest['playerPoints']*100)."%)</td>";
    }

    $playerArray[$i] = array("playerId" => $playerId,
                             "playerName" => $playerName,
                             "playerVillages" => $playerVillages,
                             "playerPoints" => $playerPoints,
                             "playerRanking" => $playerRanking,
                             "allyName" => $allyName,
                             "allyNameMark" => $allyNameMark,
                             "allyId" => $allyId,
                             "allKills" => $allKills,
                             "defKills" => $defKills,
                             "attKills" => $attKills,
                             "allKillsMark" => $allKillsMark,
                             "defKillsMark" => $defKillsMark,
                             "attKillsMark" => $attKillsMark);
    $i++;
    }

$playerArray['noResult'] = false;
return $playerArray;
}
?>