<?php
// Head
require("head.php");

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

         print ("<table class=\"preferencesTABLE\">\n");
	print ("\n");
	print ("<tr>\n");
	print ("<th rowspan=\"9\" style=\"text-align:center; \" class=\"verticalTH\">".$text['verticalPlayer']."</th>\n");
	print ("<th colspan=\"2\" class=\"horizontalTH\">".$quest['playerName']."</th>\n");
	print ("</tr>\n");
	print ("\n");
	print ("<tr><td class=\"preferencesListTD\">".$text['name'].":</td><td class=\"preferencesListTD\">".$quest['playerName']."<a title=\"".$text['headingGenerateSignatur']."\" href=\"".$link['sig']."?name=".$quest['playerName']."\"><img class=\"extLink\" alt=\"".$text['headingGenerateSignatur']."\" style=\"height:12px; width:12px; text-align:right\" src=\"images/dia_icon.png\" /> </a> <a title=\"Ingame to ".$quest['playerName']."\" href=\"".$link['inGamePlayer'].$quest['playerId']."\"><img class=\"extLink\" alt=\"Ingame\" style=\"height:12px; width:12px; text-align:right; \" src=\"images/ds_extern.png\" /></a></td></tr>\n");
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
	  print ("<th rowspan=\"6\" style=\"text-align:center; \" class=\"verticalTH\">".$text['verticalTribe']."</th>\n");
	  print ("<th colspan=\"2\" class=\"horizontalTH\">".$quest['allyName']."</th>\n");
	  print ("</tr>\n");
	  print ("\n");
	  print ("<tr><td class=\"preferencesListTD\">".$text['name'].":</td><td class=\"preferencesListTD\">".$quest['allyName']."<a title=\"Ingame to ".$quest['allyName']."\" href=\"".$link['inGameTribe'].$quest['allyId']."\"><img class=\"extLink\"  alt=\"Ingame\" style=\"text-align:right; height:12px; width:12px; \" src=\"images/ds_extern.png\" /></a></td></tr>\n");
	  print ("<tr><td class=\"preferencesListTD\">".$text['id'].":</td><td class=\"preferencesListTD\">".$quest['allyId']."</td></tr>\n");
	  print ("<tr><td class=\"preferencesListTD\">".$text['points'].":</td><td class=\"preferencesListTD\">".$quest['allyPoints']."</td></tr>\n");
	  print ("<tr><td class=\"preferencesListTD\">".$text['members'].":</td><td class=\"preferencesListTD\">".$quest['allyMembers']."</td></tr>\n");
	  print ("<tr><td class=\"preferencesListTD\">".$text['rank'].":</td><td class=\"preferencesListTD\">".$quest['allyRank']."</td></tr>\n");
	  print ("\n");
	  print ("</table>\n");
           }

         print ("<table class=\"preferencesTABLE\">\n");
         print ("<tr><td /><td colspan=\"2\" class=\"preferencesListTD\"><img style=\"height:88px; width:235px; \" src=\"chart_big/index.php?id=".$quest['playerId']."\" alt=\"".$text['chart']."\" /></td></tr>\n");
         print ("</table>\n");

         print ("<div style=\"cursor:pointer; position:absolute; right:1px; top:1px;\"><img onmousedown=\"this.src = 'images/close_active.png'; \" onmouseout=\"this.src = 'images/close.png'; \" onmouseover=\"this.src = 'images/close_hover.png'; \" onclick=\"document.getElementById('infobox').style.display = 'none'; \" src=\"images/close.png\" alt=\"".$text['close']."\" /></div>\n");
?>