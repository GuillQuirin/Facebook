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
		$tri = (isset($_POST['tri'])) ? $_POST['tri'] : 0;

		$participateManager = new participateManager();
		$listParticipation = $participateManager->getParticipantsByCompetition($this->competition,$tri);

		foreach ($listParticipation as $key => $participation) {
			$nblikes = $this->dataApi(TRUE, '/'.$participation['id_photo'],"?fields=likes.summary(1)");
			$listParticipation[$key]['nb_likes'] = $nblikes['likes']['summary']['total_count'];
		}
		echo json_encode($this->utf8ize($listParticipation));
	}
}

