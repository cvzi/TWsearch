<?php
function englishNumerationSuffix($num)
  {

  if(substr($num, (strlen($num)-1), 1)==1)
    {
    $suff = "st";
    }
  else if(substr($num, (strlen($num)-1), 1)==2)
    {
    $suff = "nd";
    }
  else if(substr($num, (strlen($num)-1), 1)==3)
    {
    $suff = "rd";
    }
  else
    {
    $suff = "th";
    }
  return $num.$suff;
  }
?>