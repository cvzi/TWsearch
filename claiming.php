<?php
require("include/function.getCookiesUsercp.php");
$cookieData = getCookiesUsercp();

print ("<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>\n"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>TW-Search</title>
<link rel="stylesheet" type="text/css" title="User Style" href="<?php echo $cookieData['personalCSS']; ?>" />
<link rel="alternate stylesheet" type="text/css" title="Old Style" href="oldstyle.css" />
<link rel="alternate stylesheet" type="text/css" title="Normal Style" href="style.css" />

<script type="text/javascript">
//<![CDATA[
function checkedall(checked)
{
  for (var i = 0; i < document.forms[1].elements.length; i++) {
    document.forms[1].elements[i].checked = checked;
  }
}
//]]>
</script>



</head>
<body>
<?php
// Head
require("head.php");

// Post Variablen und Keys
$searchKey = $_POST['player'];
$searchType = "ByPlayerName";


print ("<table class=\"main\" style=\"text-align:left; margin-left:auto; margin-right:auto\" cellspacing=\"3\">\n");
print ("\n");
print ("<tr>\n");
print ("<td>\n");
include("include/menu.php");
print ("</td>\n");
print ("</tr>\n");

print ("<tr>\n");
print ("<th class=\"mainTD\" colspan=\"2\">\n");
print ("<h2>".$text['claiming']." - ".$worldname."</h2>\n");
print ("</th>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td class=\"mainTD\" valign=\"top\">\n");
print ("<form action=\"".$selffile."\" method=\"post\">\n");
print ("<fieldset>\n");
print ("<input type=\"text\" name=\"player\" value=\"".$searchKey."\" />\n");
print ("<input type=\"submit\" value=\"".$text['submitSearchButton']." ".$text['player']."\"/>\n");
print ("</fieldset>\n");
print ("</form>\n");

print ("</td>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td class=\"mainTD\" valign=\"top\">\n");

if($searchKey == "")
  {
  print ("<h3>".$text['enterSearchKeyOrder']."</h3>\n");
  }

elseif ($searchKey != "")
   {
   $debug['searchType'] =  "Search ".$searchType." for ".$searchKey;

   $debug['ReqSearchScript'] = require("include/searchByAccPlayer.php");

     $quest = searchAccPlayer($searchKey,$searchType,$rawShifter);
     // NO RESULT
     if($quest['noResult'] == "")
         {
         print ("<h3>".$text['noResult']."</h3>");
         }
     else
         {
         print ("<table class=\"preferencesTABLE\">\n");
	print ("\n");
	print ("<tr>\n");
	print ("<th rowspan=\"7\" style=\"text-align:center; \" class=\"verticalTH\">".$text['verticalPlayer']."</th>\n");
	print ("<th colspan=\"2\" class=\"horizontalTH\">".$quest['playerName']."</th>\n");
	print ("</tr>\n");
	print ("\n");
	print ("<tr><td class=\"preferencesListTD\">".$text['name'].":</td><td class=\"preferencesListTD\"><a class=\"intLink\" href=\"index.php?id=".$quest['playerId']."\">".$quest['playerName']."</a></td></tr>\n");
	print ("<tr><td class=\"preferencesListTD\">".$text['villages'].":</td><td class=\"preferencesListTD\">".$quest['playerVillages']."</td></tr>\n");
	print ("<tr><td class=\"preferencesListTD\">".$text['points'].":</td><td class=\"preferencesListTD\">".wash_number($quest['playerPoints'])."</td></tr>\n");
	print ("<tr><td class=\"preferencesListTD\">".$text['rank'].":</td><td class=\"preferencesListTD\">".$quest['playerRanking']."</td></tr>\n");
         if($quest['allyId'] == "")
           {
	  print ("<th colspan=\"2\" class=\"horizontalTH\">".$text['noTribe']."</th>\n");
           print ("</table>\n");
           }
         else
           {
	  print ("<tr><td class=\"preferencesListTD\">".$text['tribe'].":</td><td class=\"preferencesListTD\">".$quest['allyName']."</td></tr>\n");
	  print ("<tr><td class=\"preferencesListTD\">".$text['tribe']." ".$text['points'].":</td><td class=\"preferencesListTD\">".$quest['allyPoints']."</td></tr>\n");
	  print ("\n");
	  print ("</table>\n");
           }

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



$rownumber = 8 + $quest['playerVillages'];

print ("<tr>\n");

print ("<td class=\"mainTD\" valign=\"top\">\n");
print ("<form action=\"".$selffile."\" method=\"post\">\n");
print ("<div>\n");
print ("<table class=\"preferencesTABLE\">\n");
print ("<tr><th rowspan=\"".$rownumber."\" class=\"verticalTH\"></th></tr>\n");
print ("<tr><th colspan=\"2\" class=\"horizontalTH\">".$text['villageList']."</th></tr>\n");
print ("<tr><th class=\"preferencesListTD\">".$text['claim']."</th><th class=\"preferencesListTD\">".$text['name']."</th><th class=\"preferencesListTD\">".$text['coordinates']."</th><th class=\"preferencesListTD\">".$text['points']."</th></tr>\n");
print ("<tr><td colspan=\"4\" class=\"preferencesListTD\"><input type=\"checkbox\" onclick=\"checkedall(this.checked)\" id=\"input_checkall_top\"/><label for=\"input_checkall_top\">Tick all</label></td></tr>\n");
foreach($villagequest as $line)
  {
  if(isset($_POST["village_".$line['villageX']."|".$line['villageY']]))      // Look whether checkbox is ticked
    {
    print ("<tr><td class=\"preferencesListTD\"><input type=\"checkbox\" checked=\"checked\" value=\"true\" id=\"input_village_".$line['villageX']."|".$line['villageY']."\" name=\"village_".$line['villageX']."|".$line['villageY']."\" /></td><td class=\"preferencesListTD\"><a class=\"intLink\" href=\"village.php?coords=".$line['villageX']."|".$line['villageY']."\">".$line['villageName']."</a></td><td class=\"preferencesListTD\"><label for=\"input_village_".$line['villageX']."|".$line['villageY']."\">(".$line['villageX']."|".$line['villageY'].")</label> <a title=\"Ingame to (".$line['villageX']."|".$line['villageY'].")\" href=\"".$link['inGameVillage'].$line['villageID']."\"><img class=\"extLink\" alt=\"Ingame\" style=\"text-align:right; \" src=\"images/ds_extern.png\" /></a></td><td class=\"preferencesListTD\"><label for=\"input_village_".$line['villageX']."|".$line['villageY']."\">".wash_number($line['villagePoints'])."</label></td></tr>\n");
    }
  else
    {
    print ("<tr><td class=\"preferencesListTD\"><input type=\"checkbox\" value=\"true\" id=\"input_village_".$line['villageX']."|".$line['villageY']."\" name=\"village_".$line['villageX']."|".$line['villageY']."\" /></td><td class=\"preferencesListTD\"><a class=\"intLink\" href=\"village.php?coords=".$line['villageX']."|".$line['villageY']."\">".$line['villageName']."</a></td><td class=\"preferencesListTD\"><label for=\"input_village_".$line['villageX']."|".$line['villageY']."\">(".$line['villageX']."|".$line['villageY'].")</label> <a title=\"Ingame to (".$line['villageX']."|".$line['villageY'].")\" href=\"".$link['inGameVillage'].$line['villageID']."\"><img class=\"extLink\" alt=\"Ingame\" style=\"text-align:right; \" src=\"images/ds_extern.png\" /></a></td><td class=\"preferencesListTD\"><label for=\"input_village_".$line['villageX']."|".$line['villageY']."\">".wash_number($line['villagePoints'])."</label></td></tr>\n");
    }
  }
print ("<tr><td colspan=\"4\" class=\"preferencesListTD\"><input type=\"checkbox\" onclick=\"checkedall(this.checked)\" id=\"input_checkall_bottom\"/><label for=\"input_checkall_bottom\">Tick all</label></td></tr>\n");
print ("</table>\n");
print ("</div>\n");

// Start of Claimingprogram

function getVillageImgNumber($points)
  {
  if($points < 500) return 1;   // v1.png
  if($points < 1000) return 2;  // v2.png
  if($points < 3000) return 3;  // v3.png
  if($points < 9000) return 4;  // v4.png
  else return 5;                // v5.png
  }

// Post Variablen
$bulletType = $_POST['bulletType'];
$ownbulletText = $_POST['ownbulletText'];
$owndynbulletText = $_POST['owndynbulletText'];
if($owndynbulletText) $owndynbulletTextf = explode("%i%",$owndynbulletText);
if(!isset($_POST['owndynbulletText'])) $owndynbulletText = "%i%";

print ("<div>\n");
print ("<input type=\"hidden\" name=\"player\" value=\"".$searchKey."\" />\n");

print ("<br />Bullet Type:\n");
if($bulletType == "img") $img = "checked=\"checked\"";
elseif($bulletType == "circles") $circles = "checked=\"checked\"";
elseif($bulletType == "numbers") $numbers = "checked=\"checked\"";
elseif($bulletType == "ownbullet") $ownbullet = "checked=\"checked\"";
elseif($bulletType == "owndynbullet") $owndynbullet = "checked=\"checked\"";

print ("<br /><input type=\"radio\" name=\"bulletType\" id=\"input_bulletType_img\" value=\"img\" ".$img."/><label for=\"input_bulletType_img\"> Images</label>\n");

print ("<br /><input type=\"radio\" name=\"bulletType\" id=\"input_bulletType_circles\" value=\"circles\"".$circles."/><label for=\"input_bulletType_circles\"> Circles</label>\n");

print ("<br /><input type=\"radio\" name=\"bulletType\" id=\"input_bulletType_numbers\" value=\"numbers\"".$numbers."/><label for=\"input_bulletType_numbers\"> Numbered</label>\n");

print ("<br /><input type=\"radio\" name=\"bulletType\" id=\"input_bulletType_ownbullet\" value=\"ownbullet\"".$ownbullet."/><label for=\"input_bulletType_ownbullet\"> Own Bullet: </label><input type=\"text\"/ value=\"".$ownbulletText."\" name=\"ownbulletText\"/> (BB-Codes allowed)\n");

print ("<br /><input type=\"radio\" name=\"bulletType\" id=\"input_bulletType_owndynbullet\" value=\"owndynbullet\"".$owndynbullet."/><label for=\"input_bulletType_owndynbullet\"> Own Dynamic Bullet: </label><input type=\"text\"/ value=\"".$owndynbulletText."\" name=\"owndynbulletText\"/>( %i% is the counter variable) \n");


print ("<br />\n");
print ("<input type=\"submit\" value=\"Generate\"/>\n");
print ("<br />\n");
print ("<br />\n");

$code = "[i][size=14][url=claiming.php]Village Reservation[/url][/size] (".date("l, n F Y - G:i",time()).")[/i]\n\n";

$code .= "[size=12][u][url=index.php?id=".$quest['playerId']."]Player[/url][/u][/size]\n";
$code .= "Name: [player]".$quest['playerName']."[/player]\n";
$code .= "Points: [b]".$quest['playerPoints']."[/b]\n";
$code .= "Villages: [b]".$quest['playerVillages']."[/b]\n";
$code .= "Rank: [b]".$quest['playerRanking']."[/b]\n\n";

$code .= "[size=12][u]Tribe[/u][/size]\n";
$code .= "Name: [ally]".$quest['allyTag']."[/ally] (".$quest['allyFullname'].")\n";
$code .= "Points: [b]".$quest['allyPoints']."[/b]\n";
$code .= "Members: [b]".$quest['allyMembers']."[/b]\n";
$code .= "Rank: [b]".$quest['allyRank']."[/b]\n\n";



$entries = 0;
$i = 0;
foreach($_POST as $key => $value)
  {
  if(eregi("village",$key))
    {
    $koords = explode("_", $key);
    $koords = $koords[1];
    foreach($villagequest as $data)
      {
      if($data["villageX"]."|".$data["villageY"] == $koords)
        {
        $i++;
        if($bulletType == "img") $bullet = "[img]graphic/map/v".getVillageImgNumber($data['villagePoints']).".png[/img]";
        elseif($bulletType == "circles") $bullet = "[b]•[/b]";
        elseif($bulletType == "numbers") $bullet = "[b]".$i."[/b]";
        elseif($bulletType == "ownbullet") $bullet = $ownbulletText;
        elseif($bulletType == "owndynbullet") $bullet = $owndynbulletTextf[0].$i.$owndynbulletTextf[1];
        $newline = "[color=#F1EBDD]---[/color] ".$bullet." [village](".$data["villageX"]."|".$data["villageY"].")[/village] [b]".wash_number($data['villagePoints'])."P[/b]\n\n";
        $claims[$entries] = $newline;
        $entries++;
        }
      }


    }
  }

if($entries > 0)
  {
  $code .= "[size=12][u]Claimed Villages:[/u][/size]\n\n";
  }
else
  {
  $code .= "[size=12][u]Claimed Village:[/u][/size]\n\n";
  }

if($claims) foreach($claims as $line)
$code .= $line;


print ("<textarea rows=\"10\" cols=\"60\">");
print ($code);
print ("</textarea>\n");

print ("</div>\n");

print ("</form>\n");





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