<?php
require("include/function.getCookiesUsercp.php");
$cookieData = getCookiesUsercp();
if($action == "admin" and isset($masterpassword))
  {
  $hour = 60*60;
  $day = $hour*24;
  $week = $day*7;
  $month = $day*30;
  $year = $day*365;
  setCookie("schedule_masterpassword",$masterpassword,Time()+$day*14);
  }
if(isset($_COOKIE['schedule_masterpassword'])) $masterpassword = $_COOKIE['schedule_masterpassword'];

if($action == "plan" and isset($userpassword))
  {
  $hour = 60*60;
  $day = $hour*24;
  $week = $day*7;
  $month = $day*30;
  $year = $day*365;
  setCookie("schedule_userpassword",$userpassword,Time()+$day*14);
  }
if(isset($_COOKIE['schedule_userpassword'])) $userpassword = $_COOKIE['schedule_userpassword'];

print ("<?xml version=\"1.0\" encoding=\"ISO-8859-1\" ?>\n"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>TW-Search</title>
<link rel="stylesheet" type="text/css" title="User Style" href="<?php echo $cookieData['personalCSS']; ?>" />
<link rel="alternate stylesheet" type="text/css" title="Old Style" href="oldstyle.css" />
<link rel="alternate stylesheet" type="text/css" title="Normal Style" href="style.css" />
<link rel="alternate" type="application/rss+xml" title="News" href="feed.php" />

<script type="text/javascript">
//<![CDATA[
function rand(max)
{
return Math.ceil(Math.random() * 1000) % max + 1;
}
function randomStr(field,min,max,chars)
  {
  if(!chars)
    {
    chars = "0123456789abcdefghijklmnopqrstuvwxyz";
    }
  stringlength = rand(max);
  i = 0;
  result = "";
  while(i < stringlength || i < min)
    {
    result = result + chars[rand(chars.length-1)];
    i++;
    }
  field.value = result;
  }

function showHide(num)
  {
  if(document.getElementById(num).style.display == 'none')
    {
    document.getElementById(num).style.display='block'; 
    }
  else
    {
    document.getElementById(num).style.display='none';
    }				
  }
//]]>
</script>


</head>
<body>
<?php
// Head
require("head.php");

// Post variablen
if(!isset($action)) $action = $_POST['action'];
if(!isset($schedulename)) $schedulename = $_POST['schedulename'];
if(!isset($masterpassword)) $masterpassword = $_POST['masterpassword'];
if(!isset($userpassword)) $userpassword = $_POST['userpassword'];
if(!isset($scheduletype)) $scheduletype = $_POST['scheduletype'];


// Delimiter
$new_delimiter = "(+)";
$delimiter = "(-)";
$subdelimiter = "(--)";

// Stars instead of a password
function createStars($string)
  {
  $number = strlen($string);
  $stars = "";
  for($i = 1; $i <= $number; $i++) $stars .= "*";
  return $stars;
  }


print ("<table class=\"main\" style=\"text-align:left; margin-left:auto; margin-right:auto\" cellspacing=\"3\">\n");
print ("\n");
print ("<tr>\n");
print ("<td>\n");
include("include/menu.php");
print ("</td>\n");
print ("</tr>\n");

print ("<tr>\n");
print ("<th class=\"mainTD\" colspan=\"2\">\n");
print ("<h2>Attack Timer - ".$worldname."</h2>\n");
print ("</th>\n");
print ("</tr>\n");
print ("<tr>\n");
print ("<td class=\"mainTD\" valign=\"top\">\n");

if(!isset($action))
  {
  print ("<h3><a href=\"".$selffile."?action=new\">New attack schedule</a></h3>\n");
  print ("<p style=\"color:black; \">This is a tool that can plan attacks, noble trains, support and other stuff.<br />\n");
  print ("Expired plans will be deleted after some days!<br /><br />\n");
  print ("This is a beta version,<br /><br />\n");
  print ("there's no absolute guarantee that times and troops are always correct! I’m not a machine (...not yet).<br />\n");
  print ("</p>\n");
  }

elseif($action == "new")
  {
  require("include/attack/html.new.php");
  }

elseif($action == "review")
  {
  require("include/attack/html.review.php");
  }

elseif($action == "create")
  {
  // Tabelle erstellen
  $sql = "CREATE TABLE IF NOT EXISTS `phost100057`.`tw5_attackplan`
          (`name` VARCHAR(255) NOT NULL,
           `time` INT(255) NOT NULL,
           `type` VARCHAR(10) NOT NULL,
           `masterpassword` VARCHAR(255) NOT NULL,
           `userpassword` VARCHAR(255) NOT NULL,
           `attacks` LONGTEXT NOT NULL)
          ENGINE = MyISAM";
  mysql_query($sql);


  // Tabelle füllen

  $sql = "INSERT `phost100057`.`tw5_attackplan` SET
          `name` = '".$schedulename."',
           `time` = '".time()."',
           `type` = '".$scheduletype."',
           `masterpassword` = '".md5($masterpassword)."',
           `userpassword` = '".md5($userpassword)."',
           `attacks` = ''";
  mysql_query($sql);


  print ("<h2>Third Step - Administration</h2>\n");

  print ("<form action=\"".$selffile."\" method=\"post\">\n");

  print ("<h3>Schedule created!</h3>\n");

  print ("<input type=\"submit\" value=\"Open Administration\">\n");

  print ("<input type=\"hidden\" name=\"schedulename\" value=\"".$schedulename."\" />\n");
  print ("<input type=\"hidden\" name=\"masterpassword\" value=\"".$masterpassword."\" />\n");
  print ("<input type=\"hidden\" name=\"action\" value=\"admin\" />\n");
  print ("</form>\n");
  }

elseif($action == "admin")
  {
  if(!isset($masterpassword))
    {
    print ("<form action=\"".$selffile."\" method=\"post\">\n");
    print ("<h3>Administration Login</h3>\n");
    print ("Password: <input type=\"password\" name=\"masterpassword\" />\n");
    print ("<input type=\"hidden\" name=\"action\" value=\"admin\" />\n");
    print ("<input type=\"hidden\" name=\"schedulename\" value=\"".$schedulename."\" />\n");
    print ("<input type=\"submit\" value=\"Open Administration\" />\n");
    print ("</form>\n");
    }
  else
    {
    $sql = "SELECT `masterpassword` FROM `tw5_attackplan` WHERE `name` LIKE '".$schedulename."'";
    $pass_query = mysql_query($sql);
    $pass_result = mysql_fetch_object($pass_query);
    if($pass_result->masterpassword != md5($masterpassword)) exit("<h1 style=\"color:red; \">Password wrong!</h1>");
    print ("<h3>Administration</h3>\n");
    // Hole Infos
    $sql = "SELECT * FROM `tw5_attackplan` WHERE `name` LIKE '".$schedulename."'";
    $query = mysql_query($sql);
    $row = mysql_fetch_object($query);

    print ("<form action=\"".$selffile."\" method=\"post\">\n");

    print ("<div style=\"background-color:rgb(222,184,135);\">\n");
    print ("<div class=\"mains\">\n");
    print ("Attacks</div>\n");

    print ("<div class=\"contens\">\n");

    print ("<table class=\"attackTable\">\n");
    print ("<tr>\n");
    print ("<th>Type</th><th>Origin</th><th>Target</th><th>Time to send</th><th>Arrival</th><th>Notes</th><th>Units</th><th>Operation</th>\n");
    print ("</tr>\n");

    require("include/attack/function.encodeAttacks.php");
    encodeAttacks($schedulename,$row->attacks);
    print ("</table>\n");

    print ("<input type=\"submit\" name=\"index\" value=\"Add Attack\" />\n");
	print ("<input type=\"submit\" name=\"index\" value=\"Delay attacks\" />\n");
	print ("<button type=\"button\" onclick=\"window.location.href='attack.php?action=admin&schedulename=".$schedulename."';\">Refresh</button\n");
    print ("</div>\n");
    print ("</div>\n");
      
    if(!isset($index)) $index = $_POST['index'];
    if($index == "Add Attack")
      {
      require("include/attack/html.addattack.php");
      }
    elseif($index == "Save new attack")
      {
      require("include/attack/save-decodeAttack.php");
      }
    elseif($index == "delattack" and isset($attid))
      {
      require("include/attack/delAttack.php");    
      }  
    
    
    print ("<input type=\"hidden\" name=\"masterpassword\" value=\"$masterpassword\" />\n");
    print ("<input type=\"hidden\" name=\"schedulename\" value=\"".$schedulename."\" />\n");
    print ("<input type=\"hidden\" name=\"action\" value=\"admin\" />\n");
    print ("</form>\n");
    }
  }


elseif($action == "plan")
  {
  if(!isset($userpassword))
    {
    print ("<form action=\"".$selffile."\" method=\"post\">\n");
    print ("<h3>Login</h3>\n");
    print ("Password: <input type=\"password\" name=\"userpassword\" />\n");
    print ("<input type=\"hidden\" name=\"action\" value=\"plan\" />\n");
    print ("<input type=\"hidden\" name=\"schedulename\" value=\"".$schedulename."\" />\n");
    print ("<input type=\"submit\" value=\"Open Schedule\" />\n");
    print ("</form>\n");
    }
  else
    {
    $sql = "SELECT `userpassword` FROM `tw5_attackplan` WHERE `name` LIKE '".$schedulename."'";
    $pass_query = mysql_query($sql);
    $pass_result = mysql_fetch_object($pass_query);
    if($pass_result->userpassword != md5($userpassword)) exit("<script type=\"text/javascript\">document.cookie = 'schedule_masterpassword=; expires=Thu, 01-Jan-70 00:00:01 GMT;';</script><h1 style=\"color:red; \">Password wrong!</h1>");
    print ("<h3>Overview</h3>\n");
    // Hole Infos
    $sql = "SELECT * FROM `tw5_attackplan` WHERE `name` LIKE '".$schedulename."'";
    $query = mysql_query($sql);
    $row = mysql_fetch_object($query);

    print ("<form action=\"".$selffile."\" method=\"post\">\n");

    print ("<div style=\"background-color:rgb(222,184,135);\">\n");
    print ("<div class=\"mains\">\n");
    print ("Attacks</div>\n");

    print ("<div class=\"contens\">\n");

    print ("<table class=\"attackTable\">\n");
    print ("<tr>\n");
    print ("<th>Type</th><th>Origin</th><th>Target</th><th>Time to send</th><th>Arrival</th><th>Notes</th><th>Units</th>\n");
    print ("</tr>\n");

    require("include/attack/function.encodeAttacks_User.php");
    encodeAttacks_User($schedulename,$row->attacks);
    print ("</table>\n");

	print ("<button type=\"button\" onclick=\"window.location.href='attack.php?action=plan&schedulename=".$schedulename."';\">Refresh</button\n");
    print ("</div>\n");
    print ("</div>\n");  
    
    print ("<input type=\"hidden\" name=\"userpassword\" value=\"$userpassword\" />\n");
    print ("<input type=\"hidden\" name=\"schedulename\" value=\"".$schedulename."\" />\n");
    print ("<input type=\"hidden\" name=\"action\" value=\"plan\" />\n");
    print ("</form>\n");
    }
  }
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