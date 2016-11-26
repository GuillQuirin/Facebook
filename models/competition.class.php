<?php 
class competition{

	protected $id=null;
	protected $name=null;
	protected $description=null;
	protected $start_date=null;
	protected $end_date=null;
	protected $prize=null;
	protected $id_winner=null;
	protected $active=null;


	public function __construct(array $data){
		$this->hydrate($data);
	}

	private function hydrate($data){
		foreach ($data as $key => $value) {
			$method = 'set'.ucfirst($key);
			if (method_exists($this, $method)) {
				$this->$method($value);
			}
		}
	}


	public function setName($v){$this->name=$v;}
	public function setDescription($v){$this->description=$v;}
	public function setStart_date($v){$this->start_date=$v;}
	public function setEnd_date($v){$this->end_date=$v;}
	public function setPrize($v){$this->prize=$v;}
	public function setId_winner($v){$this->id_winner=$v;}
	public function setActive($v){$this->active=$v;}


	public function getName(){return $this->name;}
	public function getDescription(){return $this->description;}
	public function getStart_date(){return $this->start_date;}
	public function getEnd_date(){return $this->end_date;}
	public function getPrize(){return $this->prize;}
	public function getId_winner(){return $this->id_winner;}
	public function getActive(){return $this->active;}

}