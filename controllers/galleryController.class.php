<?php
class galleryController extends template{

	public function galleryAction(){
		$v = new view();
		$this->assignConnectedProperties($v);
		$v->assign("css", "gallery");
		$v->assign("js", "gallery");

		$participateManager = new participateManager();
		$listParticipation = $participateManager->getParticipantsByCompetition($this->competition);
		$v->assign("listParticipation",$listParticipation);

		$v->setView("gallery");
	}

	public function getGalleryAction(){
		//$page = $_POST['page'];

		$participateManager = new participateManager();
		$listParticipation = $participateManager->getParticipantsByCompetition($this->competition);
		//print_r($listParticipation);
		echo json_encode($this->utf8ize($listParticipation));
	}
}

