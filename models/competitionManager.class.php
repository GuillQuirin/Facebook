<?php 

class competitionManager extends basesql{
	public function __construct(){
		parent::__construct();
	}


    public function searchCompetitions(){
    	$sql = "SELECT * FROM ".$this->table." WHERE active=1 AND start_date<=CURRENT_DATE() AND end_date>=CURRENT_DATE() ORDER BY start_date";
		
		$sth = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute();
		$r = $sth->fetchAll(PDO::FETCH_ASSOC);

		return (!empty($r)) ? new competition($r[0]) : null;
	}

	public function getCompetitionById($id){
    	$sql = "SELECT * FROM ".$this->table." WHERE id_competition=:id_competition";
		
		$table = [
    		'id_competition' => $id
    	];	
		$sth = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute($table);
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

	public function checkEndOfCompetition(competition $competition){
		$sql = "SELECT * FROM ".$this->table." 
					WHERE id_competition=:id_competition AND end_date=CURRENT_DATE() AND active=1";
		$sth = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$data = [
			'id_competition' => $competition->getId_competition()
		];
		$sth->execute($data);
		$r = $sth->fetchAll(PDO::FETCH_ASSOC);

		return (!empty($r)) ? new competition($r[0]) : null;
	}

	public function timeCompetition($data){
		$sql = "SELECT * FROM ".$this->table." 
				WHERE active=1 
				AND DATEDIFF(:end_date, start_date)<0 
				AND DATEDIFF(:start_date, end_date)<0
				AND DATEDIFF(start_date, :end_date)<0";
		//SELECT * FROM competition WHERE active=1 AND (DATEDIFF('2017-01-27', start_date)<0 OR DATEDIFF('2017-01-31', end_date)<0)
		$sth = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute($data);
		$r = $sth->fetchAll(PDO::FETCH_ASSOC);
		return (!empty($r)) ? new competition($r[0]) : null;
	}

	public function extractBDD(){
		// Creation du fichier
		$file = fopen('result.csv', 'w+');
		 
		// Collecte des donnees
		$req = $this->pdo->query('SELECT * FROM competition;');
		$rep = $req->fetchAll(PDO::FETCH_ASSOC);
		$req->closeCursor();
		 
		// Première ligne : ligne de titres
		if(count($rep))
		   fputcsv($file, array_keys($rep[0]));
		 
		// Ajout des lignes de données
		foreach($rep as $row)
		   fputcsv($file, $row);
		 
		// Fermeture du fichier
		fclose($file);
		 
		// Et voilà
	}

}

/*
*
*/


