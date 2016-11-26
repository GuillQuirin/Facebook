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

		return (!empty($r)) ? new competition($r[0]) : null;
	}
}

/*
*
*/


