<?php  
	if(isset($competition)) :?>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 text-center">
				<img class="img-thumbnail" style="width: 10%;" src="https://scontent-fra3-1.xx.fbcdn.net/v/t1.0-9/552345_420640654657180_1666928990_n.jpg?oh=7e0262fb4fa4671e45c13bfefcbfc4ef&oe=58C27523" alt="logo">
				<h1>CONCOURS <?php echo $competition->getName(); ?></h1>
				<p>Organisé
					du <?php echo $competition->getStart_date(); ?>
					au <?php echo $competition->getEnd_date(); ?>.
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
					<a href="<?php echo WEBPATH; ?>/gallery">
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
				if(isset($images)) :?>
					<h2>Participez à notre concours,</h2>
					<h3>en sélectionnant une photo d'un de vos albums Facebook....</h3>
					<div class="panel-group listPictures"" id="accordion" role="tablist" aria-multiselectable="true">
					  <div class="panel panel-default">
					    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
						    <div class="panel-heading" role="tab" id="headingOne">
						      <h4 class="panel-title">			        
					          Photos individuelles
						      </h4>
						    </div>
						</a>
					    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
					      <div class="panel-body">
					        <?php
								//Photos individuelles
								if(isset($images["photos"])){
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
							?>
							<div class="col-md-12">
								<a class="backTop" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
									<span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>
								</a>
							</div>
					      </div>
					    </div>
					  </div>

					  <?php 
						//Albums
						foreach ($images["albums"]["data"] as $key => $album) :?>
						  <div class="panel panel-default">
						  	<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $album['id']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $album['id']; ?>">
							    <div class="panel-heading" role="tab" id="heading<?php echo $album['id']; ?>">
							      <h4 class="panel-title">
							          <?php echo $album['name']; ?>
							      </h4>
							    </div>
							</a>
						    <div id="collapse<?php echo $album['id']; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $album['id']; ?>">
						      <div class="panel-body">
						       <?php
									if(isset($album['photos'])) :
										foreach ($album['photos']["data"] as $key => $photo) :?>
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
									endif;
								?>
								<div class="col-md-12">
									<a class="backTop" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $album['id']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $album['id']; ?>">
										<span class="glyphicon glyphicon-arrow-up" aria-hidden="true"></span>
									</a>
								</div>
						      </div>
						    </div>
						  </div>
					  	<?php 
					  	endforeach;
					  ?>
					</div>

					<div class="row">
						<div class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3 text-center">
							<h3>....ou en important une photo depuis votre ordinateur.</h3>
							<form action="<?php echo WEBPATH.'/index/submit'; ?>" id="localForm" method="post" enctype="multipart/form-data" >
							    <input type="file" name="file" id="i_file">
							    <input type="hidden" name="uploadFile">
							    <input type="submit" class="btn" name="upload" value="Envoyer">
						    <form>
						    <p class="pbFileSize">Le fichier est trop gros pour l'application, il ne doit pas excèder 10 Mo</p>
						</div>
					</div>
					<?php
				endif;
				?>
			</div>
		</div>
	<?php
	endif;
	//Liste d'amis
	//Email
	//Publication
	?>

<!-- Footer des pages -->
<footer class="footer col-md-12">
	<a href="<?php echo WEBPATH; ?>/reglement">Règlement du concours</a> | 
	<a href="<?php echo WEBPATH; ?>/CGU">Conditions d'utilisations</a> | 
	<?php 
	if(isset($user) && isset($listAdmins) && in_array($user->getId(),$listAdmins)) :?>
		<a href="<?php echo WEBPATH;?>/admin">Administration</a>
	<?php endif; ?>
</footer>