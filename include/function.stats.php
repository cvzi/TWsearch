<?php
#echo "<style>";
#echo "* { background-color:midnightblue; color:orange; }";
#echo "</style> ";

#error_reporting(E_ALL);
#$greenb = "<span style=\"color:lime; \">";
#$greene = "</span>";

#echo $greenb."Datum: ".$greene;
$date = date("Y-m-d-H-i");
#echo $date;

#echo $greenb."<br />IP: ".$greene;
$ipAddress = $_SERVER['REMOTE_ADDR'];
#echo $ipAddress;

#echo $greenb."<br />Host: ".$greene;
$hostName = gethostbyaddr($_SERVER['REMOTE_ADDR']);
#echo $hostName;

#echo $greenb."<br />Remote Port: ".$greene;
$remotePort = $_SERVER['REMOTE_PORT'];
#echo $remotePort;

#echo $greenb."<br />Sprachversion: ".$greene;
$language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
#echo $language;

#echo $greenb."<br />Browser: ".$greene;
$browser = $_SERVER['HTTP_USER_AGENT'];
#echo $browser;

#echo $greenb."<br />Protokoll: ".$greene;
$protocol = $_SERVER['SERVER_PROTOCOL'];
#echo $protocol;

#echo $greenb."<br />Referer: ".$greene;
if(isset($_SERVER['HTTP_REFERER']))
  {
  $referer = $_SERVER['HTTP_REFERER'];
  }
else
  {
  $referer = 0;
  }
#echo $referer;

#echo $greenb."Dateiname: ".$greene;
$fileName = $_SERVER['PHP_SELF'];
if($_SERVER['QUERY_STRING'] != "")
  {
  $fileName .= "?".$_SERVER['QUERY_STRING'];
  }
#echo $fileName;

#echo $greenb."<br />Login: ".$greene;
$login = 0;
#echo $login;


// Verbinden mit MySQL


$db_link =  @mysql_connect("localhost","phost100057","asdfghjkl");
    if($db_link) {
        $mysqlconnect = 1;
        #echo "<br /><br />Verbunden";
    } else {
        $mysqlconnect = 0;
    }

// MySQL Datenbank auswählen

    if(mysql_select_db("phost100057", $db_link)) {
        $mysqldb = 1;
        #echo "<br /><br />Datenbank<br /><br />";
    } else {
        $mysqldb = 0;
    }

list($y,$m,$d,$h,$i) = explode("-",$date);
$day = $y."-".$m."-".$d;
$mysqlvalue = "INSERT INTO `stats` (`ip`,
                                         `date`,
                                         `time`,
                                         `host`,
                                         `remoteport`,
                                         `language`,
                                         `protocol`,
                                         `referer`,
                                         `file`,
                                         `browser`,
                                         `login`)
               VALUES                   ('".$ipAddress."',
                                         '".$day."',
                                         '".$date."',
                                         '".$hostName."',
                                         '".$remotePort."',
                                         '".$language."',
                                         '".$protocol."',
                                         '".$referer."',
                                         '".$fileName."',
                                         '".$browser."',
                                         '".$login."')";

#var_dump($mysqlvalue);

$mysqlquery = mysql_query($mysqlvalue);

#echo "<br /><br />Erfolg:<br />";
#var_dump($mysqlquery);


?>