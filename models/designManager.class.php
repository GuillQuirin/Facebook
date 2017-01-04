<?php 

class designManager extends basesql{
	public function __construct(){
		parent::__construct();
	}

	public function getAllDesigns(){
    	$sql = "SELECT * FROM ".$this->table;
		
		$sth = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute();
		$r = $sth->fetchAll(PDO::FETCH_ASSOC);
		$list = [];
		foreach ($r as $key => $value) {
			$list[] = new design($value);
		}
		return $list;
	}

	public function insertDesign(design $data){
		$this->save($data);
	} 

	public function getDesignById($id){
		$sql = "SELECT * FROM design WHERE id_design = :id_design";
		$table = [
    		'id_design' => $id
    	];	
		$sth = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute($table);
		$r = $sth->fetchAll(PDO::FETCH_ASSOC);
		$list = [];;
		foreach ($r as $key => $value) {
			$list[] = $value;
		}
		return $list;
	}
}