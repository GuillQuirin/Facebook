<?php

class noCompetitionController extends template{
	public function __construct(){
		$v = new view();

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

			if(isset($_SESSION['ACCESS_TOKEN'])){
				//Liste admins de l'application
				$v->assign("admins", $this->dataApi(TRUE,'/app/roles',array(),"1804945786451180|yqj6xWNaG2lUvVv3sfwwRbU5Sjk"));
				
				//Infos de l'utilisateur
				$infosUser = ['id','name','first_name','last_name','email','birthday','location'];
				$v->assign("user", $this->dataApi(TRUE,'/me?fields=',$infosUser,"",FALSE));
			}

	        //$v->assign("content", "Erreur 404, <a href='".WEBPATH."/index'>Retour à l'accueil</a>.");

	        $v->setView("noCompetition", "templateempty");
	    }
    }
}