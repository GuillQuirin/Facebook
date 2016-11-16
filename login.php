<?php 
	require_once __DIR__ . '/vendor/autoload.php';
	session_start();
	$fb = new Facebook\Facebook([
	  'app_id' => '1804945786451180',
	  'app_secret' => '0071a8a0031dae4539ae78f37d052dae',
	  'default_graph_version' => 'v2.5',
	]);
	$helper = $fb->getRedirectLoginHelper();
	$permissions = ['email',
					'user_posts','user_likes','user_photos','user_friends',
					'publish_actions',
					'pages_show_list','manage_pages','pages_manage_cta','publish_pages'];
					
	$loginUrl = (isset($_SERVER['HTTPS'])) ? 
					$helper->getLoginUrl('https://egl.fbdev.fr/Facebook/login-callback.php', $permissions);
					: $helper->getLoginUrl('http://egl.fbdev.fr/Facebook/login-callback.php', $permissions);

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Se connecter à FB </title>
		<meta charset="utf-8">
		<script type="text/javascript" src="public/js/jquery-3.1.1.min.js"></script>
		<!--<script type="text/javascript" src="public/js/script.js"></script>-->
	</head>
	<body>
		<h1>Se connecter</h1>
		<!--<fb:login-button scope="public_profile,email" onlogin="checkLoginState();"></fb:login-button>
		<button id="subscribe">S'inscrire</button>
		<button id="disconnect">Se déconnecter</button>
		<div id="status"></div>-->
		<a href='<?php echo $loginUrl;?>'>Se connecter</a>
	</body>
</html>
