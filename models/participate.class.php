<?php 
class participate extends motherClass{

	protected $id_competition=null;
	protected $id_participant=null;
	protected $id_photo=null;

	public function setId_competition($v){$this->id_competition=$v;}
	public function setId_participant($v){$this->id_participant=$v;}
	public function setId_photo($v){$this->photo=$v;}
	

	public function getId_competition(){return $this->id_competition;}
	public function getId_participant(){return $this->id_participant;}
	public function getId_photo(){return $this->id_photo;}

}