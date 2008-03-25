<?php
/* ######################## */
/* #    Zeit speichern    # */
/* #    **************    # */
/* ###################################################################### */
/* # */ $time_start = microtime(true);                               /* # */
/* ###################################################################### */

if(!isset($map))
  {
  header("Content-type: application/xhtml+xml; charset=utf-8");
  header("Content-Script-Type: text/javascript");
  header("Content-Style-Type: text/css");
  print("<?xml version=\"1.0\" encoding=\"utf-8\" ?>");
  print ("<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\"\n");
  print ("    \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n");
  print ("<html xmlns=\"http://www.w3.org/1999/xhtml\">\n");
  print ("<head>\n");
  print ("<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n");
  print ("<meta http-equiv=\"Content-Style-Type\" content=\"text/css\" />\n");
  print ("<meta http-equiv=\"Content-Script-Type\" content=\"text/javascript\" />\n");
  print ("<title>Map</title>\n");
  print ("</head>\n");
  print ("<body>\n");
  print ("<form method=\"get\">\n");
  print ("<fieldset>\n");
  print ("<table>\n");
  print ("  <tr>\n");
  print ("    <td>Player:</td>\n");
  print ("    <td><input type=\"text\" name=\"player\"/></td>\n");
  print ("  </tr>\n");
  print ("  <tr>\n");
  print ("    <td>Tribe:</td>\n");
  print ("    <td><input type=\"text\" name=\"tribe\"/></td>\n");
  print ("  </tr>\n");
  print ("  <tr>\n");
  print ("    <td>2. Tribe:</td>\n");
  print ("    <td><input type=\"text\" name=\"tribetwo\"/></td>\n");
  print ("  </tr>\n");
  print ("  <tr>\n");
  print ("    <td>Grid</td>\n");
  print ("    <td><input type=\"checkbox\" name=\"grid\" value=\"true\"/></td>\n");
  print ("  </tr>\n");
  print ("  <tr>\n");
  print ("    <td>Continents</td>\n");
  print ("    <td><input type=\"checkbox\" name=\"continents\" value=\"true\"/></td>\n");
  print ("  </tr>\n");
  print ("  <tr>\n");
  print ("    <td>No abandoned</td>\n");
  print ("    <td><input type=\"checkbox\" name=\"noabandoned\" value=\"true\"/></td>\n");
  print ("  </tr>\n");
  print ("  <tr>\n");
  print ("    <td><button type=\"submit\" name=\"map\" value=\"true\">Create</button></td>\n");
  print ("  </tr>\n");
  print ("</table>\n");
  print ("</fieldset>\n");
  print ("</form>\n");
  print ("</body>\n");
  die ("</html>\n");
  }

/* ######################## */
/* #         MySQL        # */
/* #         *****        # */
/* ###################################################################### */
/* # */ if(!db()) die("<h1>MySQL Connecting Error</h1>");            /* # */
/* ###################################################################### */

/* ######################## */
/* #       Hole IDs      # */
/* #       ********      # */
/* ############################################################################################################################################################# */
/* # */ // Spieler                                                                                                                                          /* # */
/* # */ if(!isset($id) and $_GET['player'] != "")                                                                                                           /* # */
/* # */   $id = mysql_fetch_object(mysql_query("SELECT `id` FROM `tw5_player` WHERE `name` LIKE '".urlencode($_GET['player'])."'"))->id;                    /* # */
/* # --------------------------------------------------------------------------------------------------------------------------------------------------------- # */
/* # */ // Stamm                                                                                                                                            /* # */
/* # */ if(!isset($ally) and $_GET['tribe'] != "") {                                                                                                        /* # */
/* # */   $tribe = urlencode($_GET['tribe']);                                                                                                               /* # */
/* # */   $ally = mysql_fetch_object(mysql_query("SELECT `id` FROM `tw5_ally` WHERE `name` LIKE '".$tribe."' OR `tag` LIKE '".$tribe."'"))->id;}            /* # */
/* # --------------------------------------------------------------------------------------------------------------------------------------------------------- # */
/* # */ // Zweiter Stamm                                                                                                                                    /* # */
/* # */ if(!isset($allytwo) and $_GET['tribetwo'] != "") {                                                                                                  /* # */
/* # */   $tribetwo = urlencode($_GET['tribetwo']);                                                                                                         /* # */
/* # */   $allytwo = mysql_fetch_object(mysql_query("SELECT `id` FROM `tw5_ally` WHERE `name` LIKE '".$tribetwo."' OR `tag` LIKE '".$tribetwo."'"))->id;}   /* # */
/* ############################################################################################################################################################# */

