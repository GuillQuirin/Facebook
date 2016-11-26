	<h1>PROJET DEV FB</h1>


<?php 

	if(isset($competition)) :?>
		<div>
			CONCOURS PHOTOS TEST
				du <?php echo $competition->getStart_date(); ?> au <?php echo $competition->getEnd_date(); ?>
 
			ENVOIE-NOUS TON PLUS BEAU TATOUAGE EN PHOTO !
			TENTE DE GAGNER
			<?php 
			/*echo $competition->getPrize();
			if($competition->getUrlPrize()!==NULL)
				echo "<img src='".$competition->getUrlPrize()."' alt='photo du prix'>";
			*/
			?>
		</div>
		<?php echo $urlLoginLogout; ?>
		<a href="<?php echo WEBPATH; ?>/admin">Administration</a>
	<?php
	endif;
	?>


<?php echo (isset($_SESSION['ACCESS_TOKEN'])) ? "Vous avez une session ACCESS_TOKEN" : "Vous n'avez pas de session ACCESS_TOKEN"; ?>


<?php 
	/*$response = $fb->get('/me?fields=id,name,email,birthday,location');
	$pages = $response->getGraphUser();
	echo "<pre>";
	print_r($pages);
	$user = new user($pages);
*/

//echo (isset($_SESSION['ACCESS_TOKEN'])) ? "Vous êtes ".$user->getNom() : "Vous n'avez pas de nom."; ?>