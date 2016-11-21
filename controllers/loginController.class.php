<?php
class loginController extends template{
	public function loginAction($requiredPosts){
		$v = new view();
		$this->assignConnectedProperties($v);
		$v->assign("css", "login");
		//$v->assign("js", "login");
		$v->assign("fb", $this->fb);
		$v->setView("login");
	}
}

