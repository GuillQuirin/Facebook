<?php 
class vote extends motherClass{

	protected $id=null;
	protected $id_user=null;
	protected $id_participate=null;

	public function setId($v){$this->id=$v;}
	public function setId_user($v){$this->id_user=$v;}
	public function setId_participate($v){$this->id_participate=$v;}

	public function getId(){return $this->id;}
	public function getId_user(){return $this->id_user;}
	public function getId_participate(){return $this->id_participate;}

}