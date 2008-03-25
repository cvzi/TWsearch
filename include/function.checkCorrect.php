<?php
function checkCorrect($text)
  {
  if(isset($text))
    {
    if($text == "0")
      {
      return "<span class=\"negativeValues\">Failed</span>";
      }
    elseif($text == 1)
      {
      return "<span class=\"positiveValues\">Okay</span>";
      }
    else
      {
      return "<span class=\"positiveValues\">Okay</span> (".$text.")";
      }
    }
  else
    {
    return "<span class=\"equalValues\">Undefined</span>";
    }
  }
?>