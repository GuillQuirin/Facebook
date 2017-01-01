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
			$participation['url_photo'] = str_replace(
														substr(
																$participation['url_photo'],
																strpos($participation['url_photo'],
																"?")
															),
														"",
														$participation['url_photo']
													);

			$nblikes = $this->dataApi(TRUE, '/'.$participation['url_photo'],"?fields=og_object{likes.limit(0).summary(true)}");
			$listParticipation[$key]['url_photo_cleaned'] = $participation['url_photo'];
			$listParticipation[$key]['nb_likes'] = $nblikes['og_object']['likes']['summary']['total_count'];
		}
		echo json_encode($this->utf8ize($listParticipation));
	}

	public function reportAction(){
		$whiteList['id'] = FILTER_VALIDATE_INT; 
		$post = filter_var_array($_POST,$whiteList);

		$participation = new participate($post);
		$participateManager = new participateManager();
		$participateManager->reportParticipation($participation);
	}
}

