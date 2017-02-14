<?php
// Pass session data over.
session_start();
 
// Include the required dependencies.
require_once( 'fb_sdk/vendor/autoload.php' );
require 'intervention/vendor/autoload.php';
use Intervention\Image\ImageManagerStatic as Image;



// Initialize the Facebook PHP SDK v5.
$fb = new Facebook\Facebook([
  'app_id'                => '1894453310791272',
  'app_secret'            => '2afede5ba2ad2478224f90d759933be5',
  'default_graph_version' => 'v2.3',
]);



$helper = $fb->getRedirectLoginHelper();

$permissions = ['email']; // optional
	
try {
	if (isset($_SESSION['facebook_access_token'])) {
		$accessToken = $_SESSION['facebook_access_token'];
	} else {
  		$accessToken = $helper->getAccessToken();
	}
} catch(Facebook\Exceptions\FacebookResponseException $e) {
 	// When Graph returns an error
 	echo 'Graph returned an error: ' . $e->getMessage();

  	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
 	// When validation fails or other local issues
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
  	exit;
 }

if (isset($accessToken)) {
	if (isset($_SESSION['facebook_access_token'])) {
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	} else {
		// getting short-lived access token
		$_SESSION['facebook_access_token'] = (string) $accessToken;

	  	// OAuth 2.0 client handler
		$oAuth2Client = $fb->getOAuth2Client();

		// Exchanges a short-lived access token for a long-lived one
		$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);

		$_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;

		// setting default access token to be used in script
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	}

	// redirect the user back to the same page if it has "code" GET variable
	if (isset($_GET['code'])) {
		header('Location: http://localhost');
	}

	// getting basic info about user
	try {
		$profile_request = $fb->get('/me?fields=id,name,first_name,last_name,email,gender,location');
		$profile = $profile_request->getGraphNode()->asArray();
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		echo 'Graph returned an error: ' . $e->getMessage();
		session_destroy();
		// redirecting user back to app login page
		header("Location: http://localhost");
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}
	
	// printing $profile array on the screen which holds the basic info about user
	print_r($profile);
	echo '<img src="https://graph.facebook.com/' . $profile['id'] . '/picture?type=large"/> <br/>';
	echo 'Name: ' . $profile['name'] . '<br/>';
	echo 'Email: ' . $profile['email'] . '<br/>';
	echo 'ID: ' . $profile['id'] . '<br/>';
	
	
	
	////Image
	
	
	
	
	// include composer autoload
//require 'intervention/vendor/autoload.php';

// import the Intervention Image Manager Class
//use Intervention\Image\ImageManagerStatic as Image;

// configure with favored image driver (gd by default)
Image::configure(array('driver' => 'gd'));

// and you are ready to go ...
//capturing the image
$frame = Image::make('id.jpg');
$pp = Image::make('https://graph.facebook.com/' . $profile['id'] . '/picture?type=large');


//edited the image
$pp->resize(160, 188);
//$pp->rotate(-45);
$frame->insert($pp, 'top-left', 28, 87);

//text to image
// configure with favored image driver (gd by default)
Image::configure(array('driver' => 'gd'));

// and you are ready to go ...
//capturing the image
$frame = Image::make('id.jpg');
$pp = Image::make('https://graph.facebook.com/' . $profile['id'] . '/picture?type=large');


//edited the image
$pp->resize(160, 160);


$frame->insert($pp, 'top-left', 558, 56);

//Name to image
$frame->text($profile['name'], 35, 145, function($font) {
    $font->file('font.ttf');
    $font->size(24);
    $font->color('#5E5653');
    $font->align('top-left');
    $font->valign('top');
    $font->angle(0);
});



//Gender to image
$frame->text($profile['gender'], 35, 207, function($font) {
    $font->file('font.ttf');
    $font->size(24);
    $font->color('#5E5653');
    $font->align('top-left');
    $font->valign('top');
    $font->angle(0);
});


//Birth Day to image
$frame->text($profile['date'], 35, 280, function($font) {
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
$frame->text($profile['location'], 338, 280, function($font) {
    $font->file('font.ttf');
    $font->size(24);
    $font->color('#5E5653');
    $font->align('top-left');
    $font->valign('top');
    $font->angle(0);
});



//Personality to image
$frame->text($profile['id'], 338, 345, function($font) {
    $font->file('font.ttf');
    $font->size(18);
    $font->color('#5E5653');
    $font->align('top-left');
    $font->valign('top');
    $font->angle(0);
});




//saved the image
$frame->save('edited.jpg');
echo '<img src="edited.jpg"/> <br/>';
$frame->destroy();
$pp->destroy();

	
	
	//image close



  	// Now you can redirect to another page and use the access token from $_SESSION['facebook_access_token']
} else {
	// replace your website URL same as added in the developers.facebook.com/apps e.g. if you used http instead of https and you used non-www version or www version of your website then you must add the same here
	$loginUrl = $helper->getLoginUrl('http://localhost', $permissions);
	echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
}






?>