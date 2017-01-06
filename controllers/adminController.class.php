<?php

class adminController extends template{
	public function adminAction(){
		$v = new view();
		$this->assignConnectedProperties($v);
		$v->assign("css", "admin");
		$v->assign("js", "admin");				
		
		//Competitions
		$competitionManager = new competitionManager();
		$listCompetitions = $competitionManager->getAllCompetitions();
		$v->assign("listCompetitions",$listCompetitions);
		
		//Utilisateurs
		$userManager = new userManager();
		$listUsers = $userManager->getAllUsers();
		$v->assign("listUsers",$listUsers);

		//Participations
		$participateManager = new participateManager();
		$listParticipants = $participateManager->getAllParticipants();
		$v->assign("listParticipants",$listParticipants);

		//Photo signalées
		$listReportedPhoto = $participateManager->getPhotoReported();
		$v->assign("listReportedPhoto",$listReportedPhoto);

		if($this->isAdmin==1)
			$v->setView("admin","templateadmin");
		else
			header('Location: '.WEBPATH);
	}

	//ADMINISTRATION DES COMPETITIONS

	public function addCompetitionAction(){
		$competition = new competition($_POST);
		$competitionManager = new competitionManager();
		$competitionManager->insertCompetition($competition);
	}

	public function editCompetitionAction(){
		if(!$_POST){
			echo "Erreur !";	
		}
		else{
			$competition = new competition($_POST);
			$competitionManager = new competitionManager();
			$upd = $competitionManager->updateCompetition($competition);
			echo "ok";	
		}
	}

	//ADMINISTRATION DES PHOTOS
	public function adminPhotoAction(){
		$participate = new participate($_POST);
		$participateManager = new participateManager();
		$participateManager->editPhoto($participate);	
	}	
}

