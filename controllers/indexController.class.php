<?php
class indexController extends template{
	public function indexAction($requiredPosts){
		$v = new view();
		$this->assignConnectedProperties($v);
		$v->assign("css", "index");
		$v->assign("js", "index");				
		
		//Ajout d'un lien "connexion à Facebook" sur cette page
		$this->login($v);

		$v->setView("index");
	}
}

