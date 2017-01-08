<?php 
class user extends motherClass{

	protected $id_user=null;
	protected $last_name=null;
	protected $first_name=null;
	protected $email=null;
	protected $age_range=null;
	protected $validation_cgu=null;
	protected $location=null;
	protected $idFacebook=null;
	protected $status=null;
	protected $date_created=null;
	protected $date_updated=null;
	protected $deleted=null;
	protected $isAdmin = null;

	public function setId_user($v){$this->id_user=$v;}
	public function setLast_name($v){$this->last_name=$v;}
	public function setFirst_name($v){$this->first_name=$v;}
	public function setEmail($v){$this->email=$v;}
	public function setAge_range($v){$this->age_range=$v;}
	public function setValidation_cgu($v){$this->validation_cgu=$v;}
	public function setLocation($v){$this->location=$v;}
	public function setIdFacebook($v){$this->idFacebook=$v;}
	public function setStatus($v){$this->status=$v;}
	public function setDate_created($v){$this->date_created=$v;}
	public function setDate_updated($v){$this->date_updated=$v;}
	public function setDeleted($v){$this->deleted=$v;}
	public function setIsAdmin($v){$this->isAdmin=$v;}



	public function getId_user(){return $this->id_user;}
	public function getLast_name(){return $this->last_name;}
	public function getFirst_name(){return $this->first_name;}
	public function getEmail(){return $this->email;}
	public function getAge_range(){return $this->age_range;}
	public function getValidation_cgu(){return $this->validation_cgu;}
	public function getLocation(){return $this->location;}
	public function getIdFacebook(){return $this->idFacebook;}
	public function geStatus(){return $this->status;}
	public function getDate_created(){return $this->date_created;}
	public function getDate_updated(){return $this->date_updated;}
	public function getDeleted(){return $this->deleted;}
	public function getIsAdmin(){return $this->isAdmin;}
}