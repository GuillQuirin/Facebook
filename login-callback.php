<?php 
require_once __DIR__ . '/vendor/autoload.php';
session_start();

$fb = new Facebook\Facebook([
	'app_id' => '1804945786451180',
	'app_secret' => '0071a8a0031dae4539ae78f37d052dae',
	'default_graph_version' => 'v2.5',
	]);

$helper = $fb->getRedirectLoginHelper();

try {
	$accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
	echo 'Graph returned an error: ' . $e->getMessage();
	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
	exit;
}

if(isset($accessToken)) {
	// Logged in!
	$_SESSION["ACCESS_TOKEN"] = (string) $accessToken;
	
	//Requete d'un access token de 60 jours
	$oAuth2Client = $fb->getOAuth2Client();
	$_SESSION["LONG_ACCESS_TOKEN"] = $oAuth2Client->getLongLivedAccessToken($accessToken);
}
else
	unset($_SESSION["ACCESS_TOKEN"]);

header('Location: index.php');
?>