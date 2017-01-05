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

		$v->setView("updateCGU","templateadmin");
	}

	public function saveRegulationAction(){
        $setting = new setting($_POST);
        $settingManager = new settingManager();
        $settingManager->updateRegulation($setting);
    }
}