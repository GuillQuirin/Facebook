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

		$v->setView("index");
	}
}

