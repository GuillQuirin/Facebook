<?php 

class voteManager extends basesql{
	public function __construct(){
		parent::__construct();
	}

	public function register(vote $vote){
		$this->save($vote);
	}

	public function isVote(vote $vote){
		$table = [
			"id_participate" => $vote->getId_participate(),
			"id_user" => $vote->getId_user()
		];
    	$sql = "SELECT * FROM ".$this->table." WHERE id_participate=:id_participate AND id_user=:id_user";		
		$sth = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute($table);
		$r = $sth->fetchAll(PDO::FETCH_ASSOC);
		return (!empty($r)) ? new vote($r[0]) : null;
	}

}