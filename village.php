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
<!--[if gte IE 5.5]>
<style type="text/css">
/* unnoetiger style */
input[type='text'] {
                 background-color:white;
                 color:black;
                 border-color:palegoldenrod;
                 border-width:1px;
                 border-style:solid; }
body:after {
    content: "This website uses HTML, but your browser does not support HTML, sorry.";
    display: block;
    font-size:larger;
    text-align: center;
}

</style>
<![endif]-->


</head>
<body>
<?php
// Head
require("head.php");

if(isset($id) == false and isset($coords) == false)
{
$searchKey = $_POST['searchKey'];
$searchType = $_POST['searchType'];
}
elseif(isset($id) == true)
{
$searchKey = $id;
$searchType = "id";
}
elseif(isset($coords) == true)
{
$searchKey = $coords;
$searchType = "coords";
}



print ("<table class=\"main\" align=\"center\" cellspacing=\"3\">\n");
print ("\n");

print ("<tr>\n");
print ("<td>\n");
include("include/menu.php");
print ("</td>\n");
print ("</tr>\n");

print ("<tr>\n");
print ("<th class=\"mainTD\" colspan=\"2\">\n");
print ("<h2 align=\"center\">".$text['searchVillage']." - ".$worldname."</h2>\n");
print ("</th>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td class=\"mainTD\" valign=\"top\">\n");
print ("<form action=\"".$selffile."\" method=\"post\">\n");
print ("<input type=\"text\" name=\"searchKey\" value=\"$searchKey\" />\n");

print ("<select name=\"searchType\">\n");

if($searchType == "id")
  {
  print ("<option value=\"coords\">".$text['coordinates']."</option>\n");
  print ("<option selected=\"selected\" value=\"id\">".$text['id']."</option>\n");
  }
else
  {
  print ("<option selected=\"selected\" value=\"coords\">".$text['coordinates']."</option>\n");
  print ("<option value=\"id\">".$text['id']."</option>\n");
  }

print ("</select>\n");

print ("<input type=\"submit\" value=\"".$text['submitSearchButton']."\"/>\n");

print ("</form>\n");

print ("</div>\n");
print ("</td>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td class=\"mainTD\" valign=\"top\">\n");

if($searchKey == "")
  {
  echo "<h3>".$text['enterSearchKeyOrder']."</h3>";

  }

