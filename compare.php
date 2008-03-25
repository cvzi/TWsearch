<?php
require("include/function.getCookiesUsercp.php");
$cookieData = getCookiesUsercp();

print ("<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>\n"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>TW-Search</title>
<link rel="stylesheet" type="text/css" title="User Style" href="<?php echo $cookieData['personalCSS'];?>" />
<link rel="alternate stylesheet" type="text/css" title="Old Style" href="oldstyle.css" />
<link rel="alternate stylesheet" type="text/css" title="Normal Style" href="style.css" />

</head>
<body>
<?php
// Head
require("head.php");

// Post Variablen und Keys
$searchKeyOne = $_GET['one'];
$searchKeyTwo = $_GET['two'];
if($searchKeyOne == "")
  $searchKeyOne = $cookieData['ingameName'];


print ("<table class=\"main\" align=\"center\" cellspacing=\"3\">\n");
print ("\n");
print ("<tr>\n");
print ("<td>\n");
include("include/menu.php");
print ("</td>\n");
print ("</tr>\n");

print ("<tr>\n");
print ("<th class=\"mainTD\" colspan=\"2\">\n");
print ("<h2 align=\"center\">".$text['comparison']." - ".$worldname."</h2>\n");
print ("</th>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td class=\"mainTD\" valign=\"top\">\n");
print ("<form action=\"".$selffile."\" method=\"get\">\n");

print ("<fieldset>\n");
print ("<legend>Compare</legend>\n");
print ("<table>");
print ("<tr>");
print ("<td>Player one:</td><td><input type=\"text\" name=\"one\" value=\"".$searchKeyOne."\" /></td>\n");
print ("</tr>");
print ("<tr>");
print ("<td>Player two:</td><td><input type=\"text\" name=\"two\" value=\"".$searchKeyTwo."\" /></td>\n");
print ("</tr>");
print ("<tr>");
print ("<td colspan=\"2\"><input type=\"submit\" value=\"&raquo; ".$text['compare']."\"/></td>\n");
print ("</tr>");
print ("</table>");
print ("</fieldset>\n");
print ("</form>\n");

print ("</div>\n");
print ("</td>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td class=\"mainTD\" valign=\"top\">\n");

if($searchKeyOne == "" or $searchKeyTwo == "")
  {
  echo "<h3>".$text['enterTwoPlayer']."</h3>";
  }
elseif ($searchKeyOne != "" and $searchKeyTwo != "")
   {
   $debug['searchType'] =  "Search players: ".$searchKeyOne." and ".$searchKeyTwo;

   $debug['ReqSearchScript'] = require("include/searchByAccPlayer.php");
   $debug['ReqPlayerCharts'] = require("include/getPlayerCharts.php");
   $debug['ReqVillageScript'] = require("include/function.getVillageData.php");

// ------------ Quest Player one


     $questOne = searchAccPlayer($searchKeyOne,"ByPlayerName",$rawShifter);
     // NO RESULT
     if($questOne['noResult'] == "")
         {
         print ("<h3>".$text['noResult']."</h3>");
         }
     else
         {
         // Punktedifferenz 2 Tage:
         $pOne_pointsTwoDaysAgo = quest($questOne['playerId'],"2");
         $pOne_pointsDifferenceTwo = array();
         $pOne_pointsDifferenceTwo[1] = $questOne['playerPoints'] - $pOne_pointsTwoDaysAgo;
         if($pOne_pointsDifferenceTwo[1] > 0)
           {
           $pOne_pointsDifferenceTwo[0] = "<span class=\"positiveValues\">".$text['positiveValue']."</span>";
           }
         elseif($pOne_pointsDifferenceTwo[1] == 0)
           {
           $pOne_pointsDifferenceTwo[0] = "<span class=\"equalValues\">".$text['changelessValue']."</span>";
           }
         else
           {
           $pOne_pointsDifferenceTwo[0] = "<span class=\"negativeValues\">".$text['negativeValue']."</span>";
           }

	// Punktedifferenz 7 Tage (eine Woche):
	$pOne_pointsAWeekAgo = quest($questOne['playerId'],"7");
	$pOne_pointsDifferenceWeek = array();
	$pOne_pointsDifferenceWeek[1] = $questOne['playerPoints'] - $pOne_pointsAWeekAgo;
	if($pOne_pointsDifferenceWeek[1] > 0)
	  {
	  $pOne_pointsDifferenceWeek[0] = "<span class=\"positiveValues\">".$text['positiveValue']."</span>";
	  }
	elseif($pOne_pointsDifferenceWeek[1] == 0)
	  {
	  $pOne_pointsDifferenceWeek[0] = "<span class=\"equalValues\">".$text['changelessValue']."</span>";
	  }
	else
	  {
	  $pOne_pointsDifferenceWeek[0] = "<span class=\"negativeValues\">".$text['negativeValue']."</span>";
 	 }

	// Punktedurchschnitt der Dörfer:
	$pOne_villageAveragePoints = round( $questOne['playerPoints'] / $questOne['playerVillages']);

	// Errechne Dörfer:
	$pOne_villagequest = getVillageData($questOne['playerId'],$questOne['playerVillages'],$rawShifter);

	// Highest/Lowest Village
	$pOne_villageorder = array();
	foreach($pOne_villagequest as $line)
	  {
	  $pOne_villageorder[] = $line['villagePoints'];
 	  }
	sort($pOne_villageorder);

         $rownumber = 3 + $questOne['playerVillages'];

        $pOne_highestVillage = number_format(end($pOne_villageorder));
        $pOne_lowestVillage = number_format($pOne_villageorder[0]);
        }


// ------------ Quest Player Two


     $questTwo = searchAccPlayer($searchKeyTwo,"ByPlayerName",$rawShifter,$number);
     // NO RESULT
     if($questTwo['noResult'] == "")
         {
         print ("<h3>Player One: ".$text['noResult']."</h3>");
         }
     else
         {
         // Punktedifferenz 2 Tage:
         $pTwo_pointsTwoDaysAgo = quest($questTwo['playerId'],"2");
         $pTwo_pointsDifferenceTwo = array();
         $pTwo_pointsDifferenceTwo[1] = $questTwo['playerPoints'] - $pTwo_pointsTwoDaysAgo;
         if($pTwo_pointsDifferenceTwo[1] > 0)
           {
           $pTwo_pointsDifferenceTwo[0] = "<span class=\"positiveValues\">".$text['positiveValue']."</span>";
           }
         elseif($pTwo_pointsDifferenceTwo[1] == 0)
           {
           $pTwo_pointsDifferenceTwo[0] = "<span class=\"equalValues\">".$text['changelessValue']."</span>";
           }
         else
           {
           $pTwo_pointsDifferenceTwo[0] = "<span class=\"negativeValues\">".$text['negativeValue']."</span>";
           }

	// Punktedifferenz 7 Tage (eine Woche):
	$pTwo_pointsAWeekAgo = quest($questTwo['playerId'],"7");
	$pTwo_pointsDifferenceWeek = array();
	$pTwo_pointsDifferenceWeek[1] = $questTwo['playerPoints'] - $pTwo_pointsAWeekAgo;
	if($pTwo_pointsDifferenceWeek[1] > 0)
	  {
	  $pTwo_pointsDifferenceWeek[0] = "<span class=\"positiveValues\">".$text['positiveValue']."</span>";
	  }
	elseif($pTwo_pointsDifferenceWeek[1] == 0)
	  {
	  $pTwo_pointsDifferenceWeek[0] = "<span class=\"equalValues\">".$text['changelessValue']."</span>";
	  }
	else
	  {
	  $pTwo_pointsDifferenceWeek[0] = "<span class=\"negativeValues\">".$text['negativeValue']."</span>";
 	 }

	// Punktedurchschnitt der Dörfer:
	$pTwo_villageAveragePoints = round($questTwo['playerPoints'] / $questTwo['playerVillages']);

	// Errechne Dörfer:
         $pTwo_villagequest = getVillageData($questTwo['playerId'],$questTwo['playerVillages'],$rawShifter);

	// Highest/Lowest Village
	$pTwo_villageorder = array();
	foreach($pTwo_villagequest as $line)
	  {
	  $pTwo_villageorder[] = $line['villagePoints'];
 	  }
	sort($pTwo_villageorder);

        if(3 + $questTwo['playerVillages'] > $rownumber)
          {
          $rownumber = 3 + $questTwo['playerVillages'];
          }

        $pTwo_highestVillage = number_format(end($pTwo_villageorder));
        $pTwo_lowestVillage = number_format($pTwo_villageorder[0]);
        }


//------------------  HTML Output:

require("include/function.compareValues.php");

         print ("<table class=\"preferencesTABLE\">\n");
	print ("\n");
	print ("<tr>\n");
	print ("<th rowspan=\"9\" style=\"text-align:center; \" class=\"verticalTH\">".$text['verticalPlayer']."</th>\n");
	print ("<th class=\"horizontalTH\">Data</th><th class=\"horizontalTH\">".$questOne['playerName']."</th><th class=\"horizontalTH\">".$questTwo['playerName']."</th><th>".$text['difference']."</th>\n");
	print ("</tr>\n");
	print ("\n");
	print ("<tr><td class=\"preferencesListTD\">".$text['name']."</td>
         <td class=\"preferencesListTD\"><a class=\"intLink\" href=\"".$link['start']."?id=".$questOne['playerId']."\">".$questOne['playerName']."</a></td>\n
         <td class=\"preferencesListTD\"><a class=\"intLink\" href=\"".$link['start']."?id=".$questTwo['playerId']."\">".$questTwo['playerName']."</a></td></tr>\n");

	print ("<tr><td class=\"preferencesListTD\">".$text['id']."</td>
         <td class=\"preferencesListTD\">".$questOne['playerId']."</td>\n
         <td class=\"preferencesListTD\">".$questTwo['playerId']."</td></tr>\n");

	print ("<tr><td class=\"preferencesListTD\">".$text['villages']."</td>
         <td class=\"preferencesListTD\">".$questOne['playerVillages']."</td>
         <td class=\"preferencesListTD\">".$questTwo['playerVillages']."</td>
         <td class=\"preferencesListTD\">".compareValues($questOne['playerVillages'],$questTwo['playerVillages'],true,true)."</td></tr>\n");

	print ("<tr><td class=\"preferencesListTD\">".$text['points']."</td>
         <td class=\"preferencesListTD\">".number_format($questOne['playerPoints'])."</td>
         <td class=\"preferencesListTD\">".number_format($questTwo['playerPoints'])."</td>
         <td class=\"preferencesListTD\">".compareValues($questOne['playerPoints'],$questTwo['playerPoints'],true,true)."</td></tr>\n");

	print ("<tr><td class=\"preferencesListTD\">".$text['rank']."</td>
         <td class=\"preferencesListTD\">".$questOne['playerRanking']."</td>
         <td class=\"preferencesListTD\">".$questTwo['playerRanking']."</td>
         <td class=\"preferencesListTD\">".compareValues($questOne['playerRanking'],$questTwo['playerRanking'],true,true,true)."</td></tr>\n");


	print ("<tr><td class=\"preferencesListTD\">".$text['birthday']."</td>
         <td class=\"preferencesListTD\">".$questOne['playerBirthday']."</td>
         <td class=\"preferencesListTD\">".$questTwo['playerBirthday']."</td>
         </tr>\n");
         #<td class=\"preferencesListTD\">".compareValues($questOne['playerBirthday'],$questTwo['playerBirthday'],false)."</td></tr>\n");


	print ("<tr><td class=\"preferencesListTD\">".$text['sex']."</td>
         <td class=\"preferencesListTD\">".$questOne['playerSex']."</td>
         <td class=\"preferencesListTD\">".$questTwo['playerSex']."</td>
         </tr>\n");
         #<td class=\"preferencesListTD\">".compareValues($questOne['playerSex'],$questTwo['playerSex'],false)."</td></tr>\n");

	print ("<tr><td class=\"preferencesListTD\">".$text['location']."</td>
         <td class=\"preferencesListTD\">".$questOne['playerLocation']."</td>
         <td class=\"preferencesListTD\">".$questTwo['playerLocation']."</td>
         </tr>\n");
         #<td class=\"preferencesListTD\">".compareValues($questOne['playerLocation'],$questTwo['playerLocation'],false)."</td></tr>\n");

	print ("\n");
         if($questOne['allyId'] == "")
           {
	  print ("<th rowspan=\"1\" class=\"verticalTH\"></th>\n");
	  print ("<th colspan=\"3\" class=\"horizontalTH\">".$text['playerOneTribeless']."</th>\n");
           print ("</table>\n");
           }
         if($questTwo['allyId'] == "")
           {
	  print ("<th rowspan=\"1\" class=\"verticalTH\"></th>\n");
	  print ("<th colspan=\"3\" class=\"horizontalTH\">".$text['playerTwoTribeless']."</th>\n");
           print ("</table>\n");
           }
         else
           {
        	  print ("<tr>\n");
	  print ("<th rowspan=\"6\" style=\"text-align:center; \" class=\"verticalTH\">".$text['verticalTribe']."</th>\n");
	  print ("<th class=\"horizontalTH\">Data</th><th class=\"horizontalTH\">".$questOne['playerName']."</th><th class=\"horizontalTH\">".$questTwo['playerName']."</th>\n");
	  print ("</tr>\n");
	  print ("\n");
	  print ("<tr><td class=\"preferencesListTD\">".$text['name']."</td>
           <td class=\"preferencesListTD\"><a class=\"intLink\" href=\"".$link['tribe']."?id=".$questOne['allyId']."\">".$questOne['allyName']."</a><a title=\"Ingame to ".$questOne['allyName']."\" href=\"".$link['inGameTribe'].$questOne['allyId']."\"><img class=\"extLink\"  alt=\"Ingame\" align=\"right\" src=\"images/ds_extern.png\" /></a></td>
           <td class=\"preferencesListTD\"><a class=\"intLink\" href=\"".$link['tribe']."?id=".$questTwo['allyId']."\">".$questTwo['allyName']."</a><a title=\"Ingame to ".$questTwo['allyName']."\" href=\"".$link['inGameTribe'].$questTwo['allyId']."\"><img class=\"extLink\"  alt=\"Ingame\" align=\"right\" src=\"images/ds_extern.png\" /></a></td>
           <td class=\"preferencesListTD\">".compareValues($questOne['allyName'],$questTwo['allyName'],false)."</td></tr>\n");


	  print ("<tr><td class=\"preferencesListTD\">".$text['points']."</td>
           <td class=\"preferencesListTD\">".$questOne['allyPoints']."</td>
           <td class=\"preferencesListTD\">".$questTwo['allyPoints']."</td>
           <td class=\"preferencesListTD\">".compareValues($questOne['allyPoints'],$questTwo['allyPoints'],true,true)."</td></tr>\n");

	  print ("<tr><td class=\"preferencesListTD\">".$text['members']."</td>
           <td class=\"preferencesListTD\">".$questOne['allyMembers']."</td>
           <td class=\"preferencesListTD\">".$questTwo['allyMembers']."</td>
           </tr>\n");
           #<td class=\"preferencesListTD\">".compareValues($questOne['allyMembers'],$questTwo['allyMembers'],true,true)."</td></tr>\n");

	  print ("<tr><td class=\"preferencesListTD\">".$text['rank']."</td>
           <td class=\"preferencesListTD\">".$questOne['allyRank']."</td>
           <td class=\"preferencesListTD\">".$questTwo['allyRank']."</td>
           <td class=\"preferencesListTD\">".compareValues($questOne['allyRank'],$questTwo['allyRank'],true,true,true)."</td></tr>\n");

	  print ("\n");
	  print ("</table>\n");
           }


	print ("<p>\n");
	print ("<table class=\"preferencesTABLE\">\n");
	print ("<tr>\n");
	print ("<th rowspan=\"4\" style=\"text-align:center; \" class=\"verticalTH\">".$text['verticalData']."</th>\n");
	print ("<th colspan=\"2\" class=\"horizontalTH\">".$text['additional']."</th><th>".$text['difference']."</th>\n");
	print ("</tr>\n");
	print ("<tr><td class=\"preferencesListTD\">".$text['villageAverage']."</td>
         <td class=\"preferencesListTD\">~".number_format($pOne_villageAveragePoints)."</td>
         <td class=\"preferencesListTD\">~".number_format($pTwo_villageAveragePoints)."</td>
         <td class=\"preferencesListTD\">".compareValues($pOne_villageAveragePoints,$pTwo_villageAveragePoints,true,true)."</td></tr>\n");

	print ("<tr><td class=\"preferencesListTD\">".$text['pointsDifference']."<span style=\"float: right; font-size:small\">".$text['minusTwoDays']."</span></td>
         <td class=\"preferencesListTD\" style=\"font-size:70%;\">".$pOne_pointsDifferenceTwo[0]." <span style=\"font-size:130%; float:right; \">".number_format($pOne_pointsDifferenceTwo[1])."</span></td>
         <td class=\"preferencesListTD\" style=\"font-size:70%;\">".$pTwo_pointsDifferenceTwo[0]." <span style=\"font-size:130%; float:right; \">".number_format($pTwo_pointsDifferenceTwo[1])."</span></td>
         <td class=\"preferencesListTD\">".compareValues($pOne_pointsDifferenceTwo[1],$pTwo_pointsDifferenceTwo[1],true,true)."</td></tr>\n");

	print ("<tr><td class=\"preferencesListTD\">".$text['pointsDifference']."<span style=\"float: right; font-size:small\">".$text['minusWeek']."</span></td>
         <td class=\"preferencesListTD\" style=\"font-size:70%;\">".$pOne_pointsDifferenceWeek[0]." <span style=\"font-size:130%; float:right; \">".number_format($pOne_pointsDifferenceWeek[1])."</span></td>
         <td class=\"preferencesListTD\" style=\"font-size:70%;\">".$pTwo_pointsDifferenceWeek[0]." <span style=\"font-size:130%; float:right; \">".number_format($pTwo_pointsDifferenceWeek[1])."</span></td>
         <td class=\"preferencesListTD\">".compareValues($pOne_pointsDifferenceWeek[1],$pTwo_pointsDifferenceWeek[1],true,true)."</td></tr>\n");

	print ("</table>\n");

	print ("</p>\n");

	print ("<p>\n");
	print ("<table class=\"preferencesTABLE\">\n");
	print ("<tr>\n");
         print ("<td colspan=\"2\" class=\"preferencesListTD\"><img src=\"chart_big/index.php?id=".$questOne['playerId']."\" alt=\"Chart\" /></td>\n");
         print ("<td colspan=\"2\" class=\"preferencesListTD\"><img src=\"chart_big/index.php?id=".$questTwo['playerId']."\" alt=\"Chart\" /></td>\n");
	print ("</tr>\n");
	print ("</table>\n");
	print ("</p>\n");

   }


print ("</td>\n");
print ("</tr>\n");
print ("</table>\n");



// Zeit für Aufbau
$time_end = microtime(true);
$time = $time_end - $time_start;
$time = $time * 1000;
if($time < 1) { $time = "less than one millisecond"; }
         else { $time = round($time). "ms"; }

$d++;
$debug['ReqFoot'] = require("foot.php");






if (isset($debugmode))
{
$debug['ReqTrueFalse'] = require("include/function.checkCorrect.php");
$length = count($debug) + 3;
print ("<table style=\"position:fixed; bottom:10px; left:10px; \" class=\"preferencesTABLE\" id=\"debugTABLE\">\n");
print ("<tr>\n");
print ("<th rowspan=\"".$length."\" class=\"verticalTH\">D<br />E<br />B<br />U<br />G</th>\n");
print ("<th colspan=\"2\" class=\"horizontalTH\">".$debug['selffile']." <span style=\"float:right; font-size:small; \" onclick=\"javascript:document.getElementById('debugTABLE').style.position = '';this.style.color = 'gray'; \">Reposition</span></th>\n");
print ("</tr>\n");
print ("<tr><td class=\"preferencesListTD\">MySQL:</td>\n");
print ("<td class=\"preferencesListTD\">".checkCorrect($debug['mysql'])."</td></tr>\n");
print ("<tr><td class=\"preferencesListTD\">MySQL DB:</td>\n");
print ("<td class=\"preferencesListTD\">".checkCorrect($debug['mysqlDB'])."</td></tr>\n");
print ("<tr><td class=\"preferencesListTD\">Search (Type and Key):</td>\n");
print ("<td class=\"preferencesListTD\">".checkCorrect($debug['searchType'])."</td></tr>\n");
print ("<tr><td class=\"preferencesListTD\">Require searchscript:</td>\n");
print ("<td class=\"preferencesListTD\">".checkCorrect($debug['ReqSearchScript'])."</td></tr>\n");
print ("<tr><td class=\"preferencesListTD\">Require villagescript:</td>\n");
print ("<td class=\"preferencesListTD\">".checkCorrect($debug['ReqVillageScript'])."</td></tr>\n");
print ("<tr><td class=\"preferencesListTD\">Require playercharts:</td>\n");
print ("<td class=\"preferencesListTD\">".checkCorrect($debug['ReqPlayerCharts'] )."</td></tr>\n");
print ("<tr><td class=\"preferencesListTD\">Require translation:</td>\n");
print ("<td class=\"preferencesListTD\">".checkCorrect($debug['ReqTranslation'])."</td></tr>\n");
print ("<tr><td class=\"preferencesListTD\">Require foot:</td>\n");
print ("<td class=\"preferencesListTD\">".checkCorrect($debug['ReqFoot'])."</td></tr>\n");
print ("<tr><td class=\"preferencesListTD\">Require True/False:</td>\n");
print ("<td class=\"preferencesListTD\">".checkCorrect($debug['ReqTrueFalse'])."</td></tr>\n");
print ("<tr><td class=\"preferencesListTD\">Require Stats:</td>\n");
print ("<td class=\"preferencesListTD\">".checkCorrect($debug['ReqStats'])."</td></tr>\n");


print ("</table>\n");
}


?>


</body>
</html>