<?php
/*
<!--[if gte IE 5.5]>
</div></div>
<div>
<h2>Alternative Menu for Internet Explorer</h2>
  <select size="8" onchange="window.location.href = this.options[this.selectedIndex].value;">
  <optgroup label="Home">
    <option value="/index.php">Homepage</option>
    <option value="/rank.php">Ranking</option>
    <option value="/sig/index.php">Signatures</option>
    <option value="/compare.php">Comparison</option>
    <option value="/running.php">Distance Calculator</option>
  </optgroup>
  <optgroup label="User">
    <option value="/usercp.php">Settings</option>
    <option value="/login.php">Login</option>

  </optgroup>
  </select>


  </div>
<![endif]-->
*/
echo "<!-- Internet Explorer Style: true/[false] -->";



print ("<div class=\"menu_main\">\n");
print ("  <a href=\"".$link['start']."\">".$text['homepage']."</a>\n");
print ("</div>\n");
print ("\n");
print ("<div class=\"menu_main\">\n");
print ("  <span>".$text['tools']."</span>\n");
print ("  <div class=\"menu_submenu\">\n");
print ("  <table>\n");
print ("    <tr><td><a href=\"".$link['start']."\">".$text['heading2']."</a></td></tr>\n");
print ("    <tr><td><a href=\"".$link['rank']."\">".$text['ranking']."</a></td></tr>\n");
print ("    <tr><td><a href=\"".$link['comparison']."\">".$text['comparison']."</a></td></tr>\n");
print ("    <tr><td><a href=\"".$link['sig']."\">".$text['signatures']."</a></td></tr>\n");
print ("    <tr><td><a href=\"".$link['distanceCalculator']."\">".$text['distanceCalculator']."</a></td></tr>\n");
print ("    <tr><td><a href=\"".$link['claiming']."\">".$text['claiming']."</a></td></tr>\n");
print ("    <tr><td><a href=\"".$link['codesEdit']."\">".$text['codesEdit']."</a></td></tr>\n");
print ("\n");
print ("  </table>\n");
print ("  </div>\n");
print ("</div>\n");
print ("\n");
print ("<div class=\"menu_main\">\n");
print ("  <span>".$text['user']."</span>\n");
print ("  <div class=\"menu_submenu\">\n");
print ("  <table>\n");
print ("    <tr><td><a href=\"".$link['usercp']."\">".$text['settings']."</a></td></tr>\n");
print ("    <tr><td><a href=\"".$link['Login']."\">".$text['LoginCaption']."</a></td></tr>\n");
print ("  </table>\n");
print ("  </div>\n");
print ("</div>\n");
print ("<div class=\"menu_empty\"></div>\n");
?>