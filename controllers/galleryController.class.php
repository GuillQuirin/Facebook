<?php
class galleryController extends template{

	public function galleryAction(){
		$v = new view();
		$this->assignConnectedProperties($v);
		$v->assign("css", "gallery");
		$v->assign("js", "gallery");

		//Ajout d'un lien "connexion à Facebook" sur cette page
		$this->login($v);
		
		$competitionManager = new competitionManager();
		$competition = $competitionManager->searchCompetitions();
		$v->assign("competition",$competition);

		if($competition!==NULL){
			$participateManager = new participateManager();
			$listParticipation = $participateManager->getParticipantsByCompetition($this->competition);
			$v->assign("listParticipation",$listParticipation);
		}
		
		$v->setView("gallery");
	}

	public function getGalleryAction(){ 
		$tri = (isset($_POST['tri'])) ? $_POST['tri'] : 0;

		$competitionManager = new competitionManager();
		$competition = $competitionManager->searchCompetitions();
		
		if($competition!==NULL){
			$participateManager = new participateManager();
			$listParticipation = $participateManager->getParticipantsByCompetition($this->competition,$tri);

			if(isset($_SESSION['idFB'])){
				$userManager = new userManager();
				$user = $userManager->getUserByIdFb($_SESSION['idFB']);
			}

			foreach ($listParticipation as $key => $participation) {
				$participate = new participate($participation);
				$listParticipation[$key]['nb_likes'] = $participateManager->getTotalLikesByParticipation($participate);
				
				if($listParticipation[$key]['nb_likes']==NULL) 
					$listParticipation[$key]['nb_likes']=0;

				if(isset($_SESSION['idFB']))
					$listParticipation[$key]['is_liked'] = $participateManager->getLikesByUser($user, $participate);
			}
		}
		else
			$listParticipation = [];
		
		echo json_encode($this->utf8ize($listParticipation));
	}

	public function addLikeAction(){
		$participateManager = new participateManager();
		$participate = new participate($_POST);

		$userManager = new userManager();
		$user = $userManager->getUserByIdFb($_SESSION['idFB']);
		$_POST['id_user'] = $user->getId_user();
		$vote = new vote($_POST);

		//Enregistrement du vote en BDD
		$voteManager = new voteManager();
		$voteBDD = $voteManager->isVote($vote);

		if($voteBDD==NULL)
			$voteManager->register($vote);

		//Actualisation du compteur de like pour la participation
		echo json_encode($participateManager->getTotalLikesByParticipation($participate));
	}

	public function reportAction(){
		$whiteList['id'] = FILTER_VALIDATE_INT; 
		$post = filter_var_array($_POST,$whiteList);

		$participation = new participate($post);
		$participateManager = new participateManager();
		$participateManager->reportParticipation($participation);
	}
}

