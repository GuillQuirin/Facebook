<?php
class indexController extends template{
	public function indexAction($requiredPosts){
		$v = new view();
		$this->assignConnectedProperties($v);
		$v->assign("css", "index");
		$v->assign("js", "index");

		/*
		//Liste Tournois
		$obj = new tournamentManager();
		//Le paramètre par défaut vaut NULL si l'utilisateur n'est pas connecté
		$listetournois = $obj->getUnstartedTournaments($this->connectedUser);
		if(!!($listetournois)){
			$v->assign("listeTournois", $listetournois);
		}
		*/
		
		$v->setView("index");
	}
}

