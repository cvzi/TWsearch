<?php
      $attid = intval($attid);
      // Angriff bekommen
      $battle = explode($new_delimiter,$row->attacks);
      $weg = array_shift($battle);
      $i = 0;
     
      // Zerlege String 
      foreach($battle as $attack)
        {
        $attack = explode($delimiter,$attack);
        $out = array();
        $weg = array_shift($attack);
        $attacksid[$i] = intval($attack[0]);
        $i++;
        }
      $i = 0;
      
      // Lösche den Angriff
      foreach($attacksid as $attack)
        {
		if($attack == $attid)
		  {		  unset($battle[$i]);
		  break;
		  }
		$i++;		
		}

      // Wieder eintragen
      $formated_attack = $new_delimiter.implode($new_delimiter,$battle);
      $formated_attack = addslashes($formated_attack);
     
      $sql = "UPDATE `phost100057`.`tw5_attackplan` SET `attacks` = '".$formated_attack."' WHERE `name` LIKE '".$schedulename."'";
      mysql_query($sql);
      
	  print ("<div class=\"contents\">\n");
      print ("<table class=\"attackTable\">\n");
      print ("<tr>\n");
      print ("<th>Attack deleted</th>\n");
      print ("</tr>\n");
      print ("</table>\n");
      print ("</div>\n");   
?>