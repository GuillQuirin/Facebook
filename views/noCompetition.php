
<div class="text-right">
	<h2 class="text-uppercase">Pas de concours actuellement !</h2>
	<h2>Revenez plus tard ...</h2>
</div>
<div class="footer">
	<div class="col-xs-6">
		<img src="https://scontent-fra3-1.xx.fbcdn.net/v/t1.0-9/552345_420640654657180_1666928990_n.jpg?oh=7e0262fb4fa4671e45c13bfefcbfc4ef&oe=58C27523">
		<label>Pardon Maman Tatoo <br> & Piercing <?php echo $setting->getAdress(); ?></label>
	</div>

	<div class="hidden-sm col-sx-offset-4">
		<?php 
		if(isset($user)){ //Utilisateur connecté
			if(in_array($user->getId(),$listAdmins))//Administrateur
				echo '<a href="'.WEBPATH.'/admin">Administration</a>';

			echo '<a href="'.WEBPATH.'/logout">Se déconnecter</a>';
		}
		else
			echo '<a href="'.$urlLoginLogout.'">Se connecter</a>';
		?>
	</div>
</div>