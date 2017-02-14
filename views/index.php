<div class="col-sm-12 padding-top-20">	
<div class="row">
	<div>
		<img class="img-logo" style="width: 10%;" src="https://scontent-fra3-1.xx.fbcdn.net/v/	t1.0-9/552345_420640654657180_1666928990_n.jpg?oh=7e0262fb4fa4671e45c13bfefcbfc4ef&oe=58C27523" alt="logo">
	</div>
		<div class="col-xs-10 col-xs-offset-1 text-center">
			<?php if(isset($competition)) :?>
				<h1>CONCOURS <br> <?php echo $competition->getName(); ?></h1>
				<p>Organisé
					du <?php echo date('d/m/Y', strtotime($competition->getStart_date())); ?>
					au <?php echo date('d/m/Y', strtotime($competition->getEnd_date())); ?>.
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
				<p><h3><?php echo $competition->getDescription(); ?></h3></p>
				<hr>
				<h2>TENTEZ DE GAGNER <br> <?php echo $competition->getPrize(); ?></h2>
				<?php 
				if($competition->getUrl_prize()!==NULL)
					echo "<div class='col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3'><img class='img-responsive' src='".$competition->getUrl_prize()."' alt='photo du prix'></div>";
				?>
			<?php endif; ?>
		</div>
	</div>
	<input type="hidden" id="isConnected" value="<?php echo (isset($_SESSION['ACCESS_TOKEN'])) ? 1 : 0; ?>">
	<?php if(!isset($_SESSION['idFB'])) : ?>
		<div class="row">
			<p class="col-md-8 col-md-offset-2 text-center">Connectez-vous à l'application et admirez les chefs d'oeuvres que vous réservent les autres participants</p>
		</div>
	<?php endif; ?>
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1">
			<?php if(isset($user)) :  //Utilisateur connecté ?>
				<div class="col-xs-6 col-sm-6 col-md-6">
					<button class="btn" id="logout">
						Bienvenue <?php echo $user->getFirst_name(); ?><br>
						Se déconnecter
					</button>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6">
					<a href="<?php echo WEBPATH.'/gallery'; ?>">
						<button class="btn">					
							Accèder aux photos des participants
						</button>
					</a>
				</div>
			<?php else : //Visiteur non connecté ?>
				<div class="col-xs-12 col-sm-12 col-md-6 col-md-offset-3">
					<button class="btn" id="login">Connectez-vous</button>
				</div>
			<?php endif; ?>		
		</div>
	</div>
	<?php if(isset($competition)) : ?>

		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 text-center">

				<?php 
				$listAlonePic = [];
				if(isset($images)) :?>
				
				
				<?php if(isset($canParticipate) && $canParticipate): ?>
					
					<p><h3>Nous vous remercions d'avoir participé au concours, le gagnant sera désigné à la fin de celui-ci.</h3></p>
					
					<?php if(isset($cantPublish) && $cantPublish): ?>
						
						<p>Nous pouvons directement vous informer du gagnant du concours en publiant sur votre mur la photo retenue par le jury si vous le souhaitez.
							<button class="btn publish_autorization">Autoriser à publier sur mon mur</button>
						</p>

					<?php endif; ?>
				<?php else: ?>
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
															<p>En participant au concours, vous acceptez les <a href="<?php echo WEBPATH.'/cgu'; ?>" class="cgu-link">conditions d'utilisations</a>.</p>
														</div>
														<div class="modal-body">
															<img src='<?php echo $photo['source']; ?>' alt="photo de l'utilisateur">
															<input type="hidden" name="idPhoto" value="<?php echo $photo['id']; ?>">
															<input type="hidden" name="fromFB">
														</div>
														<div class="modal-footer">
															<div class="col-md-12">
																<?php if(isset($cantPublish) && $cantPublish): ?>
																	<p>Vous pouvez autoriser Facebook à enregistrer vos photos dans un album administrable afin de pouvoir y intégrer un message.</p>
																	<button class="postPhotos">Autoriser</button>
																<?php else: ?>
																	<p>Rédigez un message personnalisé pour vos amis qui consulteraient votre photo</p>
																	<textarea class="col-xs-12 col-md-12" name="message"></textarea>
																<?php endif; ?>
															</div>
															<div class="col-sm-6 col-md-6">
																<button type="button" class="btn" data-dismiss="modal">Annuler</button>
															</div>
															<div class="col-sm-6 col-md-6">
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
						<button class="getPhotos">Autoriser</button>
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
																	<p>En participant au concours, vous acceptez les <a href="<?php echo WEBPATH.'/cgu'; ?>">conditions d'utilisations</a>.</p>
																	<p>Un album "Pardon-Maman" sera créé dans la section Photo de votre compte Facebook, celui-ci aura la même visibilité que vous avez indiqué en vous connectant.</p>
																</div>
																<div class="modal-body">
																	<img src='<?php echo $photo['source']; ?>' alt="photo d'un album">
																	<input type="hidden" name="idPhoto" value="<?php echo $photo['id']; ?>">
																	<input type="hidden" name="fromFB">
																</div>
																<div class="modal-footer">
																	<div class="col-md-12">
																		<?php if(isset($cantPublish) && $cantPublish): ?>
																			<p>Vous pouvez autoriser Facebook à enregistrer vos photos dans un album administrable afin de pouvoir y intégrer un message.</p>
																			<button class="postPhotos">Autoriser</button>
																		<?php else: ?>
																			<p>Rédigez un message personnalisé pour vos amis qui consulteraient votre photo</p>
																			<textarea class="col-xs-12 col-md-12" name="message"></textarea>
																		<?php endif; ?>
																	</div>
																	<div class="col-sm-6 col-md-6">
																		<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
																	</div>
																	<div class="col-sm-6 col-md-6">
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

									<?php if(isset($upload)): ?>

										<form action="<?php echo WEBPATH.'/index/submit'; ?>" id="localForm" method="post" enctype="multipart/form-data" >
											<p><input type="file" name="file" id="i_file" required></p>
											<input type="hidden" name="uploadFile">
											<p>Rédiger un message personnalisé et votre participation sera publiée sur votre mur !</p>
											<textarea name="message"></textarea>
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

										<p>Vous devez autoriser Facebook à enregistrer vos photos dans un album que vous pourrez ensuite administrer</p>
										<button class="postPhotos">Autoriser</button>

									<?php endif; ?>
								</div>
							</div>
							<?php
							endif;
							endif;
							?>
						</div>
					</div>
				<?php endif; ?>
				</div>
			<!-- Footer des pages -->
			<footer class="footer col-sm-12">
				<a href="<?php echo WEBPATH; ?>/rules" class="footer-link">Règlement du concours</a> | 
				<a href="<?php echo WEBPATH; ?>/cgu" class="footer-link">Conditions d'utilisations</a> 
				<?php if(isset($isAdmin) && $isAdmin==1) :?>
					<p>
						<a href="<?php echo WEBPATH;?>/admin" class="footer-link">Administration</a>
						| <a href="<?php echo WEBPATH;?>/noCompetition" class="footer-link">Aperçu sans concours</a>
					</p>
				<?php endif; ?>
				<p>
					<div class="fb-share-button" data-href="https://egl.fbdev.fr/Facebook/" data-layout="button" data-size="large" data-mobile-iframe="false"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fegl.fbdev.fr%2FFacebook%2F&amp;src=sdkpreparse">Partager</a></div>
				</p>
			</footer>