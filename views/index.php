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
	<?php
	endif;
	?>


<?php echo (isset($_SESSION['ACCESS_TOKEN'])) ? "Vous avez une session ACCESS_TOKEN" : "Vous n'avez pas de session ACCESS_TOKEN"; ?>