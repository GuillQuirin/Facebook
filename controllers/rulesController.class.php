<?php
class rulesController extends template{
	public function rulesAction(){
		$v = new view();
		$this->assignConnectedProperties($v);

		 $v->assign("css", "rules");
		// $v->assign("js", "noCompetition");
		$v->assign("title", "Règlement du concours");
		$settingManager = new settingManager();
		$setting = $settingManager->getSetting();
		$v->assign("setting", $setting[1]); //Règlement

        $v->setView("rules");
    }
}