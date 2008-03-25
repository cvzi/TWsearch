<?php
/*
* DS-Search
* Written by cuzi 2007/2008
* cuzi@openmail.cc
*/

require("include/function.getCookiesUsercp.php");
$cookieData = getCookiesUsercp();

// Head
require("head.php");

print ("<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>\n"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>TW-Search</title>
<link rel="stylesheet" type="text/css" title="User Style" href="<?php echo $cookieData['personalCSS']; ?>" />
<link rel="alternate stylesheet" type="text/css" title="Old Style" href="oldstyle.css" media="screen" />
<link rel="alternate stylesheet" type="text/css" title="Normal Style" href="style.css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="News" href="/feed.php" media="screen" />

<script type="text/javascript">
function popupSig(w,h,id)
  {
  var popupWindow = window.open(false,"Commands","width=" + w + ",height=" + h);
  var content = "<img src=\"<?php echo $link['sig'];?>?name="+id+"\" /><br /><input type=\"text\" size=\""+id.length+53+"\" value=\"[img]<?php echo $link['sig'];?>?name="+id+"[/img]\" />";
  popupWindow.document.write(content);
  }

</script>

</head>
<body>
<?php

// Post Variablen und Keys
if(isset($id) == false and isset($name) == false)
{
$searchKey = $_POST['searchKey'];
$searchType = $_POST['searchType'];
if($searchType == 'ByPlayerName')
  {
  $formOption = "name";
  }
elseif($searchType == 'ByPlayerId')
  {
  $formOption = "id";
  }
}
elseif(isset($id) == true)
{
$searchKey = $id;
$searchType = "ByPlayerId";
$formOption = "id";
}
elseif(isset($name) == true)
{
$searchKey = $name;
$searchType = "ByPlayerName";
$formOption = "name";
}


print ("<table class=\"main\" style=\"text-align:left; margin-left:auto; margin-right:auto\" cellspacing=\"3\">\n");
print ("\n");
print ("<tr>\n");
print ("<td>\n");
include("include/menu.php");
print ("</td>\n");
print ("</tr>\n");

print ("<tr>\n");
print ("<th class=\"mainTD\" colspan=\"2\">\n");
print ("<h2>".$text['heading2']." - ".$worldname."</h2>\n");
print ("</th>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td class=\"mainTD\" valign=\"top\">\n");
print ("<form action=\"".$selffile."\" method=\"post\">\n");
print ("<fieldset>\n");
print ("<input type=\"text\" name=\"searchKey\" value=\"".$searchKey."\" />\n");
print ("<select name=\"searchType\">\n");

if($formOption == "id")
  {
  print ("<option value=\"ByPlayerName\">".$text['byPlyerNameOption']."</option>\n");
  print ("<option selected=\"selected\" value=\"ByPlayerId\">".$text['byPlyerIdOption']."</option>\n");
  }
else
  {
  print ("<option selected=\"selected\" value=\"ByPlayerName\">".$text['byPlyerNameOption']."</option>\n");
  print ("<option value=\"ByPlayerId\">".$text['byPlyerIdOption']."</option>\n");
  }

print ("</select>\n");
print ("<input type=\"submit\" value=\"".$text['submitSearchButton']."\"/>\n");
print ("</fieldset>\n");
print ("</form>\n");

print ("</td>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td class=\"mainTD\" valign=\"top\">\n");

if($searchKey == "")
  {
  echo "<h3>".$text['enterSearchKeyOrder']."</h3>";
  if($cookieData['showOwnInfos'])
    {
    require("include/searchByAccPlayer.php");
    $ownid = mysql_fetch_object(mysql_query("SELECT `id` FROM ".$playertable." WHERE `name` LIKE '".urlencode($cookieData['ingameName'])."'"))->id;
    $ownallyid = mysql_fetch_object(mysql_query("SELECT `ally` FROM ".$playertable." WHERE `name` LIKE '".urlencode($cookieData['ingameName'])."'"))->ally;
    print ("<p>");
    print ("<img src=\"".$link['playerChart']."?id=".$ownid."\" alt=\"Chart of ".$cookieData['ingameName']."\"/>");
    print ("<br />");
    print ("<img src=\"".$link['tribeChart']."?id=".$ownallyid."\" alt=\"Chart of ".$cookieData['ingameName']."\"/>");
    print ("</p>");


    }
  if($cookieData['showRankHomepage'])
    {
    $first = mysql_fetch_object(mysql_query("SELECT `name`,`id`,`points` FROM ".$playertable." WHERE `rank` LIKE '1'"));
	$firstname = htmlentities(urldecode($first->name));
	$firstid = $first->id;
	$firstpoints = $first->points;

    $second = mysql_fetch_object(mysql_query("SELECT `name`,`id`,`points` FROM ".$playertable." WHERE `rank` LIKE '2'"));
	$secondname = htmlentities(urldecode($second->name));
	$secondid = $second->id;
	$secondpoints = $second->points;

    $third = mysql_fetch_object(mysql_query("SELECT `name`,`id`,`points` FROM ".$playertable." WHERE `rank` LIKE '3'"));
	$thirdname = htmlentities(urldecode($third->name));
	$thirdid = $third->id;
	$thirdpoints = $third->points;

    print ("<p><table class=\"preferencesTABLE\">\n");
	print ("\n");
	print ("<tr>\n");
	print ("<th rowspan=\"5\" style=\"text-align:center; \" class=\"verticalTH\">".$text['verticalRank']."</th>\n");
	print ("<th colspan=\"2\" class=\"horizontalTH\">".$text['podium']."</th>\n");
	print ("</tr>\n");
	print ("\n");
	print ("<tr><td class=\"preferencesListTD\"><img alt=\"".$text['medalGold']."\" src=\"images/medal_gold.png\"/></td><td class=\"preferencesListTD\"><a class=\"intLink\" href=\"".$selffile."?id=".$firstid."\">".$firstname."</a></td><td class=\"preferencesListTD\">".wash_number($firstpoints)."</td></tr>\n");
	print ("<tr><td class=\"preferencesListTD\"><img alt=\"".$text['medalSilver']."\" src=\"images/medal_silver.png\"/></td><td class=\"preferencesListTD\"><a class=\"intLink\" href=\"".$selffile."?id=".$secondid."\">".$secondname."</a></td><td class=\"preferencesListTD\">".wash_number($secondpoints)."</td></tr>\n");
	print ("<tr><td class=\"preferencesListTD\"><img alt=\"".$text['medalBronze']."\" src=\"images/medal_bronze.png\"/></td><td class=\"preferencesListTD\"><a class=\"intLink\" href=\"".$selffile."?id=".$thirdid."\">".$thirdname."</a></td><td class=\"preferencesListTD\">".wash_number($thirdpoints)."</td></tr>\n");
    print ("</table></p>\n");

    }
  }

elseif ($searchKey != "")
   {
   $debug['searchType'] =  "Search ".$searchType." for ".$searchKey;

   $debug['ReqSearchScript'] = require("include/searchByAccPlayer.php");

   if($searchType == 'ByPlayerName')
     {
     $quest = searchAccPlayer($searchKey,$searchType,$rawShifter);
     }
   elseif($searchType == 'ByPlayerId')
     {
     $quest = searchAccPlayer($searchKey,$searchType,$rawShifter);
     }

     // NO RESULT
     if($quest['noResult'] == "")
         {
         if($searchType == 'ByPlayerName')  // Falls aus Versehen "Name" gewählt wurde, aber eine ID eingegeben ist
           {
           $searchagain = $debug['selffile']."?id=".$searchKey;
           echo "<script type=\"text/javascript\">";
           echo "window.location.href = '".$searchagain."';";
           echo "</script>";
           }
         print ("<h3>".$text['noResult']."</h3>");
         }
     else
         {
         print ("<table class=\"preferencesTABLE\">\n");
	print ("\n");
	print ("<tr>\n");
	print ("<th rowspan=\"9\" style=\"text-align:center; \" class=\"verticalTH\">".$text['verticalPlayer']."</th>\n");
	print ("<th colspan=\"2\" class=\"horizontalTH\">".$quest['playerName']."</th>\n");
	print ("</tr>\n");
	print ("\n");
	print ("<tr><td class=\"preferencesListTD\">".$text['name'].":</td><td class=\"preferencesListTD\">".$quest['playerName']."\n");

         print ("<a title=\"".$text['headingGenerateSignatur']."\" href=\"".$link['sig']."?name=".$quest['playerName']."\"  onClick=\"popupSig(425,70,'".$quest['playerName']."');return false; \">\n");
         print ("  <img class=\"extLink\" alt=\"".$text['headingGenerateSignatur']."\" style=\"padding-right:1px; float:right; \" src=\"images/dia_icon.png\" />\n");
         print ("</a>\n");

         print ("<a title=\"Ingame to ".$quest['playerName']."\" href=\"".$link['inGamePlayer'].$quest['playerId']."\">\n");
         print ("  <img class=\"extLink\" alt=\"Ingame\" style=\"padding-right:1px; float:right; \" src=\"images/ds_extern.png\" />\n");
         print ("</a>\n");

         print ("<a title=\"Profile of ".$quest['playerName']."\" href=\"".$link['profile']."?id=".$quest['playerId']."\" onClick=\"fenster = window.open('".$link['profile']."?id=".$quest['playerId']."', 'Profile', 'dependent=yes,width=500,height=500,status=no,scrollbars=yes,resizable=yes'); fenster.focus(); return false;\">\n");
         print ("  <img class=\"extLink\" alt=\"Profile\" style=\"padding-right:1px; float:right; \" src=\"images/profile.png\" />\n");
         print ("</a>\n");

         print ("</td></tr>\n");
	print ("<tr><td class=\"preferencesListTD\">".$text['id'].":</td><td class=\"preferencesListTD\">".$quest['playerId']."</td></tr>\n");
	print ("<tr><td class=\"preferencesListTD\">".$text['villages'].":</td><td class=\"preferencesListTD\">".$quest['playerVillages']."</td></tr>\n");
	print ("<tr><td class=\"preferencesListTD\">".$text['points'].":</td><td class=\"preferencesListTD\">".wash_number($quest['playerPoints'])."</td></tr>\n");
	print ("<tr><td class=\"preferencesListTD\">".$text['rank'].":</td><td class=\"preferencesListTD\">".$quest['playerRanking']."</td></tr>\n");
	print ("<tr><td class=\"preferencesListTD\">".$text['birthday'].":</td><td class=\"preferencesListTD\">".$quest['playerBirthday']."</td></tr>\n");
	print ("<tr><td class=\"preferencesListTD\">".$text['sex'].":</td><td class=\"preferencesListTD\">".$quest['playerSex']."</td></tr>\n");
	print ("<tr><td class=\"preferencesListTD\">".$text['location'].":</td><td class=\"preferencesListTD\">".$quest['playerLocation']."</td></tr>\n");
	print ("\n");
         if($quest['allyId'] == "")
           {
	  print ("<th rowspan=\"1\" class=\"verticalTH\"></th>\n");
	  print ("<th colspan=\"2\" class=\"horizontalTH\">".$text['noTribe']."</th>\n");
           print ("</table>\n");
           }
         else
           {
        	  print ("<tr>\n");
	  print ("<th rowspan=\"7\" style=\"text-align:center; \" class=\"verticalTH\">".$text['verticalTribe']."</th>\n");
	  print ("<th colspan=\"2\" class=\"horizontalTH\">".$quest['allyFullname']."</th>\n");
	  print ("</tr>\n");
	  print ("\n");
	  print ("<tr><td class=\"preferencesListTD\">".$text['name'].":</td><td class=\"preferencesListTD\"><a class=\"intLink\" href=\"".$link['tribe']."?id=".$quest['allyId']."\">".$quest['allyFullname']."</a>\n");
           print ("    <a title=\"Ingame to ".$quest['allyName']."\" href=\"".$link['inGameTribe'].$quest['allyId']."\"><img class=\"extLink\" alt=\"Ingame\" style=\"padding-right:1px; float:right; \" src=\"images/ds_extern.png\" /></a></td></tr>\n");
           print ("<tr><td class=\"preferencesListTD\">".$text['tribeTag'].":</td><td class=\"preferencesListTD\">".$quest['allyTag']."</td></tr>\n");
           print ("<tr><td class=\"preferencesListTD\">".$text['id'].":</td><td class=\"preferencesListTD\">".$quest['allyId']."</td></tr>\n");
	  print ("<tr><td class=\"preferencesListTD\">".$text['points'].":</td><td class=\"preferencesListTD\">".$quest['allyPoints']."</td></tr>\n");
	  print ("<tr><td class=\"preferencesListTD\">".$text['members'].":</td><td class=\"preferencesListTD\">".$quest['allyMembers']."</td></tr>\n");
	  print ("<tr><td class=\"preferencesListTD\">".$text['rank'].":</td><td class=\"preferencesListTD\">".$quest['allyRank']."</td></tr>\n");
	  print ("\n");
	  print ("</table>\n");
           }

   print ("</td>\n");


// Errechne zusätzliche Infos:


// Punktedifferenz 2 Tage:
$debug['ReqPlayerCharts'] = require("include/getPlayerCharts.php");
$pointsTwoDaysAgo = quest($quest['playerId'],"2");
$pointsDifferenceTwo = array();
$pointsDifferenceTwo[1] = $quest['playerPoints'] - $pointsTwoDaysAgo;
if($pointsDifferenceTwo[1] > 0)
  {
  $pointsDifferenceTwo[0] = "<span class=\"positiveValues\">".$text['positiveValue']."</span>";
  }
elseif($pointsDifferenceTwo[1] == 0)
  {
  $pointsDifferenceTwo[0] = "<span class=\"equalValues\">".$text['changelessValue']."</span>";
  }
else
  {
  $pointsDifferenceTwo[0] = "<span class=\"negativeValues\">".$text['negativeValue']."</span>";
  }

// Punktedifferenz 7 Tage (eine Woche):
$pointsAWeekAgo = quest($quest['playerId'],"7");
$pointsDifferenceWeek = array();
$pointsDifferenceWeek[1] = $quest['playerPoints'] - $pointsAWeekAgo;
if($pointsDifferenceWeek[1] > 0)
  {
  $pointsDifferenceWeek[0] = "<span class=\"positiveValues\">".$text['positiveValue']."</span>";
  }
elseif($pointsDifferenceWeek[1] == 0)
  {
  $pointsDifferenceWeek[0] = "<span class=\"equalValues\">".$text['changelessValue']."</span>";
  }
else
  {
  $pointsDifferenceWeek[0] = "<span class=\"negativeValues\">".$text['negativeValue']."</span>";
  }

// Punktedurchschnitt der Dörfer:

$villageAveragePoints = round( $quest['playerPoints'] / $quest['playerVillages']);


// DS-Search Data
// --------------

print ("<td class=\"mainTD\" valign=\"top\">\n");

print ("<div>\n");
print ("<table class=\"preferencesTABLE\">\n");
print ("<tr>\n");
print ("<th rowspan=\"14\" style=\"text-align:center; \" class=\"verticalTH\">".$text['verticalData']."</th>\n");
print ("<th colspan=\"2\" class=\"horizontalTH\">".$text['additional']."</th>\n");
print ("</tr>\n");
print ("<tr><td class=\"preferencesListTD\">".$text['villageAverage'].":</td><td class=\"preferencesListTD\">~".wash_number($villageAveragePoints)."</td></tr>\n");
print ("<tr><td class=\"preferencesListTD\">".$text['pointsDifference'].":<span style=\"float: right; font-size:small\">".$text['minusTwoDays']."</span></td><td class=\"preferencesListTD\">".$pointsDifferenceTwo[0]." <span style=\"float:right; \">".wash_number($pointsDifferenceTwo[1])."</span></td></tr>\n");
print ("<tr><td class=\"preferencesListTD\">".$text['pointsDifference'].":<span style=\"float: right; font-size:small\">".$text['minusWeek']."</span></td><td class=\"preferencesListTD\">".$pointsDifferenceWeek[0]." <span style=\"float:right; \">".wash_number($pointsDifferenceWeek[1])."</span></td></tr>\n");
// Basher DATA
print ("<tr><th colspan=\"2\" class=\"horizontalTH\">".$text['opponentsDefeated'].":</th></tr>\n");
print ("<tr><td class=\"preferencesListTD\">".$text['totalKills']."</td><td class=\"preferencesListTD\">".wash_number($quest['playerAllKills'])."</td></tr>\n");
print ("<tr><td class=\"preferencesListTD\">".$text['totalRank']."</td><td class=\"preferencesListTD\">".wash_number($quest['playerAllRank'])."</td></tr>\n");
print ("<tr><td class=\"preferencesListTD\">".$text['totalRelation']."</td><td class=\"preferencesListTD\">".round($quest['playerAllKills']/$quest['playerPoints']*100)."%</td></tr>\n");

print ("<tr><td class=\"preferencesListTD\">".$text['defenderKills']."</td><td class=\"preferencesListTD\">".wash_number($quest['playerDefKills'])."</td></tr>\n");
print ("<tr><td class=\"preferencesListTD\">".$text['defenderRank']."</td><td class=\"preferencesListTD\">".wash_number($quest['playerDefRank'])."</td></tr>\n");
print ("<tr><td class=\"preferencesListTD\">".$text['defenderRelation']."</td><td class=\"preferencesListTD\">".round($quest['playerDefKills']/$quest['playerPoints']*100)."%</td></tr>\n");

print ("<tr><td class=\"preferencesListTD\">".$text['attackerKills']."</td><td class=\"preferencesListTD\">".wash_number($quest['playerAttKills'])."</td></tr>\n");
print ("<tr><td class=\"preferencesListTD\">".$text['attackerRank']."</td><td class=\"preferencesListTD\">".wash_number($quest['playerAttRank'])."</td></tr>\n");
print ("<tr><td class=\"preferencesListTD\">".$text['attackerRelation']."</td><td class=\"preferencesListTD\">".round($quest['playerAttKills']/$quest['playerPoints']*100)."%</td></tr>\n");


// Chart
print ("<tr><td /><td colspan=\"2\" class=\"preferencesListTD\"><img src=\"".$link['playerChart']."?id=".$quest['playerId']."\" alt=\"".$text['chart']."\" /></td></tr>\n");
print ("</table>\n");

print ("</div>\n");
print ("</td>\n");

print ("</tr>\n");


// Dörfer Data
// --------------


// Errechne Dörfer:
$debug['ReqVillageScript'] = require("include/function.getVillageData.php");
$villagequest = getVillageData($quest['playerId'],$quest['playerVillages'],$rawShifter);


// Highest/Lowest Village
$villageorder = array();
foreach($villagequest as $line)
  {
  $villageorder[] = $line['villagePoints'];
  }
sort($villageorder);



$rownumber = 3 + $quest['playerVillages'];

print ("<tr>\n");

print ("<td class=\"mainTD\" valign=\"top\">\n");
print ("<div>\n");

print ("<table class=\"preferencesTABLE\">\n");
print ("<tr>\n");
print ("<th rowspan=\"3\" class=\"verticalTH\"></th>\n");
print ("<th colspan=\"2\" class=\"horizontalTH\">".$text['villages']."</th>\n");
print ("</tr>\n");
print ("<tr><td class=\"preferencesListTD\">".$text['highestVillage'].":</td><td class=\"preferencesListTD\">".wash_number(end($villageorder))."</td></tr>\n");
print ("<tr><td class=\"preferencesListTD\">".$text['lowestVillage'].":</td><td class=\"preferencesListTD\">".wash_number($villageorder[0])."</td></tr>\n");
print ("<tr><th id=\"th_hidevillageList\" colspan=\"2\" onclick=\"this.style.display = 'none'; document.getElementById('table_villageList').style.display = 'block'; \" class=\"horizontalTH\"><img alt=\"".$text['showVillagelist']."\" src=\"images/villages_show.png\" /> ".$text['showVillagelist']."</th></tr>\n");
print ("</table>\n");

print ("<table id=\"table_villageList\" style=\"display:none; \" class=\"preferencesTABLE\">\n");
print ("<tr><th rowspan=\"".$rownumber."\" class=\"verticalTH\"></th></tr>\n");
print ("<tr><th colspan=\"2\" class=\"horizontalTH\">".$text['villageList']."</th></tr>\n");
print ("<tr><th class=\"preferencesListTD\">".$text['name']."</th><th class=\"preferencesListTD\">".$text['coordinates']."</th><th class=\"preferencesListTD\">".$text['points']."</th></tr>\n");
foreach($villagequest as $line)
  {
  print ("<tr><td class=\"preferencesListTD\"><a class=\"intLink\" href=\"/village.php?coords=".$line['villageX']."|".$line['villageY']."\">".$line['villageName']."</a></td><td class=\"preferencesListTD\">(".$line['villageX']."|".$line['villageY'].") <a title=\"Ingame to (".$line['villageX']."|".$line['villageY'].")\" href=\"".$link['inGameVillage'].$line['villageID']."\"><img class=\"extLink\" alt=\"Ingame\" style=\"text-align:right; \" src=\"images/ds_extern.png\" /></a></td><td class=\"preferencesListTD\">".wash_number($line['villagePoints'])."</td></tr>\n");
  }
print ("</table>\n");

print ("</div>\n");

   }


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
$length = count($debug) + 4;
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