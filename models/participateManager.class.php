<?php 

class participateManager extends basesql{
	public function __construct(){
		parent::__construct();
	}


    public function getUser(){
    	$sql = "SELECT * FROM ".$this->table." WHERE Nom=1";
		
		$sth = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute();
		$r = $sth->fetchAll(PDO::FETCH_ASSOC);

		return (!empty($r)) ? new competition($r[0]) : null;
	}

	public function getAllParticipants(){
		//Présent dans basesql car appelable de n'importe quel Manager
		$sql = "SELECT * FROM ".$this->table;
		
		$sth = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute();
		$r = $sth->fetchAll(PDO::FETCH_ASSOC);
		$list = [];
		foreach ($r as $key => $value) {
			$list[] = new participate($value);
		}
		return $list;
	}

}

/*
*
*/


