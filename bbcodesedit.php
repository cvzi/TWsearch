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
<script type="text/javascript" src="bb-codes.js"></script>
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


print ("<table class=\"main\" style=\"margin-right:auto; margin-left:auto; \" cellspacing=\"3\">\n");
print ("\n");
print ("<tr>\n");
print ("<td>\n");
include("include/menu.php");
print ("</td>\n");
print ("</tr>\n");

print ("<tr>\n");
print ("<th class=\"mainTD\" colspan=\"2\">\n");
print ("<h2>".$text['codesEdit']." - ".$worldname."</h2>\n");
print ("</th>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td class=\"mainTD\" valign=\"top\">\n");




print ("<form action=\"\">\n");

print ("<div>\n");
print ("<img class=\"imageButton\" src=\"images/ingame/eisen.png\" onclick=\"insert('[img]http://www.die-staemme.de/graphic/eisen.png[/img]', '')\" title=\"".$text["wood"]."\" alt=\"".$text["wood"]."\" />\n");
print ("<img class=\"imageButton\" src=\"images/ingame/lehm.png\" onclick=\"insert('[img]http://www.die-staemme.de/graphic/lehm.png[/img]', '')\" title=\"".$text["clay"]."\" alt=\"".$text["clay"]."\" />\n");
print ("<img class=\"imageButton\" src=\"images/ingame/holz.png\" onclick=\"insert('[img]http://www.die-staemme.de/graphic/holz.png[/img]', '')\" title=\"".$text["wood"]."\" alt=\"".$text["wood"]."\" />\n");
print ("<img class=\"imageButton\" src=\"images/ingame/res.png\" onclick=\"insert('[img]http://www.die-staemme.de/graphic/res.png[/img]', '')\" title=\"".$text["warehouse"]."\" alt=\"".$text["warehouse"]."\" />\n");
print ("<img class=\"imageButton\" src=\"images/ingame/face.png\" onclick=\"insert('[img]http://www.die-staemme.de/graphic/face.png[/img]', '')\" title=\"".$text["villagers"]."\" alt=\"".$text["villagers"]."\" />\n");
print ("<img src=\"images/empty_image.php?width=10\" alt=\"\"/>\n");
print ("<img class=\"imageButton\" src=\"images/ingame/units/unit_spear.png\" onclick=\"insert('[img]http://www.die-staemme.de/graphic/unit/unit_spear.png[/img]', '')\" title=\"".$text['spearFighter']."\" alt=\"".$text['spearFighter']."\" />\n");
print ("<img class=\"imageButton\" src=\"images/ingame/units/unit_sword.png\" onclick=\"insert('[img]http://www.die-staemme.de/graphic/unit/unit_sword.png[/img]', '')\" title=\"".$text['swordsMan']."\" alt=\"".$text['swordsMan']."\" />\n");
print ("<img class=\"imageButton\" src=\"images/ingame/units/unit_axe.png\" onclick=\"insert('[img]http://www.die-staemme.de/graphic/unit/unit_axe.png[/img]', '')\" title=\"".$text['axeMan']."\" alt=\"".$text['axeMan']."\" />\n");
print ("<img class=\"imageButton\" src=\"images/ingame/units/unit_archer.png\" onclick=\"insert('[img]http://www.die-staemme.de/graphic/unit/unit_archer.png[/img]', '')\" title=\"".$text['archer']."\" alt=\"".$text['archer']."\" />\n");
print ("<img class=\"imageButton\" src=\"images/ingame/units/unit_spy.png\" onclick=\"insert('[img]http://www.die-staemme.de/graphic/unit/unit_spy.png[/img]', '')\" title=\"".$text['scout']."\" alt=\"".$text['scout']."\" />\n");
print ("<img class=\"imageButton\" src=\"images/ingame/units/unit_light.png\" onclick=\"insert('[img]http://www.die-staemme.de/graphic/unit/unit_light.png[/img]', '')\" title=\"".$text['lightCavalry']."\" alt=\"".$text['lightCavalry']."\" />\n");
print ("<img class=\"imageButton\" src=\"images/ingame/units/unit_marcher.png\" onclick=\"insert('[img]http://www.die-staemme.de/graphic/unit/unit_marcher.png[/img]', '')\" title=\"".$text['mountedArcher']."\" alt=\"".$text['mountedArcher']."\" />\n");
print ("<img class=\"imageButton\" src=\"images/ingame/units/unit_heavy.png\" onclick=\"insert('[img]http://www.die-staemme.de/graphic/unit/unit_heavy.png[/img]', '')\" title=\"".$text['heavyCavalry']."\" alt=\"".$text['heavyCavalry']."\" />\n");
print ("<img class=\"imageButton\" src=\"images/ingame/units/unit_ram.png\"  onclick=\"insert('[img]http://www.die-staemme.de/graphic/unit/unit_ram.png[/img]', '')\" title=\"".$text['ram']."\" alt=\"".$text['ram']."\" />\n");
print ("<img class=\"imageButton\" src=\"images/ingame/units/unit_catapult.png\" onclick=\"insert('[img]http://www.die-staemme.de/graphic/unit/unit_catapult.png[/img]', '')\" title=\"".$text['catapult']."\" alt=\"".$text['catapult']."\" />\n");
print ("<img class=\"imageButton\" src=\"images/ingame/units/unit_snob.png\" onclick=\"insert('[img]http://www.die-staemme.de/graphic/unit/unit_snob.png[/img]', '')\" title=\"".$text['nobleman']."\" alt=\"".$text['nobleman']."\" />\n");
print ("<img class=\"imageButton\" src=\"images/ingame/units/unit_knight.png\" onclick=\"insert('[img]http://www.die-staemme.de/graphic/unit/unit_knight.png[/img]', '')\" title=\"".$text['paladin']."\" alt=\"".$text['paladin']."\" />\n");
print ("<img src=\"images/empty_image.php?width=10\" alt=\"\"/>\n");
print ("<img class=\"imageButton\" style=\"height:18px; width:18px; \" onclick=\"javascript:insert('[img]/smile/happy.png[/img]', '')\" src=\"/smile/happy.png\" title=\"".$text["alt_insert"]."\" alt=\"".$text["alt_insert"]."\" />\n");
print ("<img class=\"imageButton\" style=\"height:18px; width:18px; \" onclick=\"javascript:insert('[img]/smile/sad.png[/img]', '')\" src=\"/smile/sad.png\" title=\"".$text["alt_insert"]."\" alt=\"".$text["alt_insert"]."\" />\n");
print ("<img class=\"imageButton\" style=\"height:18px; width:18px; \" onclick=\"javascript:insert('[img]/smile/grin.png[/img]', '')\" src=\"/smile/grin.png\" title=\"".$text["alt_insert"]."\" alt=\"".$text["alt_insert"]."\" />\n");
print ("<img class=\"imageButton\" style=\"height:18px; width:18px; \" onclick=\"javascript:insert('[img]/smile/weeping.png[/img]', '')\" src=\"/smile/weeping.png\" title=\"".$text["alt_insert"]."\" alt=\"".$text["alt_insert"]."\" />\n");
print ("<img class=\"imageButton\" style=\"height:18px; width:18px; \" onclick=\"javascript:insert('[img]/smile/angel.png[/img]', '')\" src=\"/smile/angel.png\" title=\"".$text["alt_insert"]."\" alt=\"".$text["alt_insert"]."\" />\n");
print ("<img class=\"imageButton\" style=\"height:18px; width:18px; \" onclick=\"javascript:insert('[img]/smile/devil.png[/img]', '')\" src=\"/smile/devil.png\" title=\"".$text["alt_insert"]."\" alt=\"".$text["alt_insert"]."\" />\n");
print ("</div>\n");

