<?php
class galleryController extends template{
	public function galleryAction($requiredPosts){
		$v = new view();
		$this->assignConnectedProperties($v);
		$v->assign("css", "gallery");
		//$v->assign("js", "gallery");
		//$v->assign("fb", $this->fb);
		$v->setView("gallery");
	}
}

