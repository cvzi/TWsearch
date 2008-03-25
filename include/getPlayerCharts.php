<?php
function quest($key,$date)
{

$timestamp = time();
$daysPerMonth = array("0","31","28","31","30","31","30","31","31","30","31","30","31");
$day = date("d",$timestamp);
$month = date("m",$timestamp);
$year = date("Y",$timestamp);

$month = intval($month);
$day = intval($day);
$date = intval($date);

$day = $day - $date;

if($day <= 0)
  {
  $day = $day - 1;
  $month = $month - 1;
  $decreasedDay = $day + 1;
  $day = $daysPerMonth[intval($month)] + $decreasedDay;
  }

  if($month < 10)
    {
    $month = "0".$month;
    }
  if($day < 10)
    {
    $day = "0".$day;
    }
$table = "tw5_dia_day_".$year."-".$month."-".$day;

  // Konkret:
  //$abfrage = "SELECT * FROM `tw5_dia_day_2008-01-24` WHERE `id` LIKE '1179126'";

$abfrage = "SELECT * FROM `".$table."` WHERE `id` LIKE '".$key."'";
  $ergebnis = mysql_query($abfrage);
  $row = mysql_fetch_object($ergebnis);
  $quest = $row->points;
return $quest;
}
?>