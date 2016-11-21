<?php
class indexController extends template{
	public function indexAction($requiredPosts){
		$v = new view();
		$this->assignConnectedProperties($v);
		$v->assign("css", "index");
		$v->assign("js", "index");		
		$v->assign("fb", $this->fb);		
		$v->setView("index");
	}
}

