<?php

// include composer autoload
require 'intervention/vendor/autoload.php';

// import the Intervention Image Manager Class
use Intervention\Image\ImageManagerStatic as Image;

// configure with favored image driver (gd by default)
Image::configure(array('driver' => 'gd'));

// and you are ready to go ...
//capturing the image
$frame = Image::make('id.jpg');
$pp = Image::make('pp.jpg');


//edited the image
$pp->resize(160, 160);


$frame->insert($pp, 'top-left', 558, 56);

//Name to image
$frame->text('Aziz Ahmed', 35, 145, function($font) {
    $font->file('font.ttf');
    $font->size(24);
    $font->color('#5E5653');
    $font->align('top-left');
    $font->valign('top');
    $font->angle(0);
});



//Gender to image
$frame->text('Male', 35, 207, function($font) {
    $font->file('font.ttf');
    $font->size(24);
    $font->color('#5E5653');
    $font->align('top-left');
    $font->valign('top');
    $font->angle(0);
});


//Birth Day to image
$frame->text('29 Nov,1999', 35, 280, function($font) {
    $font->file('font.ttf');
    $font->size(24);
    $font->color('#5E5653');
    $font->align('top-left');
    $font->valign('top');
    $font->angle(0);
});



//Personality to image
$frame->text('Popular,Sensitive', 35, 345, function($font) {
    $font->file('font.ttf');
    $font->size(24);
    $font->color('#5E5653');
    $font->align('top-left');
    $font->valign('top');
    $font->angle(0);
});



//Location to image
$frame->text('Khilkhet,Dhaka', 338, 280, function($font) {
    $font->file('font.ttf');
    $font->size(24);
    $font->color('#5E5653');
    $font->align('top-left');
    $font->valign('top');
    $font->angle(0);
});



//Personality to image
$frame->text('946427964265928', 338, 345, function($font) {
    $font->file('font.ttf');
    $font->size(18);
    $font->color('#5E5653');
    $font->align('top-left');
    $font->valign('top');
    $font->angle(0);
});




//saved the image
$frame->save('edited.jpg');
echo $frame->response();
$frame->destroy();
$pp->destroy();

?>
