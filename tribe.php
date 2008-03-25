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
<link rel="alternate" type="application/rss+xml" title="News" href="/feed.php" />


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

// Post Variablen und Keys
if(!isset($_GET['id']))
  {
  $searchKey = $_GET['searchKey'];
  if(isset($_GET['player']))
    {
    $searchType = "player";
    }
  else
    {
    $searchType = "tribe";
    }
  }
else
  {
  $searchKey = $_GET['id'];
  $searchType = "id";
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
print ("<h2>Tribes - ".$worldname."</h2>\n");
print ("</th>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td class=\"mainTD\" valign=\"top\">\n");
print ("<form action=\"".$selffile."\" method=\"get\">\n");
print ("<fieldset>\n");
print ("<input type=\"text\" name=\"searchKey\" value=\"".$searchKey."\" />\n");
print ("<input type=\"submit\" value=\"".$text['submitSearchButton']."\"/><br />\n");
print ("<input type=\"checkbox\" name=\"player\" id=\"checkbox_player\" value=\"Tribe by player\"/><label for=\"checkbox_player\">Find tribe by player</label>\n");

print ("</fieldset>\n");
print ("</form>\n");

print ("</td>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td class=\"mainTD\" valign=\"top\">\n");

if($searchKey == "")
  {
  echo "<h3>".$text['enterSearchKeyOrder']."</h3>";
  }

elseif($searchKey != "")
  {
  $debug['searchType'] =  "Search ".$searchType." for ".$searchKey;
  $debug['ReqSearchScript'] = require("include/searchAccTribe.php");
  if($searchType == "tribe" or $searchType == "id")
    {
    $quest = searchAccTribe($searchKey,$searchType);
    }
  elseif($searchType == "player")
    {
    $sql = "SELECT `ally` FROM `tw5_player` WHERE `name` LIKE '".urlencode($searchKey)."'";
    $query = mysql_fetch_object(mysql_query($sql));
    if($query->ally == "0")
      {
      print ("<h3>Player is tribeless</h3>");
      $quest['noResult'] = true;
      }
    else
      {
      $quest = searchAccTribe($query->ally,"id");
      }
    }

  // NO RESULT
  if($quest['noResult'] == true)
    {
    print ("<h3>".$text['noResult']."</h3>");
    }
  else
    {
    print ("<table class=\"preferencesTABLE\">\n");

	print ("<tr>\n");
	print ("<th rowspan=\"8\" style=\"text-align:center; \" class=\"verticalTH\">T<br />R<br />I<br />B<br />E</th>\n");
	print ("<th colspan=\"2\" class=\"horizontalTH\">".$quest['playerName']."</th>\n");
	print ("</tr>\n");

	print ("<tr><td class=\"preferencesListTD\">".$text['name'].":</td><td class=\"preferencesListTD\">".$quest['allyName']."\n");
	print ("<tr><td class=\"preferencesListTD\">".$text['tribeTag'].":</td><td class=\"preferencesListTD\">".$quest['allyTag']."\n");
	print ("<tr><td class=\"preferencesListTD\">".$text['members'].":</td><td class=\"preferencesListTD\">".$quest['allyMembers']."</td></tr>\n");
	print ("<tr><td class=\"preferencesListTD\">".$text['villages'].":</td><td class=\"preferencesListTD\">".$quest['allyVillages']."</td></tr>\n");
	print ("<tr><td class=\"preferencesListTD\">".$text['points'].":</td><td class=\"preferencesListTD\">".wash_number($quest['allyPoints'])."</td></tr>\n");
	print ("<tr><td class=\"preferencesListTD\">".$text['totalPoints']."</td><td class=\"preferencesListTD\">".wash_number($quest['allyAll_points'])." Points</td></tr>\n");
         print ("<tr><td class=\"preferencesListTD\">".$text['rank'].":</td><td class=\"preferencesListTD\">".$quest['allyRank']."</td></tr>\n");
    print ("</table>\n");

    print ("<img src=\"".$link['tribeChart']."?id=".$quest['allyId']."\" alt=\"Chart\" />");



    print ("<br />\n");
    print ("<h3>".$text['klickLineForMoreDetails']."</h3>\n");

    print ("<table class=\"preferencesTABLE\">\n");

         print ("<tr>\n");
	print ("<th colspan=\"3\" class=\"horizontalTH\">Memberlist</th>\n");
	print ("</tr>\n");

         print ("<tr>\n");
	print ("<th class=\"horizontalTH\">#</th>\n");
         print ("<th class=\"horizontalTH\">Name</th>\n");
         print ("<th class=\"horizontalTH\">Points</th>\n");
	print ("</tr>\n");
         $i = 1;
         require("include/function.englishNumerationSuffix.php");
         foreach($quest['allyMembernames'] as $player)
           {
           print ("<tr onclick=\"showRankDataOf('".$player['id']."');\">\n");
           print ("<td class=\"preferencesListTD\">".englishNumerationSuffix($i)."</td>\n");
           print ("<td class=\"preferencesListTD\"><a class=\"intLink\" href=\"".$link['start']."?id=".$player['id']."\">".$player['name']."</a></td>\n");
           print ("<td class=\"preferencesListTD\">".wash_number($player['points'])."</td>\n");
           print ("</tr>\n");
           $i++;
           }
    print ("</table>\n");
    }
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


?>


</body>
</html>