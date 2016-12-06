<?php

class newCompetitionController{
	public function __construct(){
		$v = new view();

		/*$competitionManager = new competitionManager();
		$competition = $competitionManager->searchCompetitions();
		if($competition!==NULL)
			header('Location: '.WEBPATH);
		else{

			$settingManager = new settingManager();
			$setting = $settingManager->getSetting();

			$v->assign("css", "noCompetition");
			$v->assign("js", "noCompetition");
			$v->assign("title", "Pas de concours");
			$v->assign("setting", $setting);
	        //$v->assign("content", "Erreur 404, <a href='".WEBPATH."/index'>Retour à l'accueil</a>.");*/

	        $v->setView("newCompetition");
	    //}
    }
}