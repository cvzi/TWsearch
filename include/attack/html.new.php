<h2>First Step - Preparation</h2>

   <script type="text/javascript">
   // Passwort Cookie löschen
   document.cookie = 'schedule_masterpassword=; expires=Thu, 01-Jan-70 00:00:01 GMT;';
   </script>


<?php

  print ("<form action=\"".$selffile."\" method=\"post\">\n");

  print ("<fieldset>\n");
  print ("  <legend>New Attack Schedule</legend>\n");
  print ("<table>\n");

  print ("<tr>\n");
  print ("<td>Name: </td><td><input name=\"schedulename\" type=\"text\" /><input type=\"button\" value=\"Random\" onclick=\"randomStr(document.getElementsByName('schedulename')[0],10,15)\" /></td>\n");
  print ("</tr>\n");

  print ("<tr>\n");
  print ("<td>Master password: </td><td><input name=\"masterpassword\" type=\"text\" /></td>\n");
  print ("</tr>\n");

  print ("<tr>\n");
  print ("<td>Password (for your users/tribe): </td><td><input name=\"userpassword\" type=\"text\" /></td>\n");
  print ("</tr>\n");

  print ("<tr>\n");
  print ("<td>Type: </td>\n");

  print ("<td>\n");
  print ("<input type=\"radio\" name=\"scheduletype\" id=\"input_scheduletype_easy\" value=\"easy\" checked=\"checked\" />\n");
  print ("<label for=\"input_scheduletype_easy\">Easy Version (for little attacks with some villages)</label></td>\n");
  print ("<td><input type=\"radio\" name=\"scheduletype\" id=\"input_scheduletype_advanced\" value=\"advanced\" />\n");
  print ("<label for=\"input_scheduletype_advanced\">Advanced Version (not available)</label></td>\n");
  print ("</tr>\n");


  print ("</table>\n");

  print ("</fieldset>\n");

  print ("<input type=\"submit\" value=\"Next\">\n");

  print ("<input type=\"hidden\" name=\"action\" value=\"review\">\n");
  print ("</form>\n");

?>