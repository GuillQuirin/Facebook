<?php

class designController extends template{
	public function designAction(){
        $v = new view();
        $this->assignConnectedProperties($v);
        $v->assign("css", "admin");
        $v->assign("js", "admin");
        $designManager = new designManager();
		$listDesign = $designManager->getAllDesigns();
		$v->assign("listDesign", $listDesign);
        $v->setView("/admin/design","templateadmin");
    }
}