<?php
function compareValues($x1,$x2,$integer = true,$formatint = false,$invert = false)
  {
  if($integer)
    {
    $x1 = intval($x1);
    $x2 = intval($x2);
    }
  if($invert)
    {
    $x1 = $x1 * -1;
    $x2 = $x2 * -1;
    }
  if(is_int($x1) and is_int($x2))
    {
    if(!$formatint)
      {
      $dif = $x1 - $x2;
      if($dif < 0)
        $output = "<span class=\"negativeValues\">Negative (".$dif.")</span>";
      elseif($dif > 0)
        $output = "<span class=\"positiveValues\">Positive (+".$dif.")</span>";
      elseif($dif == 0)
        $output = "<span class=\"equalValues\">Equal</span>";
      }
    elseif($formatint)
      {
      $dif = $x1 - $x2;
      if($dif < 0)
        $output = "<span class=\"negativeValues\">Negative (".number_format($dif).")</span>";
      elseif($dif > 0)
        $output = "<span class=\"positiveValues\">Positive (+".number_format($dif).")</span>";
      elseif($dif == 0)
        $output = "<span class=\"equalValues\">Equal</span>";
      }
    return $output;
    }
  elseif(is_string($x1) and is_string($x2))
    {
    if($x1 == $x2)
      $output = "<span class=\"equalValues\">Equal</span>";
    else
      $output = "<span class=\"negativeValues\">Different</span>";
    return $output;
    }
  }
?>