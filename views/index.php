<div class="row">
	<div>
		<img class="img-thumbnail img-logo" style="width: 10%;" src="https://scontent-fra3-1.xx.fbcdn.net/v/	t1.0-9/552345_420640654657180_1666928990_n.jpg?oh=7e0262fb4fa4671e45c13bfefcbfc4ef&oe=58C27523" alt="logo">
	</div>		
	<div class="col-xs-10 col-xs-offset-1 text-center">
		<?php if(isset($competition)) :?>
			<h1>CONCOURS <br> <?php echo $competition->getName(); ?></h1>
			<p>Organisé
				du <?php echo $competition->getStart_date(); ?>
				au <?php echo $competition->getEnd_date(); ?>.
			</p>
		<?php else : ?>
			<h1>Pas de concours ouvert actuellement</h1>
		<?php endif; ?>
	</div>
</div>	

<div class="row">
	<div class="col-xs-10 col-xs-offset-1 text-center">
		<?php if(isset($competition)) :?>
		<hr>
		<hr>
		<p><?php echo $competition->getDescription(); ?></p>
		<hr>
		<hr>
		<h2>TENTE DE GAGNER <br> <?php echo $competition->getPrize(); ?></h2>
		<?php 
			if($competition->getUrl_prize()!==NULL)
				echo "<div class='col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3'><img class='img-responsive' src='".$competition->getUrl_prize()."' alt='photo du prix'></div>";
		?>
		<?php endif; ?>
	</div>
