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

		if(isset($_SESSION['ACCESS_TOKEN'])){
			//Récupération des différentes photos de l'utilisateur
			$infoPhoto = "photos{id,name,source},albums{id,name,photos{id,name,source}}";
			$v->assign("images", $this->dataApi(TRUE,'/me?fields=',$infoPhoto,""));
		}
		
		$listInfosUser = ['id','name','first_name','last_name','email','age_range','location'];
      	$infosUser = $this->dataApi(TRUE,'/me?fields=',$listInfosUser,"");
      	$v->assign("test",$infosUser);


		$v->setView("index","templateempty");
	}


	public function submitAction(){
		/* --ENVOI DE DONNEES PAR L'UTILISATEUR DEPUIS L'ACCUEIL -- */
		$ok = FALSE;
		//Création de l'album dans FB si inexistant
		$albumCompetition = $this->searchAlbumCompetition();

		//Envoi d'une image depuis l'ordi
		if(isset($_POST['uploadFile'])){
			if(isset($_FILES['file'])){
				//Déplacement de l'image dans le serveur
				$target = __ROOT__.'/web/uploads/' . basename( $_FILES['file']['name']) ; 
		        move_uploaded_file($_FILES['file']['tmp_name'], $target); 
		        $image['image'] = __ROOT__."/web/uploads/".$_FILES['file']['name'];

				$data = [
				  'message' => 'My awesome photo upload example.',
				  'source' => $this->fb->fileToUpload($image['image']),
				];

				//Envoi de la photo sur Facebook
				$idFbPhoto = $this->dataApi(FALSE,'/'.$albumCompetition,"/photos",$data);
				unlink($image['image']);
				
				$infosPhoto = $this->dataApi(TRUE,'/'.$idFbPhoto['id'].'?fields=','id,name,source',"");
				$ok = TRUE;
			}
		}

		if(isset($_POST['fromFB'])){
			//Récupération de l'url de la photo présente sur FB
			$infosPhoto = $this->dataApi(TRUE,'/'.$_POST['idPhoto'].'?fields=','id,name,source',"");
			$data = [
			  'url' => $infosPhoto['source']
			];
			//Envoi de la photo sur Facebook
			$idFbPhoto = $this->dataApi(FALSE,'/'.$albumCompetition."/photos","",$data);
			$ok = TRUE;
		}

		if($ok){
			//Enregistrement de l'utilisateur
			$user = $this->bringDatasUser();	
			//Enregistrement de la participation
			$infosParticipation =[
			  	'id_competition' => $this->competition->getId_competition(),
				'id_user' => $user->getId_user(),
				'id_photo' => $infosPhoto['id'],
				'url_photo' => $infosPhoto['source']
			];

			$participation = new participate($infosParticipation);
			$participationManager = new participateManager();
			$idParticipation = $participationManager->saveParticipation($participation);
		}

		header('Location: '.WEBPATH);
	}

	public function checkUserAction(){
		if(isset($_SESSION['idFB'])){
			$userManager = new userManager();
			$user = $userManager->getUserByIdFb($_SESSION['idFB']);

			$listPb = [];
			if(trim($user->getLast_name())=="")
				$listPb["public_profile"]="Nom (information essentielle pour vous contacter)";

			if(trim($user->getFirst_name())=="")
				$listPb["public_profile"]="Prénom (information essentielle pour vous contacter)";

			if(trim($user->getEmail())=="")
				$listPb["email"]="Adresse e-mail (information essentielle pour vous contacter)";

			if($user->getAge_range()=="0")
				$listPb["public_profile"]="Age (vous devez être majeur (ou avoir l'accord de vos tuteurs) pour participer)";

			if(trim($user->getLocation())=="")
				$listPb["user_location"]="Localisation (le concours est disponible pour les participants vivants à proximité de l'Ile-de-France)";
			
			echo json_encode($listPb);
		}
		else
			return false;
	}

	private function searchAlbumCompetition(){
		$albums = $this->dataApi(TRUE,'/me','/albums',"");
		
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
			$graphNode = $this->dataApi(FALSE,"/me","/albums",$infos);
			$albumCompetition = $graphNode['id'];
		}
		
		return $albumCompetition;
	}


}

