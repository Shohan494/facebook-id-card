<?php

function watermark_image($target, $wtrmrk_file, $newcopy) {
    $watermark = imagecreatefromjpeg($wtrmrk_file);
    imagealphablending($watermark, false);
    imagesavealpha($watermark, true);
    $img = imagecreatefromjpeg($target);
    $img_w = imagesx($img);
    $img_h = imagesy($img);
	
	
	$profile_request = $fb->get('/me?fields=name,first_name,last_name,email');
		$profile = $profile_request->getGraphNode()->asArray();

	
	//text wt
	$fontSize = 100;
	$text = "Aziz Ahmed";
	$xPosition = 262;
	$yPosition = 132;
	$fontColor = imagecolorallocate($img, 255, 0, 0);
	
	
	//resize
	$newwm = imagecreatetruecolor(150, 180);
	$wtrmrk_w = imagesx($watermark);
    $wtrmrk_h = imagesy($watermark);
	
	
    $dst_x = ($img_w / 2) - ($wtrmrk_w / 2); // For centering the watermark on any image
    $dst_y = ($img_h / 2) - ($wtrmrk_h / 2); // For centering the watermark on any image
    //imagecopy($img, $watermark, $dst_x, $dst_y, 0, 0, $wtrmrk_w, $wtrmrk_h);
	imagecopyresized($newwm, $watermark, 0, 0, 0, 0, 150, 180, $wtrmrk_w, $wtrmrk_h);
	imagecopy($img, $newwm, 32, 92, 0, 0, 150, 180);
	imagestring($img, $fontSize, $xPosition, $yPosition, $text, $fontColor);
    imagejpeg($img, $newcopy, 100);
    imagedestroy($img);
    imagedestroy($watermark);
}





watermark_image('1.jpg', '2.jpg', 'new_image_name.jpg');

echo '<img src="new_image_name.jpg"/>'

?>