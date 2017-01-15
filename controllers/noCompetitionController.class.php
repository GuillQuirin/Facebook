<?php
class noCompetitionController extends template{
	public function noCompetitionAction(){
		$v = new view();
		$this->assignConnectedProperties($v);

		$competitionManager = new competitionManager();
		$competition = $competitionManager->searchCompetitions();

		$settingManager = new settingManager();
		$setting = $settingManager->getSetting();

		$v->assign("css", "noCompetition");
		$v->assign("js", "noCompetition");
		$v->assign("title", "Pas de concours");
		$v->assign("setting", $setting);

        $v->setView("noCompetition", "templateempty");
    }
}