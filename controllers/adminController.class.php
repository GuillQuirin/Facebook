<?php

class adminController extends template{
	public function adminAction(){
		$v = new view();
		$this->assignConnectedProperties($v);
		//$v->assign("css", "admin");
		$v->assign("js", "admin");				
		
		$competitionManager = new competitionManager();
		$listCompetitions = $competitionManager->getAllCompetitions();
		$v->assign("listCompetitions",$listCompetitions);
	

		$v->setView("admin","templateadmin");
	}

	public function addCompetitionAction(){
		$competition = new competition($_POST);
		$competitionManager = new competitionManager();
		$competitionManager->insertCompetition($competition);
	}

	public function editCompetitionAction(){
		$competition = new competition($_POST);
		$competitionManager = new competitionManager();
		$competitionManager->updateCompetition($competition);
	}
}

