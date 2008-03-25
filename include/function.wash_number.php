<?php

function wash_number($x)
  {
  require("translation.php");
  if($text['setting_numberFormat'] == "us")
    {
    return number_format($x,0,".",",");
    }
  elseif($text['setting_numberFormat'] == "de")
    {
    return number_format($x,0,",",".");
    }
  }
?>