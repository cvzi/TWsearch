<?php
if(!isset($width)) $width = 10;
$img = imagecreate($width, 1);
$color['trans'] = imagecolorallocate($img, 0x00, 0xFF, 0x00);
imagecolortransparent($img, $color['trans']);
header("Content-type: image/png");
imagepng($img);
imagedestroy($img);
?>