<?php
Header("Content-Type: image/png");

$img = ImageCreateFromPNG('world.png');

$black = ImageColorAllocate($img, 0, 0, 0);
$red = ImageColorAllocate($img, 255, 0, 0);
$yellow = ImageColorAllocate($img, 255, 255, 0);
$green = ImageColorAllocate($img, 0, 255, 0);
$white = ImageColorAllocate($img, 255, 255, 255);



$fontLittle = imageloadfont('fonts/cordia_little.gdf');
$fontBig = imageloadfont('fonts/script.gdf');
ImageString($img, $fontLittle, 1, 0, 'cuzi', $red);
ImageString($img, $fontBig, 5, 3, $text, $black);



ImagePNG($img); # Hier wird das Bild PNG zugewiesen
ImageDestroy($img); # Speicherplatz reinigen

?>