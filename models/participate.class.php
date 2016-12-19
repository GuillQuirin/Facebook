<?php 
class participate extends motherClass{

	protected $id=null;
	protected $id_competition=null;
	protected $id_user=null;
	protected $id_photo=null;
	protected $url_photo=null;
	protected $is_reported=null;
	protected $is_locked=null;
	private   $last_name = null; //private pour simplement le démarquer des colonnes de la BDD
	private   $first_name = null; //private pour simplement le démarquer des colonnes de la BDD
	protected $date_created = null;
	protected $date_updated = null;
	protected $deleted = null;
	
	

	public function setId($v){$this->id=$v;}
	public function setId_competition($v){$this->id_competition=$v;}
	public function setId_user($v){$this->id_user=$v;}
	public function setId_photo($v){$this->id_photo=$v;}
	public function setUrl_photo($v){$this->url_photo=$v;}
	public function setIs_Reported($v){$this->is_reported=$v;}
	public function setIs_locked($v){$this->is_locked=$v;}
	public function setLast_name($v){$this->last_name=$v;}
	public function setFirst_name($v){$this->first_name=$v;}
	public function setDate_created($v){$this->date_created=$v;}
	public function setDate_updated($v){$this->date_updated=$v;}
	public function setDeleted($v){$this->deleted=$v;}
	

	public function getId(){return $this->id;}
	public function getId_competition(){return $this->id_competition;}
	public function getId_user(){return $this->id_user;}
	public function getId_photo(){return $this->id_photo;}
	public function getUrl_photo(){return $this->url_photo;}
	public function getIs_reported(){return $this->is_reported;}
	public function getIs_locked(){return $this->is_locked;}
	public function getLast_name(){return $this->last_name;}
	public function getFirst_name(){return $this->first_name;}
	public function getDate_created(){return $this->date_created;}
	public function getDate_updated(){return $this->date_updated;}
	public function getDeleted(){return $this->deleted;}
}