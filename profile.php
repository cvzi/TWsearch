<?php
header("Content-type: application/xhtml+xml; charset=utf-8'");
header("Content-Script-Type: text/javascript");
header("Content-Style-Type: text/css");
print("<?xml version=\"1.0\" encoding=\"UTF-8\" ?>");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<style type="text/css">
/* <![CDATA[ */
a:link	{ font-weight:bold; color: #804000; text-decoration:none; }
a:visited	{  font-weight:bold; color: #804000; text-decoration:none; }
a:active	{  font-weight:bold; color: #0082BE; text-decoration:none; }
a:hover { font-weight:bold; color: #0082BE; text-decoration:none; }
/* ]]> */
</style>
<title></title>
</head>
<body style="background-color:rgb(239,234,220); ">
<?php



if(!isset($id)) $id = $_GET['id'];
$src = "http://en5.tribalwars.net/guest.php?screen=info_player&id=".$id;

$fp=file($src);


$inhalt = implode("\n",$fp);
$inhalt = split("<tr><th>Personal text</th></tr>",$inhalt);
$inhalt[1] = split("<tr><td align=\"center\">",$inhalt[1]);
$inhalt[1][1] = split("</td></tr>",$inhalt[1][1]);

$profileCode = $inhalt[1][1][0];

?>
<div style="font-family: Verdana, Arial; font-size:10pt; background-color:rgb(224,215,189); color:black; text-align:left; width:auto; font-weight:bold; ">Personal text</div>
<div style="font-family: Verdana, Arial; font-size:10pt; background-color:rgb(246,242,232); color:black; text-align:center; width:auto; ">
<?php echo $profileCode; ?>
</div>

<?php
// Profilbild

$inhalt = implode("\n",$fp);
$wetherOrNot = eregi("alt=",$inhalt);
if($wetherOrNot)
  {
  $first = explode("<td colspan=\"2\" align=\"center\"><img src=\"",$inhalt);
  $second = explode("\" alt=\"Personal picture\"",$first[1]);
  $url = $second[0];
  $picCode = "<img src=\"http://en5.tribalwars.net/".$url."\" alt=\"Personal picture\" />";
  echo "<br />\n";
  echo "<div style=\"font-family: Verdana, Arial; font-size:10pt; background-color:rgb(224,215,189); color:black; text-align:left; width:auto; font-weight:bold; \">Personal picture</div>\n";
  echo "<div style=\"font-family: Verdana, Arial; font-size:10pt; background-color:rgb(246,242,232); color:black; text-align:center; width:auto; \">\n";
  echo $picCode;
  echo "</div>\n";
  }
else
  {
  echo "<!-- No personal picture -->\n";
  }
?>


</body>
</html>