print ("<div>\n");
print ("<textarea name=\"eingabe\" cols=\"80\" rows=\"10\" style=\"background-color:#fffaf0; color:#2f4f4f; font-family:Helvetica,Times; \">\n");
print ("</textarea>\n");
print ("</div>\n");

print ("<div>\n");
print ("<input readonly=\"readonly\" value=\"".$text['infoField']."\" type=\"text\" size=\"81\" name=\"info\" style=\"border-style:inset; border-color:#daa520;  background-color:#fffaf0; color:#2f4f4f; font-family:Century Schoolbook,Times\" />\n");

print ("<select size=\"1\" onchange=\"insert('[color='+this.options[selectedIndex].value+']', '[/color]')\" style=\"background-color:#fffaf0; color:#2f4f4f; font-family:Helvetica,Times; font-size:10px; \">\n");
print ("<option value=\"black\"	style=\"color:black\" selected=\"selected\">".$text["black"]."</option>\n");
print ("<option value=\"blue\" 	style=\"color:blue\"		           >".$text["blue"]."</option>\n");
print ("<option value=\"red\" 	style=\"color:red\"		           >".$text["red"]."</option>\n");
print ("<option value=\"purple\" 	style=\"color:purple\"	           >".$text["purple"]."</option>\n");
print ("<option value=\"orange\" 	style=\"color:orange\"		   >".$text["orange"]."</option>\n");
print ("<option value=\"yellow\" 	style=\"color:yellow\"		   >".$text["yellow"]."</option>\n");
print ("<option value=\"gray\" 	style=\"color:gray\"		           >".$text["gray"]."</option>\n");
print ("<option value=\"green\" 	style=\"color:green\"		           >".$text["green"]."</option>\n");
print ("</select>\n");

