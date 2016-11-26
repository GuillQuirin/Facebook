<?php 
class motherClass{

	public function __construct(array $data){
		$this->hydrate($data);
	}

	private function hydrate($data){
		foreach ($data as $key => $value) {
			$method = 'set'.ucfirst($key);
			if(method_exists($this, $method))
				$this->$method($value);
		}
	}

	public function getAllAttributes(){
		//Retourne l'ensemble des attributs d'une classe
		return get_object_vars($this);
	}

}