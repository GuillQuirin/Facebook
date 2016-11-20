<?php
class loginCallbackController extends template{
	public function loginCallbackAction($requiredPosts){
		$v = new view();
		$this->assignConnectedProperties($v);
		$v->assign("css", "loginCallback");
		//$v->assign("js", "loginCallback");

		/*
		//Liste Tournois
		$obj = new tournamentManager();
		//Le paramètre par défaut vaut NULL si l'utilisateur n'est pas connecté
		$listetournois = $obj->getUnstartedTournaments($this->connectedUser);
		if(!!($listetournois)){
			$v->assign("listeTournois", $listetournois);
		}
		*/
		//$v->setView("loginCallback");
		require_once 'egl.fbdev.fr/EGL/web/vendor/autoload.php';
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

header('Location: '.WEBPATH);
	}
}