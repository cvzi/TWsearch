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


<script type="text/javascript">
//<![CDATA[

function showRankDataOf(playerid,action)
  {
  document.getElementById("infobox").style.display = 'block';
  document.getElementById("infobox").innerHTML = "<img alt=\"Loading\" src=\"images/loader.gif\"/>";
  ajaxGet(playerid);
  }



// Gibt das HTTP-Request Objekts zurück
function getXMLHttpRequestObject() {
    var requestObject;
    var browser = navigator.appName;
    if(browser == "Microsoft Internet Explorer") {
        requestObject = new ActiveXObject("Microsoft.XMLHTTP");
    }else{
        requestObject = new XMLHttpRequest();
    }
    return requestObject;
}

// Löst eine Get-Anfrage an das Script ajaxResponse.php aus
function ajaxGet(player) {
    document.body.style.cursor = 'wait';
    httpRequestObject.open('GET', '/ajaxplayer.php?id='+player);
    httpRequestObject.onreadystatechange = ajaxEvent;
    httpRequestObject.send(null);
}

// Diese Funktion wird aufgerufen, wenn eine Ajax-Anfrage abgesendet wurde.
function ajaxEvent() {
        // Ajax-Anfrage erfolgreich?
    if(httpRequestObject.readyState == 4){
        // Holt die Antwort aus der Anfrage
        var ajaxResponse = httpRequestObject.responseText;
        // Ändert den Textinhalt, des HTML-Elements mit der ID ajax
                document.getElementById('infobox').innerHTML = ajaxResponse;
                document.body.style.cursor = 'default';
    }
}

// Holen des HTTP-Request Objekts
var httpRequestObject = getXMLHttpRequestObject();


//]]>
</script>



</head>
<body>
<?php
// Head
require("head.php");


print ("<table class=\"main\" style=\"text-align:left; margin-right:auto; margin-left:auto; \" cellspacing=\"3\">\n");
print ("\n");

print ("<tr>\n");
print ("<td>\n");
include("include/menu.php");
print ("</td>\n");
print ("</tr>\n");

print ("<tr>\n");
print ("<th class=\"mainTD\" colspan=\"2\">\n");
print ("<h2>".$text['ranking']." - ".$worldname."</h2>\n");
print ("<h4>".$text['klickLineForMoreDetails']."</h4>\n");
print ("</th>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td class=\"mainTD\" valign=\"top\">\n");

if(!isset($page) and $cookieData['ownAccRanking'])
  {
  $rank = mysql_fetch_object(mysql_query("SELECT `rank` FROM `".$playertable."` WHERE `name` LIKE '".urlencode($cookieData['ingameName'])."' LIMIT 0 , 1"))->rank;
  $page = ceil($rank / 20);
  }
elseif($page == 0 or $page > ceil(mysql_fetch_object(mysql_query("SELECT COUNT( `rank` ) AS `rank` FROM `".$playertable."`"))->rank / 20))
  {
  $page = 1;
  }
elseif(!isset($page) and !$cookieData['ownAccRanking'])
  {
  $page = 1;
  }


$debug['searchType'] =  "Search page #".$page;
$debug['ReqSearchScript'] = require("include/searchRankingByPage.php");

$player = $_GET['player'];
if(!isset($player) and !isset($id))
  {
  if(isset($advanced)) $advanced = true;
  else $advanced = false;
  $quest = searchRankingByPage($page,$rawShifter,$advanced);
  }
elseif(isset($player))
  {
  if(!mysql_fetch_object(mysql_query("SELECT `rank` FROM `".$playertable."` WHERE `name` LIKE '".urlencode($player)."' LIMIT 0 , 1"))->rank)
    {
    $quest['noResult'] = true;
    }
  else
    {
    $rank = mysql_fetch_object(mysql_query("SELECT `rank` FROM `".$playertable."` WHERE `name` LIKE '".urlencode($player)."' LIMIT 0 , 1"))->rank;
    $page = ceil($rank / 20);
    if(isset($advanced)) $advanced = true;
    else $advanced = false;
    $quest = searchRankingByPage($page,$rawShifter,$advanced);
    }
  }
elseif(isset($id))
  {
  $rank = mysql_fetch_object(mysql_query("SELECT `rank` FROM `".$playertable."` WHERE `id` LIKE '".$id."' LIMIT 0 , 1"))->rank;
  $page = ceil($rank / 20);
  if(isset($advanced)) $advanced = true;
  else $advanced = false;
  $quest = searchRankingByPage($page,$rawShifter,$advanced);
  }

