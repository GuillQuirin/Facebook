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

    public function getDesignAction(){
        $designManager = new designManager();
        $listDesign = $designManager->getDesignById($_POST['id_design']);
        echo json_encode($listDesign);
    }

    public function addDesignAction(){
        $design = new design($_POST);
        $designManager = new designManager();
        $designManager->insertDesign($design);
    }

    public function applyDesignAction(){
        $designManager = new designManager();
        $designManager->activeDesign($_POST['id_design']);
        $designManager->inactiveDesign($_POST['id_design']);
    }
}