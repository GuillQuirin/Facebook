<?php 
class setting extends motherClass{

	protected $id_setting=null;
	protected $name=null;
	protected $value=null;
	protected $date_created=null;
	protected $date_updated=null;
	protected $deleted=null;

	public function setId_setting($v){$this->id_setting=$v;}
	public function setName($v){$this->name=$v;}
	public function setValue($v){$this->value=$v;}
	public function setDate_created($v){$this->date_created=$v;}
	public function setDate_updated($v){$this->date_updated=$v;}
	public function setDeleted($v){$this->deleted=$v;}

	public function getId_setting(){return $this->id_setting;}
	public function getName(){return $this->name;}
	public function getValue(){return $this->value;}
	public function getDate_created(){return $this->date_created;}
	public function getDate_updated(){return $this->date_updated;}
	public function getDeleted(){return $this->deleted;}
}