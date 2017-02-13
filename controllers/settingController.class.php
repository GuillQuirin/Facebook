<?php

class settingController extends template{
	public function settingAction(){
		$v = new view();
		$this->assignConnectedProperties($v);
		$v->assign("css", "admin");
		$v->assign("js", "admin");				
		
		//Settings
		$settingManager = new settingManager();
		$listSetting = $settingManager->getSetting();
		$v->assign("listSetting", $listSetting);

		$v->setView("setting","templateadmin");
	}

	public function saveRegulationAction(){
        $settingManager = new settingManager();
        $settingManager->updateSetting($_POST['regulation'], $_POST['id_setting']);
    }

    public function saveCGUAction(){
        $settingManager = new settingManager();
        $settingManager->updateSetting($_POST['cgu'], $_POST['id_setting']);
    }
}