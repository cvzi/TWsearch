<?php
function getCookiesUsercp($depth=false)
{
$user['ingameName'] = $_COOKIE["User_ingameName"];


if($_COOKIE["User_ownAccRanking"] == "true")
  { $user['ownAccRanking'] = true; }
else
  { $user['ownAccRanking'] = false; }


  if($_COOKIE["User_showOwnInfos"] == "true")
  { $user['showOwnInfos'] = true; }
else
  { $user['showOwnInfos'] = false; }


  if($_COOKIE["User_showRankHomepage"] == "true")
  { $user['showRankHomepage'] = true; }
else
  { $user['showRankHomepage'] = false; }


if(!isset($_COOKIE["User_personalCSS"]) or $_COOKIE["User_personalCSS"] == "")
  {
  $user['personalCSS'] = "style.css";
  }
else
  {
  $user['personalCSS'] = $_COOKIE["User_personalCSS"];
  }
  if(is_numeric($depth) and substr($_COOKIE["User_personalCSS"],0,7) != "http://")
    {
    $local = "";
    $a = 0;
    while($a < $depth)
      {
      $local = "../".$local;
      $a++;
      }
    $user['personalCSS'] = $local.$user['personalCSS'];
    }

return $user;
}
?>