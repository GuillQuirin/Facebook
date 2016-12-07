<?php  
	/* --ENVOI DE DONNEES PAR L'UTILISATEUR-- */
	if(isset($_POST)){
		//Envoi d'une image vers la page de l'administrateur depuis l'ordi
		if(isset($_FILES['file']) && $is_admin){
			$target = 'uploads/' . basename( $_FILES['file']['name']) ; 
	        move_uploaded_file($_FILES['file']['tmp_name'], $target); 
	        $image['image'] = "uploads/".$_FILES['file']['name'];

			$data = [
			  'message' => 'My awesome photo upload example.',
			  'source' => $fb->fileToUpload($image['image']),
			];

			try { //Envoi 
			  $response = $fb->post('/me/photos', $data, $token_page);
			}
			catch(Facebook\Exceptions\FacebookResponseException $e) {
			  echo 'Graph returned an error: ' . $e->getMessage();
			  exit;
			}
			catch(Facebook\Exceptions\FacebookSDKException $e) {
			  echo 'Facebook SDK returned an error: ' . $e->getMessage();
			  exit;
			}
			$graphNode = $response->getGraphNode();
		}
	}
	if(isset($_SESSION['ACCESS_TOKEN'])){
		$response = $fb->get('app/roles',"1804945786451180|yqj6xWNaG2lUvVv3sfwwRbU5Sjk");
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
			<div class="col-xs-10 col-xs-offset-1 col-sm-10 col-sm-offset-1 col-md-10 col-md-offset-1 text-center">
				<img class="img-thumbnail" src="https://scontent-fra3-1.xx.fbcdn.net/v/t1.0-9/552345_420640654657180_1666928990_n.jpg?oh=7e0262fb4fa4671e45c13bfefcbfc4ef&oe=58C27523" alt="logo">
				<h1>CONCOURS <?php echo $competition->getName(); ?></h1>
				<p>
					du <?php echo date('d/m/Y', strtotime($competition->getStart_date())); ?>
					au <?php echo date('d/m/Y', strtotime($competition->getEnd_date())); ?>
				</p>
	 			<hr>
	 			<hr>
	 			<h2><?php echo $competition->getDescription(); ?></h3>
				<hr>
				<hr>
				<h2>TENTE DE GAGNER :</h2>
				<h3><?php echo $competition->getPrize(); ?></h3>
				<?php 
					if($competition->getUrl_prize()!==NULL)
						echo "<div class='col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3'><img class='img-responsive' src='".$competition->getUrl_prize()."' alt='photo du prix'>";
				?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<div class="col-xs-6 col-sm-6 col-md-6">
					<?php 
					if(isset($_SESSION['ACCESS_TOKEN'])) :?>
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
					<button class="btn"><a href="<?php echo WEBPATH; ?>/gallery">Accèder aux photos des participants</a></button>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1  text-center">
				<?php 
				if(isset($_SESSION['ACCESS_TOKEN'])) :?>
						<h3>Selectionner une photo de mes albums Facebook....</h3>
						<?php
						//Récupération des différentes photos de l'utilisateur
						$response = $fb->get('/me?fields=photos{id,name,source},albums{name,photos{id,name,source}}');
						$images = $response->getDecodedBody();
						if($images){
							echo "<div id='listPictures' class='col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-8 col-md-offset-2'>";
							//Photos individuelles
							if(isset($images["photos"])){
								foreach ($images["photos"]["data"] as $key => $photo) :?>
									<img style='width:45%;' src='<?php echo $photo['source']; ?>' data-toggle='modal' data-target='<?php echo "#".$photo['id']; ?>'>
									<!--Modal-->
									<div class="modal fade" id='<?php echo $photo['id']; ?>' tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
									  <div class="modal-dialog" role="document">
									    <div class="modal-content">
									      <div class="modal-header">
									        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
									      </div>
									      <div class="modal-body">
									      	<img src='<?php echo $photo['source']; ?>'>
									      </div>
									      <div class="modal-footer">
									      <div class="fb-like" 
											   		data-href="<?php echo $photo['source']; ?>" 
											   		data-layout="button_count" 
											   		data-action="like" 
											   		data-size="small" 
											   		data-show-faces="false" 
											   		data-share="true"></div>
									        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									      </div>
									    </div>
									  </div>
									</div>
								<?php 
								endforeach;
							}
							
							//Albums
							foreach ($images["albums"]["data"] as $key => $album) {
								echo "<h3>".$album['name']."</h3>";
								if(isset($album['photos'])){
									foreach ($album['photos']["data"] as $key => $photo) :?>
										<img style='width:45%;' src='<?php echo $photo['source']; ?>' data-toggle='modal' data-target='<?php echo "#".$photo['id']; ?>'>
										<!-- Modal -->
										<div class="modal fade" id='<?php echo $photo['id']; ?>' tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
										  <div class="modal-dialog" role="document">
										    <div class="modal-content">
										      <div class="modal-header">
										        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
										      </div>
										      <div class="modal-body">
										      	<img src='<?php echo $photo['source']; ?>'>
										      </div>
										      <div class="modal-footer">
										      	<div class="fb-like" 
												   		data-href="<?php echo $photo['source']; ?>" 
												   		data-layout="button_count" 
												   		data-action="like" 
												   		data-size="small" 
												   		data-show-faces="false" 
												   		data-share="true"></div>
										        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										      </div>
										    </div>
										  </div>
										</div>
									<?php
									endforeach;
								}
							}
							echo "</div>";
						}
				endif;
				?>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-3 text-center">
				<h3>....ou importez une photo depuis mon ordinateur</h3>
				<form action="" id="form" method="post" enctype="multipart/form-data" >
				    <input type="file" name="file">
				    <input type="submit" class="btn" name="upload" value="Envoyer">
			    <form>
			</div>
		</div>
	<?php
	endif;
	?>

<p>
<?php echo (isset($_SESSION['ACCESS_TOKEN'])) ? "Vous avez une session ACCESS_TOKEN" : "Vous n'avez pas de session ACCESS_TOKEN"; ?>
</p>

<footer class='text-center'>
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
	  </div>
	</nav>
</footer>