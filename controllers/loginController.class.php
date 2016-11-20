<?php
class loginController extends template{
	public function loginAction($requiredPosts){
		$v = new view();
		$this->assignConnectedProperties($v);
		$v->assign("css", "login");
		//$v->assign("js", "login");

		/*
		//Liste Tournois
		$obj = new tournamentManager();
		//Le paramètre par défaut vaut NULL si l'utilisateur n'est pas connecté
		$listetournois = $obj->getUnstartedTournaments($this->connectedUser);
		if(!!($listetournois)){
			$v->assign("listeTournois", $listetournois);
		}
		*/
		$v->setView("login");
	}
}