/* ######################## */
/* #    Bild erstellen    # */
/* #    **************    # */
/* ###################################################################### */
/* # */ $width = 1050;                                               /* # */
/* # */ $height = 1100;                                              /* # */
/* # */ $img = ImageCreate($width, $height);                         /* # */
/* ###################################################################### */

/* ######################## */
/* #        Farben        # */
/* #        ******        # */
/* ###################################################################### */
/* # */ $black = ImageColorAllocate($img, 0, 0, 0);                  /* # */
/* # */ $cyan = ImageColorAllocate($img, 0, 255, 255);               /* # */
/* # */ $own_yellow = ImageColorAllocate($img, 255, 255, 0);         /* # */
/* # */ $abandoned_grey = ImageColorAllocate($img, 128, 128, 128);   /* # */
/* # */ $floor_green = ImageColorAllocate($img, 70, 120, 40);        /* # */
/* # */ $village_red = ImageColorAllocate($img, 180, 0, 0);          /* # */
/* # */ $tribe_blue = ImageColorAllocate($img, 0, 0, 255);           /* # */
/* # */ $tribe_col_two = ImageColorAllocate($img, 0, 190, 255);      /* # */
/* # */ $tribe_col_three = ImageColorAllocate($img, 255, 128, 128);  /* # */
/* ###################################################################### */

/* ######################## */
/* #    Boden einfärben   # */
/* #    **************    # */
/* ###################################################################### */
/* # */ ImageFill($img, 0, 0, $floor_green);                         /* # */
/* ###################################################################### */



// Falls Stamm gesetzt, hole alle Spieler des Stammes
// **************************************************

if(isset($ally))
  {
  $a = "SELECT `id` FROM `tw5_player` WHERE `ally` LIKE '".$ally."'";
  $b = mysql_query($a);
  $i = 0;
  while($c = mysql_fetch_object($b))
    {
    $tribeMembers[$i] = $c->id;
    $i++;
    }
  }

if(isset($allytwo))
  {
  $a = "SELECT `id` FROM `tw5_player` WHERE `ally` LIKE '".$allytwo."'";
  $b = mysql_query($a);
  $i = 0;
  while($c = mysql_fetch_object($b))
    {
    $tribeMembersTwo[$i] = $c->id;
    $i++;
    }
  }

  $a = "SELECT `id` FROM `tw5_player` WHERE `ally` LIKE '".$ally."'";
  $b = mysql_query($a);
  $i = 0;
  while($c = mysql_fetch_object($b))
    {
    $tribeMembers[$i] = $c->id;
    $i++;
    }


// Alle Dörfer holen
// *****************

$abfrage = "SELECT `x` , `y` , `player` FROM `tw5_village` ORDER BY `x`";
$ergebnis = mysql_query($abfrage);
$i = 0;
while($row = mysql_fetch_object($ergebnis))
  {
  $x = $row->x;
  $y = $row->y;
  $xe = $x - 1;   // Ziehe ein Pixel ab, da Quadrat
  $ye = $y - 1;   // Ziehe ein Pixel ab, da Quadrat

  if($row->player == 0) // Wenn verlassen
    {
    if(!isset($noabandoned)) ImageFilledRectangle($img, $x, $y, $xe, $ye, $abandoned_grey);
    }
  elseif($row->player == $id) // Wenn Spieler markieren
    {
    ImageFilledRectangle($img, $x, $y, $xe, $ye, $own_yellow);
    }
  elseif(isset($ally) and in_array($row->player,$tribeMembers)) // Wenn Stamm markieren
    {
    ImageFilledRectangle($img, $x, $y, $xe, $ye, $tribe_blue);
    }
  elseif(isset($allytwo) and in_array($row->player,$tribeMembersTwo)) // Wenn 2. Stamm markieren
    {
    ImageFilledRectangle($img, $x, $y, $xe, $ye, $tribe_col_two);
    }
  else // Wenn ganz normales Dorf
    {
    ImageFilledRectangle($img, $x, $y, $xe, $ye, $village_red);
    }
  }


