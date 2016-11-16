<?php 
	require_once __DIR__ . '/vendor/autoload.php';
	session_start();

	unset($_SESSION["ACCESS_TOKEN"]);
	header("Location: http://egl.fbdev.fr/Facebook/");
?>
