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

	public function getParticipationByIds(participate $data){
		$sql = "SELECT * FROM ".$this->table." WHERE id_competition=:id_competition AND id_user=:id_user";
		
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
		$sql = "SELECT * FROM ".$this->table." WHERE is_reported = 1";
		
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
		$participation = $this->getParticipationByIds($data);
		if($participation===null)
			$save = $this->save($data);
		//Renvoi de l'objet avec ses id de la BDD complétés
		return $this->getParticipationByIds($data);
	}
}

/*
*
*/


