<?php
require("include/function.getCookiesUsercp.php");
$cookieData = getCookiesUsercp();

if(!isset($do) or $do == "index")
{
print ("<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>\n");
print ("<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"\n");
print ("    \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n");
print ("<html xmlns=\"http://www.w3.org/1999/xhtml\">\n");
print ("<head>\n");
print ("<title>TW-Search</title>\n");
print ("<link rel=\"stylesheet\" type=\"text/css\" title=\"User Style\" href=\"".$cookieData['personalCSS']."\" />\n");
print ("<link rel=\"alternate stylesheet\" type=\"text/css\" title=\"Old Style\" href=\"oldstyle.css\" />\n");
print ("<link rel=\"alternate stylesheet\" type=\"text/css\" title=\"Normal Style\" href=\"style.css\" />\n");
print ("<!--[if gte IE 5.5]>\n");
print ("<style type=\"text/css\">\n");

print (".td_main .span_submenu {\n");
print ("          display:none;\n");
print ("          position:relative}\n");

print (".menu_submenu {\n");
print ("          display:none;\n");
print ("          position:realtive; padding:0px;}\n");

print ("</style>\n");
print ("<![endif]-->\n");

print ("<script type=\"text/javascript\">\n");
print ("function checkboxColor(selectedElement) \n");
print ("  {\n");
print ("  if(selectedElement.checked) \n");
print ("    { \n");
print ("	selectedElement.className = 'checkbox_checked'; \n");
print ("	} \n");
print ("  else \n");
print ("    { \n");
print ("	selectedElement.className = 'checkbox_notchecked'; \n");
print ("	}\n");
print ("  }\n");
print ("</script>\n");

print ("</head>\n");
print ("<body>\n");

// Head
require("head.php");

print ("<table class=\"main\" align=\"center\" cellspacing=\"3\">\n");
print ("\n");

print ("<tr>\n");
print ("<td>\n");
include("include/menu.php");
print ("</td>\n");
print ("</tr>\n");

print ("<tr>\n");
print ("<th class=\"mainTD\" colspan=\"2\">\n");
print ("<h2 align=\"center\">".$text['UserControlPanel']."  - ".$worldname."</h2>\n");
print ("</th>\n");
print ("</tr>\n");
print ("<form action=\"".$selffile."?do=setData\" method=\"post\">\n");
  print ("\n");

  print ("<tr>\n");
  print ("<td class=\"semitransparent-BorderTD\"><label for=\"input_User_ingameName\">".$text['IngameName']." - ".$worldname."</label></td>\n");
  print ("<td class=\"semitransparent-BorderTD\"><input type=\"text\" id=\"input_User_ingameName\" name=\"User_ingameName\" value=\"".$cookieData['ingameName']."\" /></td>\n");
  print ("</tr>\n");

  print ("<tr>\n");
  print ("<td class=\"semitransparent-BorderTD\"><label for=\"input_User_ownAccRanking\">".$text['selectOwnAccountOnRankingList']."</label></td>\n");
  if($cookieData['ownAccRanking']) $checked_ownAccRanking = " checked=\"checked\" class=\"checkbox_checked\"";
  else $checked_ownAccRanking = " class=\"checkbox_notchecked\"";
  print ("<td class=\"semitransparent-BorderTD\"><input".$checked_ownAccRanking." type=\"checkbox\" id=\"input_User_ownAccRanking\" name=\"User_ownAccRanking\" value=\"true\" onchange=\"checkboxColor(this);\" /></td>\n");
  print ("</tr>\n");

  print ("<tr>\n");
  print ("<td class=\"semitransparent-BorderTD\"><label for=\"input_User_showOwnInfos\">".$text['showOwnChartOnHomepage']."</label></td>\n");
  if($cookieData['showOwnInfos']) $checked_showOwnInfos = " checked=\"checked\" class=\"checkbox_checked\"";
  else $checked_showOwnInfos = " class=\"checkbox_notchecked\"";
  print ("<td class=\"semitransparent-BorderTD\"><input".$checked_showOwnInfos." type=\"checkbox\" id=\"input_User_showOwnInfos\" name=\"User_showOwnInfos\" value=\"true\" onchange=\"checkboxColor(this);\" /></td>\n");
  print ("</tr>\n");

  print ("<tr>\n");
  print ("<td class=\"semitransparent-BorderTD\"><label for=\"input_User_showRankHomepage\">".$text['showRankingOnHomepage']."</label></td>\n");
  if($cookieData['showRankHomepage']) $checked_showRankHomepage = " checked=\"checked\" class=\"checkbox_checked\"";
  else $checked_showRankHomepage = " class=\"checkbox_notchecked\"";
  print ("<td class=\"semitransparent-BorderTD\"><input".$checked_showRankHomepage." type=\"checkbox\" id=\"input_User_showRankHomepage\" name=\"User_showRankHomepage\" value=\"true\" onchange=\"checkboxColor(this);\" /></td>\n");
  print ("</tr>\n");

  print ("<tr>\n");
  print ("<td class=\"semitransparent-BorderTD\"><label for=\"input_User_personalCSS\">".$text['personalCSS']."</label></td>\n");
  print ("<td class=\"td_main\"><input type=\"text\" id=\"input_User_personalCSS\" name=\"User_personalCSS\" value=\"".$cookieData['personalCSS']."\" />\n");
  print ("<span class=\"span_submenu\">\n");
  print ("  <select size=\"3\" onchange=\"document.getElementById('input_User_personalCSS').value = this.options[this.selectedIndex].value;\">\n");
  print ("    <option value=\"".$cookieData['personalCSS']."\">".$text['currentStyle']."</option>\n");
  print ("    <option value=\"style.css\">".$text['normalStyle']."</option>\n");
  print ("    <option value=\"oldstyle.css\">Old</option>\n");
  print ("  </select>\n");
  print ("</span></td>\n");
  print ("</tr>\n");


  print ("<tr>\n");
  print ("<td colspan=\"2\"><hr /></td>\n");
  print ("</tr>\n");

  print ("<tr>\n");
  print ("<td class=\"semitransparent-BorderTD\"><label for=\"input_save_safety\">".$text['SaveNewSettings']."</label> <input class=\"checkbox_notchecked\" id=\"input_save_safety\" type=\"checkbox\" onchange=\"checkboxColor(this); if(this.checked) { document.getElementById('input_save').disabled = false; } else { document.getElementById('input_save').disabled = true; }\" /></td>\n");
  print ("<td class=\"semitransparent-BorderTD\"><input type=\"submit\" disabled=\"disabled\" id=\"input_save\" value=\"".$text['saveSettings']."\" /></td>\n");
  print ("</tr>\n");

  print ("\n");
  print ("<table>\n");
  print ("</form>\n");
  print ("</td>\n");
  print ("</tr>\n");


print ("</table>\n");

// Zeit für Aufbau
$time_end = microtime(true);
$time = $time_end - $time_start;
$time = $time * 1000;
if($time < 1) { $time = "less than one millisecond"; }
         else { $time = round($time). "ms"; }

require("foot.php");
print ("</body>\n");
print ("</html>\n");
}

elseif($do == "setData")
  {
  $hour = 60*60;
  $day = $hour*24;
  $week = $day*7;
  $month = $day*30;
  $year = $day*365;

  setcookie("User_ingameName",$_POST['User_ingameName'],Time()+$week*2);
  setcookie("User_ownAccRanking",$_POST['User_ownAccRanking'],Time()+$day*14);
  setcookie("User_showOwnInfos",$_POST['User_showOwnInfos'],Time()+$day*14);
  setcookie("User_showRankHomepage",$_POST['User_showRankHomepage'],Time()+$day*14);
  setcookie("User_personalCSS",$_POST['User_personalCSS'],Time()+$day*14);


print ("<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>\n");
print ("<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"\n");
print ("    \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n");
print ("<html xmlns=\"http://www.w3.org/1999/xhtml\">\n");
print ("<head>\n");
print ("<title>TW-Search</title>\n");
print ("<link rel=\"stylesheet\" type=\"text/css\" href=\"style.css\" />\n");
print("  <noscript>\n");
print("	 <meta http-equiv=\"Refresh\" content=\"2; URL=".$_SERVER['PHP_SELF']."\" />\n");
print("  </noscript>\n");
print("  <script type=\"text/javascript\">\n");
print("  setTimeout(\"window.location.href= '".$_SERVER['PHP_SELF']."' ;\", 1500)\n");
print("  </script>\n");
print ("</head>\n");
print ("<body>\n");
print ("<table class=\"main\" align=\"center\" cellspacing=\"3\">\n");
print ("\n");
print ("<tr>\n");
print ("<th class=\"mainTD\" colspan=\"2\">\n");
print ("<h2 align=\"center\">User Control Panel</h2>\n");
print ("</th>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td>\n");
print ("<h3><a class=\"intLink\" href=\"".$_SERVER['PHP_SELF']."\">Click here if your browser does not automatically redirect you.</a></h3>\n");
print ("</tr>\n");
print ("</td>\n");
print ("</table>\n");
print ("</body>\n");
print ("</html>\n");
#header("Location: ".$_SERVER['PHP_SELF']);
  }

?>