<?php 
require_once __ROOT__ . WEBPATH."/web/vendor/autoload.php";
$fb = new Facebook\Facebook([
	'app_id' => '1804945786451180',
	'app_secret' => '0071a8a0031dae4539ae78f37d052dae',
	// ELISE
	// 'app_id' => '187377105043014',
	// 'app_secret' => 'f5012f947d16170a87ae80cd59decde2',
	// GUILLAUME
	//'app_id' => '1804945786451180',
	//'app_secret' => '0071a8a0031dae4539ae78f37d052dae',
	'default_graph_version' => 'v2.5',
	'fileUpload' => true
	]);
?>

	<h1>PROJET DEV FB</h1>

	<?php 
	if(isset($_SESSION['ACCESS_TOKEN'])) : ?>
		
		<a href="logout.php">Se déconnecter</a>
		
		<?php 	
		//$fb->setDefaultAccessToken($_SESSION["LONG_ACCESS_TOKEN"]);
		$fb->setDefaultAccessToken($_SESSION["ACCESS_TOKEN"]);
		try{
			$response = $fb->get('/me');
			$userNode = $response->getGraphUser();
		}
		catch(Facebook\Exceptions\FacebookResponseException $e) {
          // When Graph returns an error
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		}
		catch(Facebook\Exceptions\FacebookSDKException $e) {
          // When validation fails or other local issues
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}

		/*--RECUPERATION DES DONNEES--*/
		
		//Est-ce un admin de la page
		$response = $fb->get('/me/accounts?fields=name,access_token,business_id,perms');
		$pages = $response->getDecodedBody();
		$is_admin = false;
		foreach ($pages['data'] as $key => $page) {
			//Si administrateur de la page recherchée
			if(in_array("1224627974274442",$page) && in_array("ADMINISTER",$page['perms'])){
				$is_admin = true;
				$token_page = $page['access_token'];
				echo "<h2>Vous êtes administrateur</h2>";

				//Récupération des différentes photos de la page PUBLIEE
				try {
				  	$response = $fb->get('/'.$page['name'].'?fields=photos{id,name,source}');
					$images = $response->getDecodedBody();
				}
				catch(Facebook\Exceptions\FacebookResponseException $e) {
				  	//echo 'Graph returned an error: ' . $e->getMessage();
				  	//exit;
				}
				catch(Facebook\Exceptions\FacebookSDKException $e) {
				  	//echo 'Facebook SDK returned an error: ' . $e->getMessage();
				  	//exit;
				}
				if(isset($images)){
					foreach ($images["photos"]["data"] as $key => $photo){
						echo "<img style='width:10%;' src='".$photo['source']."'>";
						echo '<div class="fb-like" 
								   		data-href="'.$photo['source'].'" 
								   		data-layout="button_count" 
								   		data-action="like" 
								   		data-size="small" 
								   		data-show-faces="false" 
								   		data-share="true"></div>';
						echo "<br>";
					}
				}
				break;
			}
		}
		if(!$is_admin)
			echo "<h2>Vous n'êtes pas administrateur</h2>";


		//Récupération des différentes photos de l'utilisateur
		$response = $fb->get('/me?fields=photos.limit(5){id,name,source},albums.limit(2){name,photos.limit(5){id,name,source}}');
		$images = $response->getDecodedBody();
		if($images){
			//Photos individuelles
			if(isset($images["photos"])){
				foreach ($images["photos"]["data"] as $key => $photo) :?>
					<img style='width:10%;' src='<?php echo $photo['source']; ?>' data-toggle='modal' data-target='<?php echo "#".$photo['id']; ?>'>
					<div class="fb-like" 
						   		data-href="'.$photo['source'].'" 
						   		data-layout="button_count" 
						   		data-action="like" 
						   		data-size="small" 
						   		data-show-faces="false" 
						   		data-share="true"></div>
					<br>
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
			

			//Albums
			foreach ($images["albums"]["data"] as $key => $album) {
				echo "<h3>".$album['name']."</h3>";
				if(isset($album['photos'])){
					foreach ($album['photos']["data"] as $key => $photo) :?>
						<img style='width:10%;' src='<?php echo $photo['source']; ?>' data-toggle='modal' data-target='<?php echo "#".$photo['id']; ?>'>
						<div class="fb-like" 
							   		data-href="'.$photo['source'].'" 
							   		data-layout="button_count" 
							   		data-action="like" 
							   		data-size="small" 
							   		data-show-faces="false" 
							   		data-share="false"></div>
						<br>
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
		}


		/* --ENVOI DE DONNEES PAR L'UTILISATEUR-- */
		if(isset($_POST)){
			//Poster une image sur le mur de l'utilisateur
			if(isset($_POST['url']) && !empty($_POST['url'])){
				$image['url'] = $_POST['url'];
				$response = $fb->post('/me/photos',$image);
			}

			//Poster un message sur le mur de l'utilisateur
			if(isset($_POST['message']) && !empty($_POST['message'])){
				$message['message'] = $_POST['message'];
				$response = $fb->post('/me/feed',$message);
			}

			//Envoi d'une image vers la page de l'administrateur depuis l'ordi
			if(isset($_FILES['file']) && $is_admin){
				$target = 'uploads/' . basename( $_FILES['file']['name']) ; 
		        move_uploaded_file($_FILES['file']['tmp_name'], $target); 
		        $image['image'] = "uploads/".$_FILES['file']['name'];

				$data = [
				  'message' => 'My awesome photo upload example.',
				  'source' => $fb->fileToUpload($image['image']),
				];

				try {
				  $response = $fb->post('/1224627974274442/photos', $data, $token_page);
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
		?>

	    <form action="index.php" id="form" method="post" enctype="multipart/form-data" >
		    <input type="file" name="file">
		    <input type="text" name="url" placeholder="url de l'image">
		    <input type="text" name="message" placeholder="message sur le mur">
		    <input type="submit" name="upload" value="  U P L O A D  ">
	    <form>

	<?php else : ?>
		<a href="<?php echo WEBPATH.'/login'; ?>">Se connecter à un compte Facebook</a>
	<?php endif?>