</div>
<?php if(isset($competition)) : ?>
	<?php if(!isset($_SESSION['idFB'])) : ?>
		<div class="row">
			<p class="col-md-8 col-md-offset-2 text-center">Connectez-vous à l'application et admirez les chefs d'oeuvres que portent les autres participants</p>
		</div>
	<?php endif; ?>
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1">
			<div class="col-xs-6 col-sm-6 col-md-6">
				<?php 
				if(isset($user)) :?>
					<a href="<?php echo WEBPATH; ?>/logout" target="_top">
						<button class="btn">
						Bienvenue <?php echo $user->getFirst_name(); ?><br>
						Se déconnecter
						</button>
					</a>
				<?php else :?>
					<a href="<?php echo $urlLoginLogout; ?>" target="_top"><button class="btn">Participer</button></a>
				<?php endif; ?>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6">
				<?php if(isset($_SESSION['idFB'])) : ?>
					<a href="<?php echo WEBPATH; ?>/gallery">
				<?php else : ?>
					<a href="<?php echo $urlLoginLogout; ?>">
				<?php endif; ?>
					<button class="btn">					
						Accèder aux photos des participants
					</button>
				</a>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 text-center">
			<?php 
			$listAlonePic = [];
			if(isset($images)) :?>
				<h2>Participez à notre concours</h2>
				<h3>en sélectionnant une photo d'un de vos albums Facebook....</h3>
				<div class="panel-group listPictures"" id="accordion" role="tablist" aria-multiselectable="true">
				  <?php 
					//Photos individuelles
					if(isset($images["photos"])) :
					?>
					  <div class="panel panel-default col-md-6 col-md-offset-3">
					    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
						    <div class="panel-heading" role="tab" id="headingOne">
						      <h4 class="panel-title">			        
					          Photos individuelles
						      </h4>
						    </div>
						</a>
					    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					      <div class="panel-body">
					        <div class="row">
					        <?php
								foreach ($images["photos"]["data"] as $key => $photo) :?>
									<div class="col-xs-6 col-md-4">
									    <a class="thumbnail cursor-pointer">
									      <img src='<?php echo $photo['source']; ?>' 
												data-toggle='modal' 
												data-target='<?php echo "#".$photo['id']; ?>'
												alt="Photo individuelle">
									    </a>
									</div>
									
									<!--Modal-->
									<?php 
										//Empêche d'avoir la meme image en individuel + album : bug de modal
										$listAlonePic[] = $photo['id']; 
									?>
									<div class="modal fade" id='<?php echo $photo['id']; ?>' tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
									  <div class="modal-dialog" role="document">
									    <form action="<?php echo WEBPATH.'/index/submit'; ?>" class="onlineForm" method="post">
									    <div class="modal-content">
									      <div class="modal-header">
									      	<p>Assurez-vous d'être le propriétaire du contenu que vous envoyez.</p> 
											<p>En participant au concours, vous acceptez les <a href="<?php echo WEBPATH.'/CGU'; ?>" class="cgu-link">conditions d'utilisations</a>.</p>
									      </div>
									      <div class="modal-body">
									      	<img src='<?php echo $photo['source']; ?>' alt="photo de l'utilisateur">
									      	<input type="hidden" name="idPhoto" value="<?php echo $photo['id']; ?>">
										    <input type="hidden" name="fromFB">
									      </div>
									      <div class="modal-footer">
										      <div class="col-md-6">
									        	<button type="button" class="btn" data-dismiss="modal">Annuler</button>
									          </div>
									          <div class="col-md-6">
										        <button type="submit" class="btn sendPicture">Envoyer cette photo</button>
											  </div>
											  <div class="errorSend text-left">
											  	<p>Attention, certaines informations sont nécessaires pour finaliser votre participation:</p>
											  	<ul class="listError">
											  	</ul>
											  	<p>Vous pouvez modifier vos autorisations à Facebook en cliquant <a href=""><button>ici</button></a></p>
											  </div>
										  </div>
									    </div>
									    </form>
									  </div>
									</div>
								<?php 
								endforeach;
							?>
							</div>
							<div class="row">
								<div class="col-md-12">
									<a class="backTop" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
										<span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>
									</a>
								</div>
							</div>
					      </div>
					    </div>
					  </div>
				  <?php else: ?>
				  		<p>Vous devez autoriser Facebook à récupérer les photos de vos albums</p>
						<button class="getPhotos">Ici</button>
				  <?php
				  	endif;

					//Albums
				  	if(isset($images['albums'])) :
						foreach ($images["albums"]["data"] as $key => $album) :?>
						  <div class="panel panel-default col-md-6 col-md-offset-3">
						  	<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $album['id']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $album['id']; ?>">
							    <div class="panel-heading" role="tab" id="heading<?php echo $album['id']; ?>">
							      <h4 class="panel-title">
							          <?php echo $album['name']; ?>
							      </h4>
							    </div>
							</a>
						    <div id="collapse<?php echo $album['id']; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $album['id']; ?>">
						      <div class="panel-body">
						       	<div class="row">
						       	<?php
									if(isset($album['photos'])) :
										foreach ($album['photos']["data"] as $key => $photo): 
											if(!in_array($photo['id'],$listAlonePic)): 
											?>
											<div class="col-xs-6 col-md-4">
												<a class="thumbnail cursor-pointer">
													<img src='<?php echo $photo['source']; ?>' 
														data-toggle='modal' 
														data-target='<?php echo "#".$photo['id']; ?>'
														alt="Photo d'album">
												</a>
											</div>

											<!-- Modal -->
												<div class="modal fade" id='<?php echo $photo['id']; ?>' tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
												  <div class="modal-dialog" role="document">
												    <form action="<?php echo WEBPATH.'/index/submit'; ?>" class="onlineForm" method="post">
												    <div class="modal-content">
												      <div class="modal-header">
												        <p>Assurez-vous d'être le propriétaire du contenu que vous envoyez.</p> 
														<p>En participant au concours, vous acceptez les <a href="<?php echo WEBPATH.'/CGU'; ?>">conditions d'utilisations</a>.</p>
														<p>Un album "Pardon-Maman" sera créé dans la section Photo de votre compte Facebook, celui-ci aura la même visibilité que vous avez indiqué en vous connectant.</p>
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
													        <button type="submit" class="btn btn-default sendPicture">Envoyer cette photo</button>
														</div>
														<div class="errorSend text-left">
												  			<p>Attention, certaines informations sont nécessaires pour finaliser votre participation:</p>
														  	<ul class="listError">
														  	</ul>
												  			<p>Vous pouvez modifier vos autorisations à Facebook en cliquant <a href="#"><button>ici</button></a></p>
												  		</div>
												      </div>
												    </div>
												    </form>
												  </div>
												</div>
										<?php
											endif;
										endforeach;
									endif;
								?>
								</div>
								<div class="row">
									<div class="col-md-12">
										<a class="backTop" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $album['id']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $album['id']; ?>">
											<span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>
										</a>
									</div>
								</div>
						      </div>
						    </div>
						  </div>
					  	<?php 
					  	endforeach;
				  	endif;
				  ?>
				</div>

				<div class="row">
					<div class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3 text-center">
						<h3>....ou en important une photo depuis votre ordinateur.</h3>
						<?php if(isset($upload)) : ?>
							<form action="<?php echo WEBPATH.'/index/submit'; ?>" id="localForm" method="post" enctype="multipart/form-data" >
							    <input type="file" name="file" id="i_file" required>
							    <input type="hidden" name="uploadFile">
							    <input type="submit" class="btn" name="upload" value="Envoyer">
						    </form>
						    <p class="pbFileSize">Le fichier est trop gros pour l'application, il ne doit pas excèder 10 Mo</p>
						    <div class="errorUpload text-left">
							  	<p>Attention, certaines informations sont nécessaires pour finaliser votre participation:</p>
							  	<ul class="listError">
							 	</ul>
								<p>Vous pouvez modifier vos autorisations à Facebook en cliquant <a href=""><button>ici</button></a></p>
							</div>
						<?php else: ?>
							<p>Vous devez autoriser Facebook à enregistrer vos photos dans un album que vous pourrez administrer</p>
							<button class="postPhotos">Ici</button>
						<?php endif; ?>
					</div>
				</div>
				<?php
			endif;
			?>
		</div>
	</div>
<?php endif; ?>

<!-- Footer des pages -->
<footer class="footer col-md-12">
	<a href="<?php echo WEBPATH; ?>/reglement" class="footer-link">Règlement du concours</a> | 
	<a href="<?php echo WEBPATH; ?>/CGU" class="footer-link">Conditions d'utilisations</a> 
	<?php if(isset($isAdmin) && $isAdmin==1) :?>
		| <a href="<?php echo WEBPATH;?>/admin" class="footer-link">Administration</a>
	<?php endif; ?>
</footer>