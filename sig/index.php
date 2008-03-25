<?php
require("../version.php");
// Statistik
require("../include/function.stats.php");

$directory = opendir("cache");
$numerator = 0;

while (false !== ($file = readdir($directory)))
  {
  if ($file != "." && $file != "..")
     {
     $cache = unlink("cache/".$file);
     }
  }

closedir($directory);


if(isset($name))
{
if($name == "") { exit("<h1>Wrong Name!</h1>"); }



if(isset($old))
  {
  $createPNGFromFileName = "oldsig.png";
  }
else
  {
  $createPNGFromFileName = "withchartsig.png";
  }



#########################
# Spielerinfo bekommen: #
#########################

// Head
require("../translation.php");  
require("../include/mysql.php");
require("../include/getTableNames.php");
require("../include/function.wash_number.php");

$debug[4] = require("searchByAccPlayer.php");
$quest = searchAccPlayer($name,'ByPlayerName','raw','tw_5');

if($quest['playerName'] == "") { exit("<h1>Wrong Name!</h1>"); }

// Daten korrigieren / formatieren

if($quest['playerPoints'] > 9000000)
{
$quest['playerPoints'] = $quest['playerPoints'] / 10000000;
$quest['playerPoints'] = round($quest['playerPoints'],3);
$quest['playerPoints'] = $quest['playerPoints']. " MP";
}

elseif($quest['playerPoints'] > 10000)
{
$quest['playerPoints'] = $quest['playerPoints'] / 1000;
$quest['playerPoints'] = round($quest['playerPoints'],1);
$quest['playerPoints'] = $quest['playerPoints']. " KP";
}

else
{
$quest['playerPoints'] = $quest['playerPoints']. " P";
}



$allyPoints = explode(",",$quest['allyPoints']);

if($allyPoints[0] > 9000000)
{
$allyPoints[0] = $allyPoints[0] / 1000000;
$allyPoints[0] = round($allyPoints[0],3);
$allyPoints[0] = $allyPoints[0]. " MP";
}

elseif($allyPoints[0] > 10000)
{
$allyPoints[0] = $allyPoints[0] / 1000;
$allyPoints[0] = round($allyPoints[0],1);
$allyPoints[0] = $allyPoints[0]. " KP";
}
else
{
$allyPoints[0] = $allyPoints[0]. " P";
}


$quest['playerName'] = urldecode($quest['playerName']);

$quest['allyName'] = urldecode($quest['allyName']);


if($quest['allyName'] == "")
{
$tribestring = " - Tribeless -";
}
else
{
$tribestring = $quest['allyName']."  ".$allyPoints[0];
}



#########################
# Grafik erstellen:     #
#########################
Header("Content-Type: image/png");
##################################################
$width = 400; # Später die Breite des Rechtecks
$height = 60; # Später die Höhe des Rechtecks
//$img = ImageCreate($width, $height); # Hier wird das Bild einer Variable zu gewiesen
$img = ImageCreateFromPNG($createPNGFromFileName);
##################################################


##################################################
$black = ImageColorAllocate($img, 0, 0, 0); # Hier wird die Farbe schwarz einer Variable zugewiesen
$red = ImageColorAllocate($img, 255, 0, 0); # Hier wird die Farbe rot einer Variable zugewiesen
$yellow = ImageColorAllocate($img, 255, 255, 0); # Hier wird die Farbe gelb einer Variable zugewiesen
$green = ImageColorAllocate($img, 0, 255, 0);
$white = ImageColorAllocate($img, 255, 255, 255);
$dsfont = ImageColorAllocate($img, 128, 64, 0);
##################################################

/*
##################################################
ImageFill($img, 0, 0, $yellow); # Erst wird das Bild mit gelb gefüllt.
ImageFilledRectangle($img, 0, 0, 300, 100, $black); # Mit ImageFillRectangle wird ein weiter Bereich des Bildes mit schwarz gefüllt
# Die 1. 0 ist die Entfernung in px von Links.
# Die 2. 0 ist die Entfernung in px von Oben.
# Die 300 ist die Breite der Farbe.
# Die 100 ist die Höhe der Farbe.
ImageFilledRectangle($img, 0, 200, 300, 100, $red);
# Hier die gleichen Sachen wie bei der Schwarzfüllung, nur mit anderen Koordinaten und anderer Farbe.

ImageArc($img, 50, 50, 90, 20, 1, 180, $green);

*/


$fontone = 3;
ImageString($img, $fontone, 6, 10, $quest['playerName'], $dsfont);
ImageString($img, $fontone, 156, 10, "Points ".$quest['playerPoints'], $dsfont);
ImageString($img, $fontone, 6, 40, $tribestring, $dsfont);
//ImageString($img, $fontone, 6, 40, "Tribe: ".$allyPoints[0], $dsfont);
ImageString($img, 5, 156, 40, $worldname, $dsfont);
ImageString($img, 1, 260, 32, $version, $dsfont);

ImageString($img, 1, 5, 3, "Player", $dsfont);
ImageString($img, 1, 5, 33, "Tribe", $dsfont);
# Die 2 steht für die GD-Lib interne Schriftart (es gibt insgesamt 5, also probierts aus).
# Die 225 steht für die Position von Links, also 26px von Links entfernt.
# Die 100 steht für die Postion von Oben, also 20px von oben entfernt.
# Der Text, ist der, der später im Bild erscheinen soll.
# $white steht für die Farbe die der Text haben soll.
###################################################




$id = $quest['playerId'];

$timestamp = time();

$day = date("d",$timestamp);
$month = date("m",$timestamp);
$year = date("Y",$timestamp);










$debug = array();

// Verbinden mit MySQL
$db_link =  @mysql_connect("localhost","phost100057","asdfghjkl");
@mysql_select_db("phost100057", $db_link);


function quest($key,$date)
{

$timestamp = time();
if(date("T") == 1)   // Leapyear or not
  {
  $daysPerMonth = array("0","31","29","31","30","31","30","31","31","30","31","30","31");  // February = 29 days
  }
else
  {
  $daysPerMonth = array("0","31","28","31","30","31","30","31","31","30","31","30","31");  // February = 28 days
  }
$day = date("d",$timestamp);
$month = date("m",$timestamp);
$year = date("Y",$timestamp);

$month = intval($month);
$day = intval($day);
$date = intval($date);

$day = $day - $date;

if($day <= 0)
  {
  $day = $day - 1;
  $month = $month - 1;
  $decreasedDay = $day + 1;
  $day = $daysPerMonth[intval($month)] + $decreasedDay;
  }




  if($month < 10)
    {
    $month = "0".$month;
    }
  if($day < 10)
    {
    $day = "0".$day;
    }




$table = "tw5_dia_day_".$year."-".$month."-".$day;


  // Konkret:
  //$abfrage = "SELECT * FROM `tw5_dia_day_2008-01-24` WHERE `id` LIKE '1179126'";

$abfrage = "SELECT * FROM `".$table."` WHERE `id` LIKE '".$key."'";

  $ergebnis = mysql_query($abfrage);


  $row = mysql_fetch_object($ergebnis);

    $quest = $row->points;

return $quest;
}





include ("src/jpgraph.php");
include ("src/jpgraph_line.php");

// Die Werte der Linie in ein Array speichern
$day00 = @quest($id,"0");
$day01 = @quest($id,"1");
$day02 = @quest($id,"2");
$day03 = @quest($id,"3");
$day04 = @quest($id,"4");
$day05 = @quest($id,"5");
$day06 = @quest($id,"6");
$day07 = @quest($id,"7");

$ydata = array($day07,$day06,$day05,$day04,$day03,$day02,$day01,$day00);

// Grafik generieren und Grafiktyp festlegen
$graph = new Graph(100,60,"auto");
$graph->SetScale("textlin");


// Die Linie generieren
$lineplot=new LinePlot($ydata);

// Die Linie zu der Grafik hinzufügen
$graph->Add($lineplot);


$graph->SetBackgroundImage("bg.png",BGIMG_COPY);



$graph->xaxis->SetColor("darkred");
$graph->yaxis->SetColor("darkred");
$graph->yaxis->Hide();
$graph->xaxis->HideLabels();



$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);


