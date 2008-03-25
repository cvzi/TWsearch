<?php
function calcRealDistance($villageOne,$villageTwo,$speed)
  {
  $villageOne = explode("|",$villageOne);
  $x1 = str_replace("(","",$villageOne[0]);
  $y1 = str_replace(")","",$villageOne[1]);
  $villageTwo = explode("|",$villageTwo);
  $x2 = str_replace("(","",$villageTwo[0]);
  $y2 = str_replace(")","",$villageTwo[1]);

  $time = sqrt(pow($x1 - $x2, 2) + pow($y1 - $y2, 2)) * $speed;
  $timest = intval($time * 60);
  $hours = floor(($time * 60) / 3600);
  if($hours < 10) $hours = "0".$hours;
  $minutes = floor($time) - ($hours * 60);
  if($minutes < 10) $minutes = "0".$minutes;
  $seconds = round(fmod($time * 60, 60),0);
  if($seconds < 10) $seconds = "0".$seconds;
  
  $output = array("hours" => $hours,
                  "minutes" => $minutes,
                  "seconds" => $seconds,
                  "x1" => $x1,
                  "y1" => $y1,
                  "x2" => $x2,
                  "y2" => $y2,
				  "time" => $timest);
  
  return $output;
  }

function encodeAttacks($schedule,$input,$format="html",$new_delimiter="(+)",$delimiter="(-)",$subdelimiter="(--)")
  {
  if($input == "") 
    {
    print("<tr>\n<td colspan=\"8\"> - No attacks until now - </td>\n</tr>\n"); 
    return false;
    }  
  $battle = explode($new_delimiter,$input);
  $weg = array_shift($battle);
  $output = array();
  $i = 0;
  foreach($battle as $attack)
    {
    // Zerlege String 
    $attack = explode($delimiter,$attack);
    $out = array();
    $weg = array_shift($attack);
    
    // Attack Id
    $out['attackid'] = $attack[0];
    
    // Attack Type
    if($attack[1] == "c") $out['attacktype'] = "cleaner";
    elseif($attack[1] == "n") $out['attacktype'] = "nobler";
    elseif($attack[1] == "f") $out['attacktype'] = "fake";
    elseif($attack[1] == "s") $out['attacktype'] = "support";
    elseif($attack[1] == "sp") $out['attacktype'] = "spy";

    // Startdorf
    $out['origin'] = $attack[2];

    // Zieldorf
    $out['target'] = $attack[3];

    // Zeit als Timestamp
    $out['arrival'] = intval($attack[4]);

	 // Truppen
    if($attack[5] != "@(-false-)")
      {
      $attack[5] = explode($subdelimiter,$attack[5]);
      $weg = array_shift($attack[5]);
	  $out['units'] = true;     
      $out['unit_spear'] = intval($attack[5][0]);
	  $out['unit_sword'] = intval($attack[5][1]);	
	  $out['unit_axe'] = intval($attack[5][2]);	
	  $out['unit_archer'] = intval($attack[5][3]);			
	  $out['unit_spy'] = intval($attack[5][4]);	
	  $out['unit_light'] = intval($attack[5][5]);	
	  $out['unit_marcher'] = intval($attack[5][6]);
	  $out['unit_heavy'] = intval($attack[5][7]);	
	  $out['unit_ram'] = intval($attack[5][8]);	
	  $out['unit_catapult'] = intval($attack[5][9]);	
	  $out['unit_knight'] = intval($attack[5][10]);
	  $out['unit_snob'] = intval($attack[5][11]);						
      }
    else
      {
	  $out['units'] = false;	
	  }
	
	// Notes
    if($attack[6] != "@(-false-)")
	  {
	  $out['notes']	= $attack[6];	
      }	
    else
	  {
	  $out['notes']	= false;	
	  } 
	
		
	// In Array abspeichern
	$output[$i] = $out; 
	
	// Counter
    $i++;  	
    }
    
  if($format == "html") 
    {
    $out = ""; 
    
    // Sortieren nach Uhrzeit
	  function cmp($a, $b) 
	    {
        return strcmp($a["arrival"], $b["arrival"]);
        }	
	  usort($output, "cmp");	
       
	foreach($output as $out)
	  {
	  print ("<tr>\n");
	  
	  // Attacktype
      print ("<td><select name=\"attacktype\">\n");
      if($out['attacktype'] == "cleaner") print ("<option selected=\"selected\">Clean</option>\n");
      elseif($out['attacktype'] == "nobler") print ("<option selected=\"selected\">Noble</option>\n");
      elseif($out['attacktype'] == "fake") print ("<option selected=\"selected\">Fake</option>\n");
      elseif($out['attacktype'] == "support") print ("<option selected=\"selected\">Support</option>\n");
      elseif($out['attacktype'] == "spy") print ("<option selected=\"selected\">Spying</option>\n");
      print ("</select></td>\n");



	  print ("<td>".$out['origin']."</td>\n");
	  print ("<td>".$out['target']."</td>\n");

	  // Abschickzeit errechnen: 
	  if($out['unit_snob'] > 0)
	    {
		$run = calcRealDistance($out['origin'],$out['target'],35);	
		}
	  elseif($out['unit_catapult'] > 0 or $out['unit_ram'] > 0)
	    {
		$run = calcRealDistance($out['origin'],$out['target'],30);	
		}
	  elseif($out['unit_sword'] > 0)
	    {
		$run = calcRealDistance($out['origin'],$out['target'],22);	
		}	
	  elseif($out['unit_spear'] > 0 or $out['unit_axe'] > 0 or $out['unit_archer'] > 0)
	    {
		$run = calcRealDistance($out['origin'],$out['target'],18);	
		}			
	  elseif($out['unit_heavy'] > 0)
	    {
		$run = calcRealDistance($out['origin'],$out['target'],11);	
		}		
	  elseif($out['unit_light'] > 0 or $out['unit_marcher'] > 0 or $out['unit_knight'] > 0)
	    {
		$run = calcRealDistance($out['origin'],$out['target'],10);	
		}
	  elseif($out['unit_spy'] > 0)
	    {
		$run = calcRealDistance($out['origin'],$out['target'],9);	
		}	
		
	  else
	    {
		$run = calcRealDistance($out['origin'],$out['target'],10);					
		}
      
      $time = $out['arrival'] - $run['time'];
      $time = date("H:i:s - j F Y",$time); 
 	  print ("<td title=\"".$run['hours'].":".$run['minutes'].":".$run['seconds']."\">".$time."</td>\n");

	  
	  // Datum formatieren:
	  $arrival = date("H:i:s - j F Y",$out['arrival']); 
	  print ("<td>".$arrival."</td>\n");	  
	  
	  
	  // Notes ja/nein
	  if($out['notes'])
	    { 
        print ("<td onclick=\"showHide('notes_".$out['arrival']."')\">\n");
		print ("<img alt=\"Show\" src=\"images/tick.png\"/> Show\n");
		print ("<div style=\"display:none;\" class=\"notesBlock\" id=\"notes_".$out['arrival']."\">".$out['notes']."</div>\n");	
		print ("</td>\n");	
		}
	  else
	    {
		print ("<td><img alt=\"No\" src=\"images/cross.png\"/></td>\n");	
		}	
	
	  // Units ja/nein
	  if(!$out['units'])
	    {
		print ("<td><img alt=\"No\" src=\"images/cross.png\"/></td>\n"); 
		}
	  else
	    {
		print ("<td onclick=\"showHide('units_".$out['arrival']."')\">\n");
		print ("<img alt=\"Show\" src=\"images/tick.png\"/> Show\n");
		print ("<div style=\"display:none;\" class=\"notesBlock\" id=\"units_".$out['arrival']."\">\n");
		
		
        print ("<table style=\"color:black; \">\n");

		print ("<td><img alt=\"\" src=\"images/ingame/units/unit_spear.png\" /></td>\n");
		print ("<td><img alt=\"\" src=\"images/ingame/units/unit_sword.png\" /></td>\n");
		print ("<td><img alt=\"\" src=\"images/ingame/units/unit_axe.png\" /></td>\n");
		print ("<td><img alt=\"\" src=\"images/ingame/units/unit_archer.png\" /></td>\n");
		print ("<td><img alt=\"\" src=\"images/ingame/units/unit_spy.png\" /></td>\n");
		print ("<td><img alt=\"\" src=\"images/ingame/units/unit_light.png\" /></td>\n");
		print ("<td><img alt=\"\" src=\"images/ingame/units/unit_marcher.png\" /></td>\n");
		print ("<td><img alt=\"\" src=\"images/ingame/units/unit_heavy.png\" /></td>\n");
		print ("<td><img alt=\"\" src=\"images/ingame/units/unit_ram.png\" /></td>\n");
		print ("<td><img alt=\"\" src=\"images/ingame/units/unit_catapult.png\" /></td>\n");
		print ("<td><img alt=\"\" src=\"images/ingame/units/unit_knight.png\" /></td>\n");
		print ("<td><img alt=\"\" src=\"images/ingame/units/unit_snob.png\" /></td>\n");
		print ("</tr>\n");

		print ("<tr id=\"unit_numbers\">\n");
		print ("<td>".$out['unit_spear']."</td>\n");
		print ("<td>".$out['unit_sword']."</td>\n");
		print ("<td>".$out['unit_axe']."</td>\n");
		print ("<td>".$out['unit_archer']."</td>\n");
		print ("<td>".$out['unit_spy']."</td>\n");
		print ("<td>".$out['unit_light']."</td>\n");
		print ("<td>".$out['unit_marcher']."</td>\n");
		print ("<td>".$out['unit_heavy']."</td>\n");
		print ("<td>".$out['unit_ram']."</td>\n");
		print ("<td>".$out['unit_catapult']."</td>\n");
		print ("<td>".$out['unit_knight']."</td>\n");
		print ("<td>".$out['unit_snob']."</td>\n");
		print ("</tr>\n");

		print ("</table>\n");	
		
		print ("</div>\n");	
		print ("</td>\n");		
		}		
	
	  print ("<td><button type=\"button\">Edit</button>\n");
	  print ("<button type=\"button\" onclick=\"window.location.href = 'attack.php?action=admin&schedulename=".$schedule."&index=delattack&attid=".$out['attackid']."'; \">Delete</button>\n");
	  print ("	  <button type=\"button\">Settled</button>\n");
	  print ("</td>\n");	
	  print ("</tr>\n");	
		

	  }
    return true;
	} 
  elseif($format == "html") 
    { 
	return $output; 
	}
  return false;
  }


?>