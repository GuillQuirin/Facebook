
<div>
	<h2 class="text-uppercase">Pas de concours <br>actuellement !</h2>
	<h2>Revenez plus tard ...</h2>
</div>
<div class="footer">
	<div class="col-xs-6">
		<img src="https://scontent-fra3-1.xx.fbcdn.net/v/t1.0-9/552345_420640654657180_1666928990_n.jpg?oh=7e0262fb4fa4671e45c13bfefcbfc4ef&oe=58C27523">
		<p>Pardon Maman <br> Tatoo & Piercing <?php //echo $setting->getAdress(); ?></p>
	</div>
	<div class="col-xs-12 text-right admin-connexion">
		<?php if(isset($user)) : ?>

			<?php if(isset($isAdmin) && $isAdmin==1) : //Administrateur connecté  ?>
				<p><a href="<?php echo WEBPATH; ?>/index">Accueil</a></p>
			<?php endif; ?>
			
			<p><button id="logout" style="color:red;">Se déconnecter</button></p>
		
		<?php else : ?>
			<p><button id="login" style="color:red;">Connexion administrateur</button></p>
		
		<?php endif; ?>
	</div>
</div>