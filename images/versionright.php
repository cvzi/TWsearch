<?php
require("../version.php");
$img = ImageCreateFromPNG('versionright.png');
$green = ImageColorAllocate($img, 0, 128, 0);
ImageString($img, 3, 31, 1, $versionNumber, $green);
Header("Content-Type: image/png");
ImagePNG($img);
ImageDestroy($img);
?>