<?php

        // Delimiter für neuen Angriff
        $formated_attack = $new_delimiter;
        
        // Id anfügen
		$battle = explode($new_delimiter,$row->attacks);
        $weg = array_shift($battle);                  
        $attid = count($battle) + 1;
        $formated_attack .= $delimiter.$attid; 
  
		      

        // Post Variablen des neuen Angriffs
        $attacktype = $_POST['attacktype'];
        $origin = $_POST['origin'];
        $target = $_POST['target'];
        $hours = $_POST['hours'];
        $minutes = $_POST['minutes'];
        $seconds = $_POST['seconds'];
        $day = $_POST['day'];
        $month = $_POST['month'];
        $year = $_POST['year'];
        $hide_units = $_POST['hide_units'];
        if($hide_units != "yes")
          {
          $unit_spear = $_POST['unit_spear'];
          $unit_sword = $_POST['unit_sword'];
          $unit_axe = $_POST['unit_axe'];
          $unit_archer = $_POST['unit_archer'];
          $unit_spy = $_POST['unit_spy'];
          $unit_light = $_POST['unit_light'];
          $unit_marcher = $_POST['unit_marcher'];
          $unit_heavy = $_POST['unit_heavy'];
          $unit_ram = $_POST['unit_ram'];
          $unit_catapult = $_POST['unit_catapult'];
          $unit_knight = $_POST['unit_knight'];
          $unit_snob = $_POST['unit_snob'];
          }
        $hide_notes = $_POST['hide_notes'];
        if($hide_notes != "yes")
          {
          $notes = $_POST['notes'];
          }

          /* Verarbeite die Daten zu einem String
             Die einzelnen  Daten werden durch $delimiter getrennt, "Arrays" sind durch $subdelimiter getrennt.
             Jede Attacke fängt mit $new_delimiter
             Values:
               [bool]
                 false = @(-false-)
                 true = @(+true+)
               [attacktype]
                 cleaner = c
                 nobler = n
                 fake = f
                 support = s
          */

        // Attack Type
        if($attacktype == "cleaner") $formated_attack .= $delimiter."c";
        elseif($attacktype == "nobler") $formated_attack .= $delimiter."n";
        elseif($attacktype == "fake") $formated_attack .= $delimiter."f";
        elseif($attacktype == "support") $formated_attack .= $delimiter."s";
        elseif($attacktype == "spy") $formated_attack .= $delimiter."sp";
        
        // Startdorf
        $formated_attack .= $delimiter.$origin;

        // Zieldorf
        $formated_attack .= $delimiter.$target;

        // Zeit als Timestamp
        //          Format:
        //          1972-09-24 15:59:01.000000
        $timeformat = $year."-".$month."-".$day." ".$hours.":".$minutes.":".$seconds.".000000";
        $arrival = strtotime($timeformat);
        $formated_attack .= $delimiter.$arrival;

        // Units
        if($hide_units != "yes")
          {
          $formated_attack .= $delimiter;
          $formated_attack .= $subdelimiter.$unit_spear;
          $formated_attack .= $subdelimiter.$unit_sword;
          $formated_attack .= $subdelimiter.$unit_axe;
          $formated_attack .= $subdelimiter.$unit_archer;
          $formated_attack .= $subdelimiter.$unit_spy;
          $formated_attack .= $subdelimiter.$unit_light;
          $formated_attack .= $subdelimiter.$unit_marcher;
          $formated_attack .= $subdelimiter.$unit_heavy;
          $formated_attack .= $subdelimiter.$unit_ram;
          $formated_attack .= $subdelimiter.$unit_catapult;
          $formated_attack .= $subdelimiter.$unit_knight;
          $formated_attack .= $subdelimiter.$unit_snob;
          }
        else
          {
          $formated_attack .= $delimiter."@(-false-)";
          }

        // Notes
        if($hide_notes != "yes")
          {
          $notes = addslashes(nl2br($notes));
          $formated_attack .= $delimiter.$notes;
          }
        else
          {
          $formated_attack .= $delimiter."@(-false-)";
          }
        $formated_attack = addslashes($row->attacks.$formated_attack);
        $sql = "UPDATE `phost100057`.`tw5_attackplan` SET `attacks` = '".$formated_attack."' WHERE `name` LIKE '".$schedulename."'";
        mysql_query($sql);
        print ("<div class=\"contents\">\n");
        print ("<table class=\"attackTable\">\n");
        print ("<tr>\n");
        print ("<th>Attack Added</th>\n");
        print ("</tr>\n");
        print ("</table>\n");
        print ("</div>\n");        
        
        
?>