elseif ($searchKey != "")
   {
   $debug['searchType'] =  "Search ".$searchType." for ".$searchKey;

   $debug['ReqSearchScript'] = require("include/searchByAccPlayer.php");
   $searchType = "coords";
   if($searchType == "coords")
     {
     $debug['ReqVillageScript'] = require("include/function.getSpecificVillage.php");
     $villagequest = getSpecificVillage($searchKey,"coords",$rawShifter);
     }
   elseif($searchType == 'ByPlayerId')
     {
     $quest = searchAccPlayer($searchKey,$searchType,$rawShifter,$number);
     }

     // NO RESULT
     if($villagequest['noResult'] == true)
         {
         print ("<h3>".$text['noResult']."</h3>");
         }
     else
         {




// Dörfer Data
// --------------


// Errechne Dörfer:


  if($villagequest['villagePlayerName'] == "-aband")
    {
    $owner = "<span class=\"semi-transparentFont\">".$text['abandoned']."</span>";
    }
  else
    {
    $owner = "<a class=\"intLink\" href=\"index.php?id=".$villagequest['villagePlayer']."\">".$villagequest['villagePlayerName']."</a></td><td class=\"preferencesListTD\"><a class=\"extLink\"  title=\"Ingame to ".$villagequest['villagePlayerName']."\" href=\"".$link['inGamePlayer'].$villagequest['villagePlayer']."\">Ingame <img alt=\"Ingame\" align=\"right\" src=\"images/ds_extern.png\" /></a>";
    }






print ("<tr>\n");

print ("<td class=\"mainTD\" valign=\"top\">\n");
print ("<div>\n");

$tablerows = count($villagequest['conquer']) + 7;
print ("<table class=\"preferencesTABLE\">\n");
print ("<tr>\n");
print ("<th rowspan=\"".$tablerows."\" style=\"text-align:center; \" class=\"verticalTH\">".$text['verticalSpecific']."</th>\n");
print ("<th colspan=\"2\" class=\"horizontalTH\">".$text['village']."</th>\n");
print ("</tr>\n");
print ("<tr><td class=\"preferencesListTD\">".$text['name'].":</td><td class=\"preferencesListTD\">".$villagequest['villageName']."</td></tr>\n");
print ("<tr><td class=\"preferencesListTD\">".$text['coordinates'].":</td><td class=\"preferencesListTD\">".$villagequest['villageX']."|".$villagequest['villageY']."</td>\n");
  print ("<td class=\"preferencesListTD\"><a class=\"extLink\" title=\"Ingame to (".$villagequest['villageX']."|".$villagequest['villageY'].")\" href=\"".$link['inGameVillage'].$villagequest['villageID']."\">Ingame <img alt=\"Ingame\" align=\"right\" src=\"images/ds_extern.png\" /></a></td></tr>\n");
print ("<tr><td class=\"preferencesListTD\">".$text['points'].":</td><td class=\"preferencesListTD\">".$villagequest['villagePoints']."</td></tr>\n");
print ("<tr><td class=\"preferencesListTD\">".$text['owner'].":</td><td class=\"preferencesListTD\">".$owner."</td></tr>\n");



print ("<tr><th colspan=\"2\" class=\"preferencesListTD\">".$text['conquests']."</th><th class=\"preferencesListTD\">".$text['oldPlayer']."</th><th class=\"preferencesListTD\">".$text['newPlayer']."</th></tr>\n");

if(isset($villagequest['conquer']))
{
foreach($villagequest['conquer'] as $line)
  {
  if($line['oldPlayerName'] == "-aband")
    {
    $oldPlayer = "<span class=\"semi-transparentFont\">".$text['abandoned']."</span>";
    }
  elseif($line['oldPlayerName'] == "-del")
    {
    $oldPlayer = "<span class=\"semi-transparentFont\">".$text['deletedPlayer']."</span>";
    }
  else
    {
    $oldPlayer = "<a class=\"intLink\" href=\"".$line['oldPlayer']."\">".$line['oldPlayerName']."</a>";
    }

  if($line['newPlayerName'] == "-aband")
    {
    $newPlayer = "<span class=\"semi-transparentFont\">".$text['abandoned']."</span>";
    }
  elseif($line['newPlayerName'] == "-del")
    {
    $newPlayer = "<span class=\"semi-transparentFont\">".$text['deletedPlayer']."</span>";
    }
  else
    {
    $newPlayer = "<a class=\"intLink\" href=\"".$line['newPlayer']."\">".$line['newPlayerName']."</a>";
    }

  $conqDay = date("n",$line['timestamp']);
  $conqRest = date(" F Y",$line['timestamp']);

  if($conqDay == 1)
    { $conqDay = "1st"; }
  elseif($conqDay == 2)
    { $conqDay = "2nd"; }
  elseif($conqDay == 3)
    { $conqDay = "3rd"; }
  elseif($conqDay == 31)
    { $conqDay = "31st"; }
  else
    { $conqDay = $conqDay."th"; }

  $conqDate = $conqDay.$conqRest;
  $conqTime = date("G:i:s",$line['timestamp']);  ;

  print ("<tr><td class=\"preferencesListTD\">".$conqDate."</td><td class=\"preferencesListTD\">".$conqTime."</td><td class=\"preferencesListTD\">".$oldPlayer."</td><td class=\"preferencesListTD\">".$newPlayer."</td></tr>\n");
  }
}
else
{
  print ("<tr><td style=\"text-align:center; \" colspan=\"5\" class=\"preferencesListTD\"> - ".$text['noConquests']." - </td></tr>\n");
}
print ("</table>\n");

print ("</div>\n");
print ("</td>\n");








print ("</tr>\n");
   }


   }



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
print ("<tr><td class=\"preferencesListTD\">Require villagescript:</td>\n");
print ("<td class=\"preferencesListTD\">".checkCorrect($debug['ReqVillageScript'])."</td></tr>\n");
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