<?php


  print ("<h2>Second Step - Review</h2>\n");

  print ("<form action=\"".$selffile."\" method=\"post\">\n");

  print ("<h3>You should write up/copy this information!</h3>\n");

  print ("<p>\n");
  print ("Link/URI for your users:<br />\n");
  print ("<input readonly=\"readonly\" type=\"text\"  value=\"/attack.php?action=plan&amp;name=".$schedulename."\" size=\"100\"/><br />\n");
  print ("Password for your users:<br />\n");
  print ("<input readonly=\"readonly\" type=\"text\" value=\"".createStars($userpassword)."\" onmouseover=\"this.value = '".$userpassword."'\" onmouseout=\"this.value = '".createStars($userpassword)."'\" /><br />\n");
  print ("<br />\n");
  print ("Link/URI for you (Admin):<br />\n");
  print ("<input readonly=\"readonly\" type=\"text\" value=\"/attack.php?action=admin&amp;name=".$schedulename."\" size=\"100\"/><br />\n");
  print ("Password for you (Admin):<br />\n");
  print ("<input readonly=\"readonly\" type=\"text\" value=\"".createStars($masterpassword)."\" onmouseover=\"this.value = '".$masterpassword."'\" onmouseout=\"this.value = '".createStars($masterpassword)."'\" /><br />\n");

  print ("</p>\n");

  print ("<input type=\"submit\" value=\"Create!\">\n");

  print ("  <input name=\"schedulename\" value=\"".$schedulename."\" type=\"hidden\" />\n");
  print ("  <input name=\"scheduletype\" value=\"".$scheduletype."\" type=\"hidden\" />\n");
  print ("  <input name=\"masterpassword\" value=\"".$masterpassword."\" type=\"hidden\" />\n");
  print ("  <input name=\"userpassword\" value=\"".$userpassword."\" type=\"hidden\" />\n");

  print ("<input type=\"hidden\" name=\"action\" value=\"create\">\n");
  print ("</form>\n");

?>