<?php  
	if(isset($admins)){
		foreach ($admins['data'] as $key => $admin) {
			if($admin['role']=="administrators")
				$listAdmins[] = $admin['user'];
		}
	}
	if(isset($competition)) :?>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 text-center">
				<img class="img-thumbnail" style="width: 10%;" src="https://scontent-fra3-1.xx.fbcdn.net/v/t1.0-9/552345_420640654657180_1666928990_n.jpg?oh=7e0262fb4fa4671e45c13bfefcbfc4ef&oe=58C27523" alt="logo">
				<h1>CONCOURS <?php echo $competition->getName(); ?></h1>
				<p>Organisé
					du <?php echo date('d/m/Y', strtotime($competition->getStart_date())); ?>
					au <?php echo date('d/m/Y', strtotime($competition->getEnd_date())); ?>.
				</p>
	 			<hr>
	 			<hr>
	 			<h3><?php echo $competition->getDescription(); ?></h3>
				<hr>
				<hr>
				<h2>Tente de gagner <?php echo $competition->getPrize(); ?></h2>
				<?php 
					if($competition->getUrl_prize()!==NULL)
						echo "<div class='col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3'><img class='img-responsive' src='".$competition->getUrl_prize()."' alt='photo du prix'></div>";
				?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="col-xs-6 col-sm-6 col-md-6">
					<?php 
					if(isset($user)) :?>
						<a href="<?php echo WEBPATH; ?>/logout">
							<button class="btn">
							Bienvenue <?php echo $user->getFirstName(); ?><br>
							Se déconnecter
							</button>
						</a>
					<?php else :?>
						<a href="<?php echo $urlLoginLogout; ?>"><button class="btn">Participer</button></a>
					<?php endif; ?>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6">
					<button class="btn">
						<a href="<?php echo WEBPATH; ?>/gallery">
						Accèder aux photos des participants</a>
					</button>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 text-center">
				<?php 
				if(isset($images)) :?>
					<h2>Participez à notre concours,</h2>
					<h3>en sélectionnant une photo d'un de vos albums Facebook....</h3>
					<div id='listPictures' class='col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2'>
						<h3 id='alone' class='cursor-pointer'>Photos individuelles</h3>
						<div class="row" id="album-alone">
						<?php
						//Photos individuelles
						if(isset($images["photos"])){
							foreach ($images["photos"]["data"] as $key => $photo) :?>
								<img class="col-md-6" 
										src='<?php echo $photo['source']; ?>' 
										data-toggle='modal' 
										data-target='<?php echo "#".$photo['id']; ?>'>

								<!--Modal-->
								<div class="modal fade" id='<?php echo $photo['id']; ?>' tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								  <div class="modal-dialog" role="document">
								    <form action="<?php echo WEBPATH.'/index/submit'; ?>" method="post">
								    <div class="modal-content">
								      <div class="modal-header">
								      	<p>Assurez-vous d'être le propriétaire du contenu que vous envoyez.</p> 
										<p>En participant au concours, vous acceptez les <a href="<?php echo WEBPATH.'/CGU'; ?>">conditions d'utilisations</a>.</p>
								      </div>
								      <div class="modal-body">
								      	<img src='<?php echo $photo['source']; ?>' alt="photo de l'utilisateur">
								      	<input type="hidden" name="idPhoto" value="<?php echo $photo['id']; ?>">
									    <input type="hidden" name="fromFB">
								      </div>
								      <div class="col-md-6">
							        	<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
							          </div>
							          <div class="col-md-6">
								        <button type="submit" class="btn btn-default">Envoyer cette photo</button>
									  </div>
								    </div>
								    </form>
								  </div>
								</div>
							<?php 
							endforeach;
						}
						echo "</div>";

						//Albums
						foreach ($images["albums"]["data"] as $key => $album) {
							echo "<h3 id='".$album['id']."' class='cursor-pointer'>".$album['name']."</h3>";
							echo "<div class='row' id='album-".$album['id']."'>";
							if(isset($album['photos'])){
								foreach ($album['photos']["data"] as $key => $photo) :?>
									<div class="col-md-6">
										<img src='<?php echo $photo['source']; ?>' 
												data-toggle='modal' 
												data-target='<?php echo "#".$photo['id']; ?>'>
									</div>
									<!-- Modal -->
									<div class="modal fade" id='<?php echo $photo['id']; ?>' tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
									  <div class="modal-dialog" role="document">
									    <form action="<?php echo WEBPATH.'/index/submit'; ?>" method="post">
									    <div class="modal-content">
									      <div class="modal-header">
									        <p>Assurez-vous d'être le propriétaire du contenu que vous envoyez.</p> 
											<p>En participant au concours, vous acceptez les <a href="<?php echo WEBPATH.'/CGU'; ?>">conditions d'utilisations</a>.</p>
									      </div>
									      <div class="modal-body">
									      	<img src='<?php echo $photo['source']; ?>' alt="photo d'un album">
									      	<input type="hidden" name="idPhoto" value="<?php echo $photo['id']; ?>">
									      	<input type="hidden" name="fromFB">
									      </div>
									      <div class="modal-footer">
									      	<div class="col-md-6">
									        	<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
									        </div>
									        <div class="col-md-6">
										        <button type="submit" class="btn btn-default">Envoyer cette photo</button>
											</div>
									      </div>
									    </div>
									    </form>
									  </div>
									</div>

								<?php
								endforeach;
							}
							echo "</div>";
						}
						?>
					</div>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3 text-center">
							<h3>....ou en important une photo depuis votre ordinateur.</h3>
							<form action="<?php echo WEBPATH.'/index/submit'; ?>" id="form" method="post" enctype="multipart/form-data" >
							    <input type="file" name="file">
							    <input type="hidden" name="uploadFile">
							    <input type="submit" class="btn" name="upload" value="Envoyer">
						    <form>
						</div>
					</div>
					<?php
				endif;
				?>
			</div>
		</div>
	<?php
	endif;
	?>

<footer class='text-center'>
	<nav class="navbar navbar-default">
	  <div class="container-fluid">
	    <ul class="nav navbar-nav">
	      <li class="active"><a href="<?php echo WEBPATH;?>/">Règlement du concours</a></li>
			<li><a href="<?php echo WEBPATH;?>/">CGU</a></li>
			<?php 
			if(isset($user) && in_array($user->getId(),$listAdmins)) :?>
				<li><a href="<?php echo WEBPATH;?>/admin">Administration</a></li>
			<?php endif; ?>
	    </ul>
	  </div>
	</nav>
</footer>