$debug['SuffixScript'] = require("include/function.englishNumerationSuffix.php");

     // NO RESULT
     if($quest['noResult'])
         {
         print ("<h3>".$text['noResult']."</h3>");

	print ("<form action=\"".$selffile."\" method=\"get\"><input type=\"text\" name=\"player\" id=\"key\" value=\"\"/>\n");
	print ("<fieldset><input type=\"button\" value=\"".$text['page']."\" onclick=\"javascript:var key = document.getElementById('key').value; var url = '".$_SERVER['PHP_SELF']."?page=' + key; window.location.href = url;;\" />\n");
	print ("<input type=\"button\" value=\"".$text['rank']."\" onclick=\"javascript:var key = parseInt(document.getElementById('key').value); if(key < 20) {page = 1; } else { page = key / 20; } var url = '".$_SERVER['PHP_SELF']."?rank=' + key + '&page=' + page; window.location.href = url;\" />\n");
	print ("<input type=\"button\" onclick=\"submit();\" value=\"".$text['player']."\" /></fieldset></form>\n");
         }
     else
         {
         print ("<table style=\"font-size:small; \" class=\"preferencesTABLE\">\n");
	print ("\n");
	print ("<tr>\n");
	print ("<th rowspan=\"22\" style=\"text-align:center; \" class=\"verticalTH\">".$text['verticalRanking']."</th>\n");
	print ("<th colspan=\"2\" class=\"horizontalTH\">".$text['page'].": #".$page."</th>\n");
	print ("</tr>\n");
	print ("\n");
         if($advanced) $advanced = "<th class=\"preferencesListTD\">".$text['tribe']."</th><th class=\"preferencesListTD\">".$text['totalBashingRank']."</th><th class=\"preferencesListTD\">".$text['totalKills:Points']."</th><th class=\"preferencesListTD\">".$text['defBashingRank']."</th><th class=\"preferencesListTD\">".$text['defKills:Points']."</th><th class=\"preferencesListTD\">".$text['attBashingRank']."</th><th class=\"preferencesListTD\">".$text['attKills:Points']."</th>";
         else $advanced = "<th class=\"preferencesListTD\"><a href=\"".$_SERVER['PHP_SELF']."?advanced&amp;page=".$page."\">".$text['advancedView']."</a></th>";
         print ("<tr><th class=\"preferencesListTD\">".$text['rank']."</th><th class=\"preferencesListTD\">".$text['name']."</th><th class=\"preferencesListTD\">".$text['points']."</th><th class=\"preferencesListTD\">".$text['villages']."<img src=\"images/village.png\" alt=\"\"/></th>".$advanced."</tr>\n");

         foreach($quest as $line)
           {
           if($line)
             {
	    if($line['playerRanking'] != $rank)
	      {
               if($advanced) $advanced = $line['allyName'].$line['allKills'].$line['defKills'].$line['attKills'];
               print ("<tr id=\"".$line['playerId']."\" onclick=\"showRankDataOf('".$line['playerId']."');\" ><td class=\"preferencesListTD\">".englishNumerationSuffix($line['playerRanking'])."</td><td class=\"preferencesListTD\"><a class=\"intLink\" href=\"index.php?id=".$line['playerId']."\">".$line['playerName']."</a></td><td class=\"preferencesListTD\">".number_format($line['playerPoints'])."</td><td class=\"preferencesListTD\">".$line['playerVillages']."</td>".$advanced."</tr>\n");
               }
	    elseif($line['playerRanking'] == $rank)
	      {
               if($advanced) $advanced = $line['allyNameMark'].$line['allKillsMark'].$line['defKillsMark'].$line['attKillsMark'];
               print ("<tr id=\"".$line['playerId']."\" onclick=\"showRankDataOf('".$line['playerId']."');\" ><td style=\"background-color:rosybrown\" class=\"preferencesListTD\">".englishNumerationSuffix($line['playerRanking'])."</td><td style=\"background-color:rosybrown\" class=\"preferencesListTD\"><a class=\"intLink\" href=\"index.php?id=".$line['playerId']."\">".$line['playerName']."</a></td><td style=\"background-color:rosybrown\" class=\"preferencesListTD\">".number_format($line['playerPoints'])."</td><td style=\"background-color:rosybrown\" class=\"preferencesListTD\">".$line['playerVillages']."</td>".$advanced."</tr>\n");
               }
	    }
           }

         $nextpage = $page + 1;
         $previouspage = $page - 1;
         $lastpage = ceil(mysql_fetch_object(mysql_query("SELECT COUNT( `rank` ) AS `rank` FROM `".$playertable."`"))->rank / 20);
         print ("<tr><td></td>\n");
		 print ("<td colspan=\"4\"><a class=\"intLink\" href=\"".$_SERVER['PHP_SELF']."?page=".$previouspage."\">&lt;&lt;</a> - \n");
		 print ("<a class=\"intLink\" href=\"".$_SERVER['PHP_SELF']."?page=1\">".$text['firstPage']."</a> - \n");
		 print ("<a class=\"intLink\" href=\"".$_SERVER['PHP_SELF']."?page=".$page."\">".$page."</a> - \n");
		 print ("<a class=\"intLink\" href=\"".$_SERVER['PHP_SELF']."?page=".$lastpage."\">".$text['lastPage']."</a> - \n");
		 print ("<a class=\"intLink\" href=\"".$_SERVER['PHP_SELF']."?page=".$nextpage."\">&gt;&gt;</a>\n");

		 print ("<form action=\"".$selffile."\" method=\"get\"><div><input type=\"text\" name=\"player\" id=\"key\" value=\"\"/>\n");
		 print ("<input type=\"button\" value=\"".$text['page']."\" onclick=\"javascript:var key = document.getElementById('key').value; var url = '".$_SERVER['PHP_SELF']."?page=' + key; window.location.href = url;;\" />\n");
		 print ("<input type=\"button\" value=\"".$text['rank']."\" onclick=\"javascript:var key = parseInt(document.getElementById('key').value); if(key < 20) {page = 1; } else { page = key / 20; } var url = '".$_SERVER['PHP_SELF']."?rank=' + key + '&amp;page=' + page; window.location.href = url;\" />\n");
		 print ("<input type=\"button\" onclick=\"submit();\" value=\"".$text['player']."\" /></div></form>\n");
		 print ("</td></tr>\n");
         print ("</table>\n");

         }

print ("</td>\n");
print ("</tr>\n");
print ("</table>\n");

// Info Box - AJAX
print ("<div id=\"infobox\" style=\"font-size:small; display:none; position:fixed; top:15%; right:2%; background-image:url(images/halb.png); outline-style:outset; outline-width:2px; outline-color:gold;  \"><img alt=\"Loading\" src=\"images/loader.gif\"/></div>\n");



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
print ("<tr><td class=\"preferencesListTD\">Require searchscript:</td>\n");
print ("<td class=\"preferencesListTD\">".checkCorrect($debug['SuffixScript'])."</td></tr>\n");
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