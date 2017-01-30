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

	public function getAllCompetitions(){
    	$sql = "SELECT c.id_competition, c.name, c.description, c.start_date,
    					c.end_date, c.prize, c.url_prize, c.id_winner, c.active,
    					COUNT(p.id_user) as totalParticipants 
    			FROM ".$this->table." c 
    			LEFT OUTER JOIN participate p ON c.id_competition=p.id_competition
    			GROUP BY c.id_competition";
		
		$sth = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute();
		$r = $sth->fetchAll(PDO::FETCH_ASSOC);
		$list = [];
		foreach ($r as $key => $value) {
			$list[] = new competition($value);
		}
		return $list;
	}

	public function updateCompetition(competition $data){
		return $this->update($data);
	} 

	public function insertCompetition(competition $data){
		$this->save($data);
	} 

	public function timeCompetition($data){
		$sql = "SELECT * FROM ".$this->table." 
				WHERE active=1 AND (DATEDIFF(:end_date, start_date)<0 OR DATEDIFF(:start_date, end_date)<0)";
		//SELECT * FROM competition WHERE active=1 AND (DATEDIFF('2017-01-27', start_date)<0 OR DATEDIFF('2017-01-31', end_date)<0)
		$sth = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute($data);
		$r = $sth->fetchAll(PDO::FETCH_ASSOC);
		//var_dump($sql);
		//var_dump($data);
		return (!empty($r)) ? new competition($r[0]) : null;
	}

}

/*
*
*/


