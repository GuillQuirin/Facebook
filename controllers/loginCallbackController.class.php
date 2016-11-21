<?php
class loginCallbackController extends template{
	public function loginCallbackAction($requiredPosts){
		//$v = new view();
		//$this->assignConnectedProperties($v);
		//$v->assign("css", "loginCallback");
		//$v->assign("js", "loginCallback");

		
		$helper = $this->fb->getRedirectLoginHelper();

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
			$oAuth2Client = $this->fb->getOAuth2Client();
			$_SESSION["LONG_ACCESS_TOKEN"] = $oAuth2Client->getLongLivedAccessToken($accessToken);
		}
		else
			unset($_SESSION["ACCESS_TOKEN"]);

		header('Location: '.WEBPATH);
	}
}