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
		$error = "";

		if(!$_POST){
			$error .= "Erreur !";	
		}

		if($error==""){
			$competition = new competition($_POST);
			var_dump($competition);
			$competitionManager = new competitionManager();
			$competitionManager->insertCompetition($competition);
			$error = "ok";	
		}

		echo $error;
	}

	public function editCompetitionAction(){
		$error = "";
		if(!$_POST){
			$error .= "Erreur !";	
		}

		if($error==""){
			$competition = new competition($_POST);
			$competitionManager = new competitionManager();
			$upd = $competitionManager->updateCompetition($competition);
			$error = "ok";	
		}

		echo $error;
	}

	//ADMINISTRATION DES PHOTOS
	public function adminPhotoAction(){
		$participate = new participate($_POST);
		$participateManager = new participateManager();
		$participateManager->editPhoto($participate);	
	}	
}

