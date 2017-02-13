
<div>
	<h2 class="text-uppercase">Pas de concours <br>actuellement !</h2>
	<h2>Revenez plus tard ...</h2>
</div>
<div class="footer">
	<div class="col-xs-6 text-left admin-connexion">
		<img src="https://scontent-fra3-1.xx.fbcdn.net/v/t1.0-9/552345_420640654657180_1666928990_n.jpg?oh=7e0262fb4fa4671e45c13bfefcbfc4ef&oe=58C27523">
		<p>Pardon Maman <br> Tatoo & Piercing</p>

		<?php if(isset($user)) : ?>

			<?php if(isset($isAdmin) && $isAdmin==1) : //Administrateur connecté  ?>
				<a href="<?php echo WEBPATH; ?>/index">
					<button style="font-weight:bold;color:red;">Accueil</button>
				</a>
			<?php endif; ?>
			
			<button id="logout" style="font-weight:bold;color:red;">Déconnexion</button>
		
		<?php else : ?>
			<button id="login" style="font-weight:bold;color:red;">Connexion administrateur</button>
		
		<?php endif; ?>
	</div>
</div>