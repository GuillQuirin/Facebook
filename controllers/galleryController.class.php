<?php
class galleryController extends template{

	public function galleryAction(){
		$v = new view();
		$this->assignConnectedProperties($v);
		$v->assign("css", "gallery");
		$v->assign("js", "gallery");

		$participateManager = new participateManager();
		$listParticipation = $participateManager->getParticipantsByCompetition($this->competition);
		$v->assign("listParticipation",$listParticipation);

		$v->setView("gallery");
	}

	public function getGalleryAction(){ 
		$tri = (isset($_POST['tri'])) ? $_POST['tri'] : 0;

		$participateManager = new participateManager();
		$listParticipation = $participateManager->getParticipantsByCompetition($this->competition,$tri);

		$userManager = new userManager();
		$user = $userManager->getUserByEmail($_SESSION['email']);

		foreach ($listParticipation as $key => $participation) {
			$participate = new participate($participation);
			$listParticipation[$key]['nb_likes'] = $participateManager->getTotalLikesByParticipation($participate);
			$listParticipation[$key]['is_liked'] = $participateManager->getLikesByUser($user, $participate);
		}
		echo json_encode($this->utf8ize($listParticipation));
	}

	public function addLikeAction(){
		$userManager = new userManager();
		$user = $userManager->getUserByEmail($_SESSION['email']);

		$_POST['id_user'] = $user->getId_user();
		$vote = new vote($_POST);

		$voteManager = new voteManager();
		$vote = $voteManager->register($vote);
	}

	public function reportAction(){
		$whiteList['id'] = FILTER_VALIDATE_INT; 
		$post = filter_var_array($_POST,$whiteList);

		$participation = new participate($post);
		$participateManager = new participateManager();
		$participateManager->reportParticipation($participation);
	}
}

