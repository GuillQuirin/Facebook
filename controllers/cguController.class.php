<?php
class cguController extends template{
	public function cguAction(){
		$v = new view();
		$this->assignConnectedProperties($v);

		 $v->assign("css", "cgu");
		// $v->assign("js", "noCompetition");
		$v->assign("title", "Conditions Générales");
		$settingManager = new settingManager();
		$setting = $settingManager->getSetting();
		$v->assign("setting", $setting[0]);

        $v->setView("cgu");
    }
}