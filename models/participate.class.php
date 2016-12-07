<?php 
class participate extends motherClass{

	protected $id_competition=null;
	protected $id_user=null;
	protected $id_photo=null;
	protected $url_photo=null;
	protected $is_reported=null;
	protected $is_locked=null;

	public function setId_competition($v){$this->id_competition=$v;}
	public function setId_user($v){$this->id_user=$v;}
	public function setId_photo($v){$this->id_photo=$v;}
	public function setUrl_photo($v){$this->url_photo=$v;}
	public function setIs_Reported($v){$this->is_reported=$v;}
	public function setIs_locked($v){$this->is_locked=$v;}

	public function getId_competition(){return $this->id_competition;}
	public function getId_user(){return $this->id_user;}
	public function getId_photo(){return $this->id_photo;}
	public function getUrl_photo(){return $this->url_photo;}
	public function getIs_reported(){return $this->is_reported;}
	public function getIs_locked(){return $this->is_locked;}

}