<?php
require("version.php");
require("translation.php");

print ("<p class=\"foot\" style=\"text-align:center; margin-left:auto; margin-right:auto\">");
print ("This page was generated in ".$time." - ");
print ("<span class=\"extlink\">".$version."</span> - ");
print ("<a href=\"".$link['start']."\">Home</a> - ");
print ("<a href=\"".$link['rank']."\">Ranking</a> - ");
print ("<a href=\"".$link['sig']."\">Signature</a> - ");
print ("<a href=\"".$link['usercp']."\">Settings</a> - ");
print ("<a href=\"".$link['Login']."\">Login</a></p>\n");
print ("<div style=\"position:fixed; right:1%; top:3%; \"><img alt=\"Version ".$version."\" src=\"/images/versionright.php\"/></div>\n");
?>