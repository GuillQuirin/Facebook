<?php
class noCompetitionController extends template{
	public function noCompetitionAction(){
		$v = new view();
		$this->assignConnectedProperties($v);

		$competitionManager = new competitionManager();
		$competition = $competitionManager->searchCompetitions();
		if($competition!==NULL)
			header('Location: '.WEBPATH);
		else{
			//Ajout d'un lien "connexion à Facebook" sur cette page
		 	$this->login($v);

			$settingManager = new settingManager();
			$setting = $settingManager->getSetting();

			$v->assign("css", "noCompetition");
			$v->assign("js", "noCompetition");
			$v->assign("title", "Pas de concours");
			$v->assign("setting", $setting);

	        $v->setView("noCompetition", "templateempty");
	    }
    }
}