<?php 
class competition extends motherClass{

	protected $id_competition=null;
	protected $name=null;
	protected $description=null;
	protected $start_date=1;
	protected $end_date=null;
	protected $prize=null;
	protected $url_prize=null;
	protected $id_winner=null;
	protected $active=1;
	
	protected $totalParticipants=null;




	public function setId_competition($v){$this->id_competition=$v;}
	public function setName($v){$this->name=$v;}
	public function setDescription($v){$this->description=$v;}
	public function setStart_date($v){$this->start_date=$v;}
	public function setEnd_date($v){$this->end_date=$v;}
	public function setPrize($v){$this->prize=$v;}
	public function setUrl_prize($v){$this->url_prize=$v;}
	public function setId_winner($v){$this->id_winner=$v;}
	public function setActive($v){$this->active=1;}
	public function setTotalParticipants($v){$this->totalParticipants=$v;}


	public function getId_competition(){return $this->id_competition;}
	public function getName(){return $this->name;}
	public function getDescription(){return $this->description;}
	public function getStart_date(){return $this->start_date;}
	public function getEnd_date(){return $this->end_date;}
	public function getPrize(){return $this->prize;}
	public function getUrl_prize(){return $this->url_prize;}
	public function getId_winner(){return $this->id_winner;}
	public function getActive(){return $this->active;}
	public function getTotalParticipants(){return $this->totalParticipants;}
}