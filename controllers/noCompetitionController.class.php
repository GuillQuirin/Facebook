<?php

class noCompetitionController{
	public function __construct(){
		$v = new view();

		$competition = searchCompetitions();
		if($competition!==NULL)
			header('Location: '.WEBPATH);
		else{
			//$v->assign("css", "404");
			//$v->assign("js", "404");
			//$v->assign("title", "Erreur 404");
	        //$v->assign("content", "Erreur 404, <a href='".WEBPATH."/index'>Retour à l'accueil</a>.");

	        $v->setView("noCompetition", "templateempty");
	    }
    }
}