<?php
include("begin.php");
include($cms['tngpath'] . "genlib.php");

$tngprint = 1;
include($cms['tngpath'] . "checklogin.php");
include($cms['tngpath'] . "imageutils.php");

header('Content-type: image/jpeg');
$maxsize = 380;

$path = urldecode($path);
if(!empty($crop)) {
	$crop = explode('.', $crop);
}
else 
	$crop = null;
$imagename = "$rootpath$path";
$photoinfo = @GetImageSize( $imagename );
switch($photoinfo[2]) {
	case 1: //GIF
		$image = @imageCreateFromGif( $imagename );
		break;
	case 3: //PNG
		$image = @imageCreateFromPng( $imagename );
		break;
	default: //JPEG
		$image = @imageCreateFromJpeg( $imagename );
		break;
}
if(is_array($crop)) {
	$image = @imagecrop($image, ['x' => intval($crop[0]), 'y' => intval($crop[1]), 'width' => intval($crop[2]), 'height' => intval($crop[3])]);
    if($image !== FALSE) {
        $photoinfo[0] = $crop[2];
        $photoinfo[1] = $crop[3];
    }
}
if( $photoinfo[0] <= $maxsize && $photoinfo[1] <= $maxsize ) {
	$photohtouse = $photoinfo[1];
	$photowtouse = $photoinfo[0];
}
else {
	if( $photoinfo[0] > $photoinfo[1] ) {
		$photowtouse = $maxsize;
		$photohtouse = intval( $maxsize * $photoinfo[1] / $photoinfo[0] ) ;
	}
	else {
		$photohtouse = $maxsize;
		$photowtouse = intval( $maxsize * $photoinfo[0] / $photoinfo[1] ) ;
	}
}

// Resample
$image_resized = @imagecreatetruecolor($photowtouse, $photohtouse);
@imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $photowtouse, $photohtouse, $photoinfo[0], $photoinfo[1]);

$image_resized = tngImageRotate($imagename, $image_resized);
// Display resized image
imagejpeg($image_resized);
?>