print ("<select size=\"1\" onchange=\"insert('[size='+this.options[selectedIndex].value+']', '[/size]')\" style=\"background-color:#fffaf0; color:#2f4f4f; font-family:Helvetica,Times; font-size:10px; \">\n");

print ("<script type=\"text/javascript\">\n");
print ("for(var i=7;i < 41;i++)\n");
print ("  {\n");
print ("  document.writeln(\"<option value=\\\"\" + i + \"\\\">".$text["size"].": \" + i + \"</option>\");\n");
print ("  }\n");
print ("</script>\n");

print ("</select>\n");
print ("</div>\n");

print ("<div id=\"bilder\" style=\"visibility:visible\">\n");

print ("<span class=\"imageButton\" style=\"padding:1px 10px; font-weight:bold; \" onmouseover=\"document.getElementsByName('info')[0].value='[b]...[/b]'\" onmouseout=\"document.getElementsByName('info')[0].value='".$text['infoField']."'\" onclick=\"insert('[b]', '[/b]')\" >B</span>\n");
print ("<span class=\"imageButton\" style=\"padding:1px 10px; text-decoration:underline; \" onmouseover=\"document.getElementsByName('info')[0].value='[u]...[/u]'\" onmouseout=\"document.getElementsByName('info')[0].value='".$text['infoField']."'\" onclick=\"insert('[u]', '[/u]')\" >u</span>\n");
print ("<span class=\"imageButton\" style=\"padding:1px 10px; font-style:italic; \" onmouseover=\"document.getElementsByName('info')[0].value='[i]...[/i]'\" onmouseout=\"document.getElementsByName('info')[0].value='".$text['infoField']."'\" onclick=\"insert('[i]', '[/i]')\" >i</span>\n");
print ("<span class=\"imageButton\" style=\"padding:1px 10px; \" onmouseover=\"document.getElementsByName('info')[0].value='[size=12]...[/size]'\" onmouseout=\"document.getElementsByName('info')[0].value='".$text['infoField']."'\" onclick=\"insert('[size=12]', '[/size]')\" >Size</span>\n");
print ("<span class=\"imageButton\" style=\"padding:1px 10px; \" onmouseover=\"document.getElementsByName('info')[0].value='[quote=]...[/quote]'\" onmouseout=\"document.getElementsByName('info')[0].value='".$text['infoField']."'\" onclick=\"insert('[quote=]', '[/quote]')\" >".$text["quote"]."</span>\n");
print ("<span class=\"imageButton\" style=\"padding:1px 10px; \" onmouseover=\"document.getElementsByName('info')[0].value='[img]...[/img]'\" onmouseout=\"document.getElementsByName('info')[0].value='".$text['infoField']."'\" onclick=\"insert('[img]', '[/img]')\" >".$text["img"]."</span>\n");
print ("<span class=\"imageButton\" style=\"padding:1px 10px; \" onmouseover=\"document.getElementsByName('info')[0].value='[code]...[/code]'\" onmouseout=\"document.getElementsByName('info')[0].value='".$text['infoField']."'\" onclick=\"insert('[code]', '[/code]')\" >".$text["code"]."</span>\n");
print ("<span class=\"imageButton\" style=\"padding:1px 10px; \" onmouseover=\"document.getElementsByName('info')[0].value='[player]...[/player]'\" onmouseout=\"document.getElementsByName('info')[0].value='".$text['infoField']."'\" onclick=\"insert('[player]', '[/player]')\" >".$text["player"]."</span>\n");
print ("<span class=\"imageButton\" style=\"padding:1px 10px; \" onmouseover=\"document.getElementsByName('info')[0].value='[ally]...[/ally]'\" onmouseout=\"document.getElementsByName('info')[0].value='".$text['infoField']."'\" onclick=\"insert('[ally]', '[/ally]')\" >".$text["tribe"]."</span>\n");
print ("<span class=\"imageButton\" style=\"padding:1px 10px; \" onmouseover=\"document.getElementsByName('info')[0].value='[village](000|000)[/village]'\" onmouseout=\"document.getElementsByName('info')[0].value='".$text['infoField']."'\" onclick=\"insert('[village](', ')[/village]')\" >".$text["village"]."</span>\n");
print ("<span class=\"imageButton\" style=\"padding:1px 10px; \" onmouseover=\"document.getElementsByName('info')[0].value='[url=http://]...[/url]'\" onmouseout=\"document.getElementsByName('info')[0].value='".$text['infoField']."'\" onclick=\"insert('[url=http://]', '[/url]')\" >".$text["url"]."</span>\n");

print ("<br /><br /><input style=\"font-size:0.8em; \" type=\"button\" value=\"".$text["clear"]."\" onclick=\"Clear()\" />\n");

print ("</div>\n");


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

$d++;
$debug['ReqFoot'] = require("foot.php");

?>


</body>
</html>