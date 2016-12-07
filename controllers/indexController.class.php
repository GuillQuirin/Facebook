<?php
class indexController extends template{
	public function indexAction(){
		$v = new view();
		$this->assignConnectedProperties($v);
		$v->assign("css", "index");
		$v->assign("js", "index");				
		
		//Ajout d'un lien "connexion à Facebook" sur cette page
		$this->login($v);

		/*Etablir une fonction (dans la classe mère ou fille)
		pour gérer à chaque load d'une page la validité de la session utilisateur
		(s'il n'a pas supprimé des permission entre-temps)*/

		$v->setView("index","templateempty");
	}


	public function submitAction(){
		/* --ENVOI DE DONNEES PAR L'UTILISATEUR DEPUIS L'INDEX -- */
		if(isset($_POST['uploadFile'])){
			
			$albumCompetition = $this->searchAlbum();

			//Envoi d'une image depuis l'ordi
			if(isset($_FILES['file'])){
				//Déplacement de l'image dans le serveur
				$target = __ROOT__.'/web/uploads/' . basename( $_FILES['file']['name']) ; 
		        move_uploaded_file($_FILES['file']['tmp_name'], $target); 
		        $image['image'] = __ROOT__."/web/uploads/".$_FILES['file']['name'];

				$data = [
				  'message' => 'My awesome photo upload example.',
				  'source' => $this->fb->fileToUpload($image['image']),
				];

				try { //Envoi de l'image
				  $response = $this->fb->post('/'.$albumCompetition.'/photos', $data);
				  //On ne conserve pas l'image sur le serveur pour éviter de l'alourdir
				  unlink($image['image']);
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
		header('Location: '.WEBPATH);
	}

	private function searchAlbum(){
		try { //Controle de l'existence de l'album dédié au concours
		  $response = $this->fb->get('/me/albums');
		}
		catch(Facebook\Exceptions\FacebookResponseException $e) {
		  echo 'Graph returned an error: ' . $e->getMessage();
		  exit;
		}
		catch(Facebook\Exceptions\FacebookSDKException $e) {
		  echo 'Facebook SDK returned an error: ' . $e->getMessage();
		  exit;
		}
		$albums = $response->getDecodedBody();
		
		foreach ($albums['data'] as $key => $album) {
			if($album['name']=="Concours Pardon-Maman"){
				$albumCompetition = $album['id'];
				break;
			}
		}
		//Création de l'album du concours si absent chez l'utilisateur
		if(!isset($albumCompetition)){
			$infos = [
				'name' => 'Concours Pardon-Maman',
				'privacy' => json_encode(array('value'=>'SELF'))
			];
			$response = $this->fb->post('/me/albums',$infos);
			$graphNode = $response->getDecodedBody();
			$albumCompetition = $graphNode['id'];
		}
		
		return $albumCompetition;
	}

}

