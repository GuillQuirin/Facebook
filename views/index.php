<?php  
	if(isset($_SESSION['ACCESS_TOKEN'])){
		$response = $fb->get('1804945786451180/roles',"1804945786451180|yqj6xWNaG2lUvVv3sfwwRbU5Sjk");
		$admins = $response->getDecodedBody();

		foreach ($admins['data'] as $key => $admin) {
			if($admin['role']=="administrators")
				$listAdmins[] = $admin['user'];
		}

		$response = $fb->get('/me?fields=id,name,first_name,last_name,email,birthday,location');
		$user = $response->getGraphUser();
	}
	if(isset($competition)) :?>
		<div class="row">
			<div class="col-md-2">
				<img class="img-thumbnail" src="https://scontent-fra3-1.xx.fbcdn.net/v/t1.0-9/552345_420640654657180_1666928990_n.jpg?oh=7e0262fb4fa4671e45c13bfefcbfc4ef&oe=58C27523" alt="logo">
			</div>
			<div class="col-md-4 col-md-offset-2 text-center">
				<h1>CONCOURS <?php echo $competition->getName(); ?></h1>
				<p>
					du <?php echo date('d/m/Y', strtotime($competition->getStart_date())); ?>
					au <?php echo date('d/m/Y', strtotime($competition->getEnd_date())); ?>
				</p>
	 			----------------------------------------------
	 			<h2><?php echo $competition->getDescription(); ?></h3>
				----------------------------------------------
				<h2>TENTE DE GAGNER :</h2>
				<h3><?php echo $competition->getPrize(); ?></h3>
				<?php 
					if($competition->getUrl_prize()!==NULL)
						echo "<img class='img-responsive' src='".$competition->getUrl_prize()."' alt='photo du prix'>";
				?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4 col-md-offset-4">
				<div class="col-md-6">
					<?php 
					if(isset($_SESSION['ACCESS_TOKEN'])) :?>
						<button>Bienvenue <?php echo $user->getFirstName(); ?></button>
						<a href="<?php echo WEBPATH; ?>/logout">Se déconnecter</a>
					<?php else :?>
						<a href="<?php echo $urlLoginLogout; ?>"><button>Participer</button></a>
					<?php endif; ?>
				</div>
				<div class="col-md-6">
					<button><a href="<?php echo WEBPATH; ?>/gallery">Accèder aux photos des participants</a></button>
				</div>
				<?php 
				if(isset($_SESSION['ACCESS_TOKEN'])) :?>
					<div class="col-md-6 col-md-offset-3">
						<form>
							<input type="" name="">
							<textarea></textarea>
							<input type="submit" value="Valider la participation">
						</form>
					</div>
				<?php endif; ?>
			</div>
		</div>
	<?php
	endif;
	?>


<?php echo (isset($_SESSION['ACCESS_TOKEN'])) ? "Vous avez une session ACCESS_TOKEN" : "Vous n'avez pas de session ACCESS_TOKEN"; ?>


<?php 
//echo (isset($_SESSION['ACCESS_TOKEN'])) ? "Vous êtes ".$user->getNom() : "Vous n'avez pas de nom."; 
?>

<footer>
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <ul class="nav navbar-nav">
	      <li class="active"><a href="<?php echo WEBPATH;?>/">Règlement du concours</a></li>
			<li><a href="<?php echo WEBPATH;?>/">CGU</a></li>
			<?php 
			if(isset($_SESSION['ACCESS_TOKEN']) && in_array($user->getId(),$listAdmins)) :?>
				<li><a href="<?php echo WEBPATH;?>/admin">Administration</a></li>
			<?php endif; ?>
	    </ul>
	    <div class="nav navbar-nav navbar-right fb-share-button" 
	    	data-href="http://egl.fbdev.fr/EGL/" data-layout="button" data-size="large" data-mobile-iframe="true">
			<a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fegl.fbdev.fr%2FEGL%2F&amp;src=sdkpreparse">Partager</a>
		</div>
	  </div>
	</nav>
</footer>