/* ######################## */
/* #      Gitternezt      # */
/* #      **********      # */
/* ################################################## */
/* # */// Horizontal, alle 5 Pixel               /* # */
/* # */ if(isset($grid))                         /* # */
/* # */   {                                      /* # */
/* # */   for($i = 5; $i < 1000; $i= $i + 5)     /* # */
/* # */   imageline($img,0,$i,1000,$i,$black);   /* # */
/* # */   }                                      /* # */
/* # ---------------------------------------------- # */
/* # */ // Vertikal, alle 5 Pixel                /* # */
/* # */ if(isset($grid))                         /* # */
/* # */   {                                      /* # */
/* # */   for($i = 5; $i < 1000; $i= $i + 5)     /* # */
/* # */   imageline($img,$i,0,$i,1000,$black);   /* # */
/* # */   }                                      /* # */
/* ################################################## */

/* ######################## */
/* #      Kontinente      # */
/* #      **********      # */
/* ################################################## */
/* # */// Horizontal, alle 100 Pixel             /* # */
/* # */ if(isset($continents))                   /* # */
/* # */   {                                      /* # */
/* # */   for($i = 100; $i < 1000; $i= $i + 100) /* # */
/* # */   imageline($img,0,$i,1000,$i,$cyan);    /* # */
/* # */   }                                      /* # */
/* # ---------------------------------------------- # */
/* # */ // Vertikal, alle 100 Pixel              /* # */
/* # */ if(isset($continents))                   /* # */
/* # */   {                                      /* # */
/* # */   for($i = 100; $i < 1000; $i= $i + 100) /* # */
/* # */   imageline($img,$i,0,$i,1000,$cyan);    /* # */
/* # */   }                                      /* # */
/* ################################################## */




ImageCopy($img,imagecreatefromjpeg("images/map/back.jpg"),0,1000,0,0,1000,100);
ImageCopy($img,imagecreatefrompng("images/map/right.png"),1000,0,0,0,50,1100);



