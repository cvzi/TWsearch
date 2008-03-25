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

// Post Variablen und Keys
if(isset($_GET['villageOne']) and isset($_GET['villageTwo']))
{
$villageOne = $_GET['villageOne'];
$villageTwo = $_GET['villageTwo'];
}

// Laufzeiten Funktion
function calcDistance($villageOne,$villageTwo,$speed,$format = true)
  {
  require("translation.php");
  $villageOne = explode("|",$villageOne);
  $x1 = str_replace("(","",$villageOne[0]);
  $y1 = str_replace(")","",$villageOne[1]);

  $villageTwo = explode("|",$villageTwo);
  $x2 = str_replace("(","",$villageTwo[0]);
  $y2 = str_replace(")","",$villageTwo[1]);


  $time = sqrt(pow($x1 - $x2, 2) + pow($y1 - $y2, 2)) * $speed;
  $hours = floor(($time * 60) / 3600);
  if($hours < 10) $hours = "0".$hours;
  $minutes = floor($time) - ($hours * 60);
  if($minutes < 10) $minutes = "0".$minutes;
  $seconds = round(fmod($time * 60, 60),0);
  if($seconds < 10) $seconds = "0".$seconds;

  if($hours > 48)
    {
    $days = $hours / 24;
    $hoursday = $days - floor($days);
    $hoursday = round($hoursday * 24);
    $days = floor($days);
    }
  else
    {
    $days = false;
    }
  if(!$format)
    {
    $output = array("hours" => $hours,
                    "minutes" => $minutes,
                    "seconds" => $seconds,
                    "x1" => $x1,
                    "y1" => $y1,
                    "x2" => $x2,
                    "y2" => $y2);
    }
  elseif($days)
    {
    $output = $days." ".$text['days']." ".$hoursday.":".$minutes.":".$seconds." (".$hours.":".$minutes.":".$seconds.")";
    }
  else
    {
    $output = $hours.":".$minutes.":".$seconds;
    }
  return $output;
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
print ("<h2 align=\"center\">".$text['distanceCalculator']." - ".$worldname."</h2>\n");
print ("</th>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td class=\"mainTD\" valign=\"top\">\n");
print ("<form action=\"".$selffile."\" method=\"get\">\n");

print ("<fieldset>\n");
print ("<legend>".$text['distanceCalculator']."</legend>\n");
print ("<table>\n");
print ("<tr><td>".$text['originVillage']."</td><td><input type=\"text\" size=\"7\" id=\"input_villageOne\" name=\"villageOne\" value=\"".$villageOne."\" /></td></tr>\n");
print ("<tr><td>".$text['targetVillage']."</td><td><input type=\"text\" size=\"7\" id=\"input_villageTwo\" name=\"villageTwo\" value=\"".$villageTwo."\" /></td></tr>\n");
print ("<tr><td colspan=\"2\"><input type=\"submit\" value=\"&raquo; ".$text['calculate']."\"/></td></tr>\n");
print ("</table>\n");
print ("</fieldset>\n");

print ("</form>\n");

if(isset($villageOne) and isset($villageTwo))
{
print ("<table class=\"semitransparent-BorderTABLE\">\n");
print ("<tr>\n");
print ("<th>".$text['units'].":</th><th>".$text['duration'].":</th>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td><img src=\"unit/unit_spear.png\" alt=\"\"/>".$text['spearFighter']."</td>\n");
print ("<td><img src=\"images/units/speed.png\" alt=\"\"/>".calcDistance($villageOne,$villageTwo,18)."</td>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td><img src=\"unit/unit_sword.png\" alt=\"\"/>".$text['swordsMan']."</td>\n");
print ("<td><img src=\"images/units/speed.png\" alt=\"\"/>".calcDistance($villageOne,$villageTwo,22)."</td>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td><img src=\"unit/unit_axe.png\" alt=\"\"/>".$text['axeMan']."</td>\n");
print ("<td><img src=\"images/units/speed.png\" alt=\"\"/>".calcDistance($villageOne,$villageTwo,18)."</td>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td><img src=\"unit/unit_archer.png\" alt=\"\"/>".$text['archer']."</td>\n");
print ("<td><img src=\"images/units/speed.png\" alt=\"\"/>".calcDistance($villageOne,$villageTwo,18)."</td>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td><img src=\"unit/unit_spy.png\" alt=\"\"/>".$text['scout']."</td>\n");
print ("<td><img src=\"images/units/speed.png\" alt=\"\"/>".calcDistance($villageOne,$villageTwo,9)."</td>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td><img src=\"unit/unit_light.png\" alt=\"\"/>".$text['lightCavalry']."</td>\n");
print ("<td><img src=\"images/units/speed.png\" alt=\"\"/>".calcDistance($villageOne,$villageTwo,10)."</td>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td><img src=\"unit/unit_marcher.png\" alt=\"\"/>".$text['mountedArcher']."</td>\n");
print ("<td><img src=\"images/units/speed.png\" alt=\"\"/>".calcDistance($villageOne,$villageTwo,10)."</td>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td><img src=\"unit/unit_heavy.png\" alt=\"\"/>".$text['heavyCavalry']."</td>\n");
print ("<td><img src=\"images/units/speed.png\" alt=\"\"/>".calcDistance($villageOne,$villageTwo,11)."</td>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td><img src=\"unit/unit_ram.png\" alt=\"\"/>".$text['ram']."</td>\n");
print ("<td><img src=\"images/units/speed.png\" alt=\"\"/>".calcDistance($villageOne,$villageTwo,30)."</td>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td><img src=\"unit/unit_catapult.png\" alt=\"\"/>".$text['catapult']."</td>\n");
print ("<td><img src=\"images/units/speed.png\" alt=\"\"/>".calcDistance($villageOne,$villageTwo,30)."</td>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td><img src=\"unit/unit_knight.png\" alt=\"\"/>".$text['paladin']."</td>\n");
print ("<td><img src=\"images/units/speed.png\" alt=\"\"/>".calcDistance($villageOne,$villageTwo,10)."</td>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td><img src=\"unit/unit_snob.png\" alt=\"\"/>".$text['nobleman']."</td>\n");
print ("<td><img src=\"images/units/speed.png\" alt=\"\"/>".calcDistance($villageOne,$villageTwo,35)."</td>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td><img src=\"images/units/booty.png\" alt=\"\"/>".$text['merchants']."</td>\n");
print ("<td><img src=\"images/units/speed.png\" alt=\"\"/>".calcDistance($villageOne,$villageTwo,6)."</td>\n");
print ("</tr>\n");
print ("</table>\n");
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