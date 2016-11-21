<?php
class logoutController extends template{
	public function logoutAction($requiredPosts){
		$this->logout();
		// $v = new view();
		// $this->assignConnectedProperties($v);
		// $v->assign("css", "logouy");
		// //$v->assign("js", "logout");
		// $v->assign("fb", $this->fb);
		// $v->setView("logout");
	}
}