/* ######################## */
/* #     Beschriftung     # */
/* #     ************     # */
/* ######################################################### */
/* # */ // Schriftzug: DS Search                        /* # */
/* # */ $f_scr = imageloadfont("images/map/script.gdf");/* # */
/* # */ $txt = "DS-Search";                             /* # */
/* # */ imagestring ($img,$f_scr,800,1080,$txt,$black); /* # */
/* # ----------------------------------------------------- # */
/* # */ // Zeit für Aufbau                              /* # */
/* # */ $time_end = microtime(true);                    /* # */
/* # */ $time = $time_end - $time_start;                /* # */
/* # */ $time = $time * 1000;                           /* # */
/* # */ $less = "less than one millisecond";            /* # */
/* # */ if($time < 1) { $time = $less; }                /* # */
/* # */          else { $time = round($time). "ms"; }   /* # */
/* # */ $time = "This map was generated in ".$time;     /* # */
/* # */ $col = ImageColorAllocate($img, 0, 128, 255);   /* # */
/* # */ $txt = date("l,d F Y - g:i:sa",time());         /* # */
/* # */ $data = "PNG-ZIP/1.15MPixels@8BitsPerPixel";    /* # */
/* # */ imagestring ($img,3,400,1050,$data,$black);     /* # */
/* # */ imagestring ($img,3,400,1065,$time,$black);     /* # */
/* # */ imagestring ($img,3,400,1080,$txt,$black);      /* # */
/* # ----------------------------------------------------- # */
/* # */ // Welt                                         /* ############# */
/* # */ imagestring ($img , 5 , 30 , 1010 , "World 5" , $black );   /* # */
/* # */ imagestring ($img , 5 , 30 , 1018 , "*******" , $black );   /* # */
/* # ----------------------------------------------------- ############# */
/* # */ // Spieler                                      /* # */
/* # */ if(isset($id))                                  /* # */
/* # */   {                                             /* ################################################################################## */
/* # */   $playername = urldecode(mysql_fetch_object(mysql_query("SELECT `name` FROM `tw5_player` WHERE `id` LIKE '".$id."'"))->name);   /* # */
/* # */   ImageFilledRectangle($img, 30, 1040, 35, 1045, $own_yellow);                  ##################################################### */
/* # */   imagestring ($img , 5 , 45 , 1035 , "Player: ".$playername , $black );     /* # */
/* # */   }                                                                          /* # */
/* # ---------------------------------------------------------------------------------- # */
/* # */ // Stamm                                                                     /* # */
/* # */ if(isset($ally))                                                             /* # */
/* # */   {                                                                          /* ##################################################### */
/* # */   $tribename = urldecode(mysql_fetch_object(mysql_query("SELECT `name` FROM `tw5_ally` WHERE `id` LIKE '".$ally."'"))->name);    /* # */
/* # */   ImageFilledRectangle($img, 30, 1055, 35, 1060, $tribe_blue);                  ##################################################### */
/* # */   imagestring ($img , 5 , 45 , 1050 , "Tribe:  ".$tribename , $black );      /* # */
/* # */   }                                                                          /* # */
/* # ---------------------------------------------------------------------------------- # */
/* # */ // Zweiter Stamm                                                             /* # */
/* # */ if(isset($allytwo))                                                          /* # */
/* # */   {                                                                          /* ######################################################## */
/* # */   $tribenametwo = urldecode(mysql_fetch_object(mysql_query("SELECT `name` FROM `tw5_ally` WHERE `id` LIKE '".$allytwo."'"))->name); /* # */
/* # */   ImageFilledRectangle($img, 30, 1070, 35, 1075, $tribe_col_two);               ######################################################## */
/* # */   imagestring ($img , 5 , 45 , 1065 , "Tribe:  ".$tribenametwo , $black );   /* # */
/* # */   }                                                                          /* # */
/* ###################################################################################### */

/* ######################## */
/* #       Rendering      # */
/* #       *********      # */
/* ######################################################### */
/* # */ // Header senden                                /* # */
/* # */ Header("Content-Type: image/png");              /* # */
/* # ----------------------------------------------------- # */
/* # */ // Als PNG ausgeben                             /* # */
/* # */ ImagePNG($img);                                 /* # */
/* # ----------------------------------------------------- # */
/* # */ // Memory leeren                                /* # */
/* # */ ImageDestroy($img);                             /* # */
/* ######################################################### */

/* ######################## */
/* #      Funktionen      # */
/* #      **********      # */
/* ############################################################################## */
/* # */ // MySQL Verbindung: bool db ( )                                     /* # */
/* # *//* Host: */       $sql_host = "localhost";                            /* # */
/* # *//* User: */       $sql_user = "";                                     /* # */
/* # *//* Password: */   $sql_password = "";                                 /* # */
/* # *//* Database: */   $sql_database = "";                                 /* # */
/* # -------------------------------------------------------------------------- # */
/* # */ function db()                                                        /* # */
/* # */ {                                                                    /* # */
/* # */ // Verbinden mit MySQL                                               /* # */
/* # */ $db_link =  @mysql_connect($sql_host,$sql_user,$sql_password);       /* # */
/* # */   if($db_link)                                                       /* # */
/* # */     $my = true;                                                      /* # */
/* # */   else                                                               /* # */
/* # */     $my = false;                                                     /* # */
/* # */ // MySQL Datenbank auswählen                                         /* # */
/* # */ if(mysql_select_db($sql_database, $db_link))                         /* # */
/* # */   $db = true;                                                        /* # */
/* # */ else                                                                 /* # */
/* # */   $db = false;                                                       /* # */
/* # */ if($my and $db)                                                      /* # */
/* # */   return true;                                                       /* # */
/* # */ else                                                                 /* # */
/* # */   return false;                                                      /* # */
/* # */ }                                                                    /* # */
/* ############################################################################## */
?>