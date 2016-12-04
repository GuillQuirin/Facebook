<?php 
class setting extends motherClass{

	protected $cgu=null;
	protected $regulation=null;
	protected $background_url=null;
	protected $adress=null;

	public function setCgu($v){$this->cgu=$v;}
	public function setRegulation($v){$this->regulation=$v;}
	public function setBackground_url($v){$this->background_url=$v;}
	public function setAdress($v){$this->adress=$v;}

	public function getCgu(){return $this->cgu;}
	public function getRegulation(){return $this->regulation;}
	public function getBackground_url(){return $this->background_url;}
	public function getAdress(){return $this->adress;}
}