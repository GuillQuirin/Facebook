<?php 

class participateManager extends basesql{
	public function __construct(){
		parent::__construct();
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

	public function getParticipantsByCompetition(competition $data,$order=0){
		//Présent dans basesql car appelable de n'importe quel Manager
		$sql = "SELECT p.id, p.id_competition, p.id_user, p.id_photo, 
						p.url_photo, p.is_reported, p.is_locked, 
						p.date_created, p.date_updated, p.deleted, u.last_name, u.first_name 
					FROM participate p
					LEFT OUTER JOIN user u ON p.id_user = u.id_user
					WHERE id_competition=:id_competition";
		
		switch($order){
			case 1:
				$sql.=" ORDER BY p.date_created ASC";
				break;

			case 2:
				$sql.=" ORDER BY p.date_created DESC";
				break;
		}

		//Nouvelle table avec une seule case
    	$table = [
    		'id_competition' => $data->getId_competition()
    	];	
    	$list =[];
		$sth = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute($table);
		$r = $sth->fetchAll(PDO::FETCH_ASSOC);
		foreach ($r as $key => $value){
			$list[] = $value;
		}
		if(!empty($list) && $order==0)
			shuffle($list);

		return $list;
	}

	public function getParticipationByIds(participate $data){
		$sql = "SELECT id, id_competition, id_user, id_photo, 
						url_photo, is_reported, is_locked, 
						date_created, date_updated, deleted  
					FROM participate 
					WHERE id_competition=:id_competition AND id_user=:id_user";
		
		//Nouvelle table avec une seule case
    	$table = [
    		'id_competition' => $data->getId_competition(),
    		'id_user' => $data->getId_user()
    	];	
		$sth = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute($table);
		$r = $sth->fetchAll(PDO::FETCH_ASSOC);

		return (!empty($r)) ? new participate($r[0]) : null;
	}

	/*
	* Get all participation with reported photo
	*/
	public function getPhotoReported(){
		$sql = "SELECT p.id, p.id_competition, p.id_photo, 
						p.url_photo, p.is_reported, p.is_locked, 
						p.date_created, p.date_updated, p.deleted,
						u.last_name, u.first_name 
					FROM participate p 
						LEFT OUTER JOIN user u ON u.id_user = p.id_user
					WHERE p.is_reported = 1";
		
		$sth = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute();
		$r = $sth->fetchAll(PDO::FETCH_ASSOC);
		$list = [];
		foreach ($r as $key => $value) {
			$list[] = new participate($value);
		}

		return $list;
	}

	public function saveParticipation(participate $data){
		//Vérification s'il n'existe pas déjà en BDD
		/*$participation = $this->getParticipationByIds($data);
		if($participation===null)*/
			$save = $this->save($data);
		//Renvoi de l'objet avec ses id de la BDD complétés
		return $this->getParticipationByIds($data);
	}

	public function editPhoto(participate $data){
		$this->update($data);
	}
}

/*
*
*/


