<?php
//start session
session_start();

//generator random
$char1 = rand(1,10);
$char2 = rand(1,3);
$char3 = rand(1,10);
//create image
$img = imagecreatetruecolor(165,40);
if(!$img) exit("Ошибка при создании изображения");
//set up color fill
$color = imagecolorallocate($img, 255, 255, 255); //белый
// set up color of text
$color_text = imagecolorallocate($img, 8, 37, 103); //сапфировый
//filling
imagefill($img,0,0, $color);
//is writing text
$arial = "fonts/arial.ttf";
imagettftext($img, 20, 0, 20, 25, $color_text, $arial, "$char1 *  $char2 + $char3");
$_SESSION['captcha']  = $char1 *  $char2 + $char3;
//a little bit noises
imageline($img,0,rand(0,24),130,rand(0,40),$color);
imageline($img,0,rand(0,24),130,rand(0,40),$color);
imageline($img,0,rand(0,24),130,rand(0,40),$color);
//Определяем видимость как изображение
//define visible how is image
header("Content-type: image/png");
//create png image
imagepng($img);
//clean up memory
imagedestroy($img);
?>