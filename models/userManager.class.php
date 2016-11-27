<?php 

class userManager extends basesql{
	public function __construct(){
		parent::__construct();
	}


    public function getUser(){
    	$sql = "SELECT * FROM ".$this->table." WHERE Nom=1";
		
		$sth = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute();
		$r = $sth->fetchAll(PDO::FETCH_ASSOC);

		return (!empty($r)) ? new user($r[0]) : null;
	}

	//LISTE DES DIFFERENTS PARTICIPANTS
	public function getAllUsers(){
		//Présent dans basesql car appelable de n'importe quel Manager
		$sql = "SELECT * FROM ".$this->table." WHERE validation_cgu=1";
		
		$sth = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute();
		$r = $sth->fetchAll(PDO::FETCH_ASSOC);
		$list = [];
		foreach ($r as $key => $value) {
			$list[] = new user($value);
		}
		return $list;
	}

}

/*
*
*/