$lineplot->SetColor("darkred");
$lineplot->SetWeight(1);

// Kein Rand
$graph->SetFrame(false);

// Grafik anzeigen
$filename = "cache/playerSig_".$id.".png";
$graph->Stroke($filename);

$data = ImageCreateFromPNG($filename);

ImageCopy($img,$data,"300","0","0","0","100","60");



ImagePNG($img); # Hier wird das Bild PNG zugewiesen
ImageDestroy($img); # Hier wird der Speicherplatz für andere Sachen geereinigt












}
else
{
require("../include/function.getCookiesUsercp.php");
$cookieData = getCookiesUsercp(1);

// Zeit für die Aufbauzeit speichern
$time_start = microtime(true);
// ############################

// Array für Debug erstellen
$debug = array();

// Statistik
$debug['ReqStats'] = require("../include/function.stats.php");

// Eigener Dateiname für Formulare
if(isset($debugmode)) { $selffile = $_SERVER['PHP_SELF']."?debugmode"; }
else { $selffile = $_SERVER['PHP_SELF']; }
$debug['selffile'] = $selffile;

// Text - Translation
$debug['ReqTranslation'] = require("../translation.php");

// Number Format
require("../include/function.wash_number.php");

// Verbinden mit MySQL
require("../include/mysql.php");

// Tabellennamen
require("../include/getTableNames.php");


// Post Variable
$key = $_POST['key'];

print ("<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>\n");
print ("<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"\n");
print ("    \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n");
print ("<html xmlns=\"http://www.w3.org/1999/xhtml\">\n");
print ("<head>\n");
print ("<title>TW-Search</title>\n");
print ("<link rel=\"stylesheet\" type=\"text/css\" title=\"User Style\" href=\"".$cookieData['personalCSS']."\" />\n");
print ("<link rel=\"alternate stylesheet\" type=\"text/css\" title=\"Old Style\" href=\"../oldstyle.css\" />\n");
print ("<link rel=\"alternate stylesheet\" type=\"text/css\" title=\"Normal Style\" href=\"../style.css\" />\n");

// Style für Internet Explorer
print ("<!--[if gte IE 5.5]>\n");
print ("<style type=\"text/css\">\n");
print ("input[type='text'] {\n");
print ("                 background-color:white;\n");
print ("                 color:black;\n");
print ("                 border-color:palegoldenrod;\n");
print ("                 border-width:1px;\n");
print ("                 border-style:solid; }\n");
print ("\n");
print ("</style>\n");
print ("<![endif]-->\n");
// Ende Style für Internet Explorer


print ("</head>\n");
print ("<body>\n");


print ("<table class=\"main\" align=\"center\" cellspacing=\"3\">\n");
print ("\n");

print ("<tr>\n");
print ("<td>\n");
include("../include/menu.php");
print ("</td>\n");
print ("</tr>\n");

print ("<tr>\n");
print ("<th class=\"mainTD\" colspan=\"2\">\n");
print ("<h2 align=\"center\">".$text['headingGenerateSignatur']." - World 5</h2>\n");
print ("</th>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td class=\"mainTD\" valign=\"top\">\n");
print ("<form action=\"".$selffile."\" method=\"post\">\n");

print ("Name: <input type=\"text\" name=\"key\" value=\"$key\" />\n");

print ("<input type=\"submit\" value=\"".$text['submitOkayButton']."\"/>\n");

print ("</form>\n");

print ("</td>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td class=\"mainTD\" valign=\"top\">\n");
print ("<h4>".$text['forumCode']."</h4>\n");

if($key != "")
  {
  $key = urldecode($key);
  $code = "[URL=/index.php?name=".$key."][IMG]/sig/?name=".$key."[/IMG][/URL]";
  $length = strlen($code);
  }
else
  {
  $code = "Please enter a name!";
  }
print ("<input onfocus=\"this.select()\" onchange=\"this.value = '".$code."'\" \n type=\"text\" size=\"".$length."\" \n value=\"".$code."\">\n");
print ("<br />\n");

if($key != "")
  {
  print ("<a href=\"/sig/?name=".$key."\" onClick=\"fenster = window.open('/sig/?name=".$key."', '".$text['preview']."', 'width=405,height=65,status=no,scrollbars=no,resizable=no'); fenster.focus(); return false;\">".$text['preview']."</a>\n");
  }

print ("</td>\n");
print ("</tr>\n");

// Old Version
print ("<tr>\n");
print ("<td class=\"mainTD\" valign=\"top\">\n");
print ("<h4>".$text['forumCodeOld']."</h4>\n");
if($key != "")
  {
  $key = urldecode($key);
  $code = "/index.php?name=".$key."][IMG]/sig/?name=".$key."&old[/IMG][/URL]";
  $length = strlen($code);
  }
else
  {
  $code = "Please enter a name!";
  }
print ("<input onfocus=\"this.select()\" \n onchange=\"this.value = '".$code."'\" \n type=\"text\" size=\"".$length."\" \n value=\"".$code."\">\n");
print ("<br />\n");

if($key != "")
  {
  print ("<a href=\"/sig/?name=".$key."&old\" onClick=\"fenster = window.open('/sig/?name=".$key."&old', '".$text['preview']."', 'width=405,height=65,status=no,scrollbars=no,resizable=no'); fenster.focus(); return false;\">".$text['preview']."</a>\n");
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

require("../foot.php");
print ("\n");
print ("</body>\n");
print ("</html>\n");

}


?>