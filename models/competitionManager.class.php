<?php 

class competitionManager extends basesql{
	public function __construct(){
		parent::__construct();
	}


    public function searchCompetitions(){
    	$sql = "SELECT * FROM ".$this->table." WHERE active=1";
		
		$sth = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute();
		$r = $sth->fetchAll(PDO::FETCH_ASSOC);

		return (!empty($r)) ? new competition($r[0]) : null;
	}
}

/*
*
*/


