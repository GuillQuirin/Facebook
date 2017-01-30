<?php 

class userManager extends basesql{
	public function __construct(){
		parent::__construct();
	}

    public function getUserByIdFb($idFb){
    	//Nouvelle table avec une seule case
    	$table['idFacebook'] = $idFb;
    	$sql = "SELECT * FROM ".$this->table." WHERE idFacebook=:idFacebook";		
		$sth = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute($table);
		$r = $sth->fetchAll(PDO::FETCH_ASSOC);

		return (!empty($r)) ? new user($r[0]) : null;
	}

	public function getUsersByName($name){
    	//Nouvelle table avec une seule case
    	$table = ['%'.ucfirst($name).'%', '%'.ucfirst($name).'%'];
    	//var_dump($table);
    	$sql = "SELECT * FROM ".$this->table." WHERE last_name LIKE ? OR first_name LIKE ?";		
		$sth = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute($table);
		$r = $sth->fetchAll(PDO::FETCH_ASSOC);
		$list = [];
		//var_dump($r);
		foreach ($r as $key => $value) {
			$list[] = new user($value);
		}
		return $list;
	}

	//Liste de tous les participants
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

	//Enregistrement d'un participant
	public function saveUser(user $data){
		//Vérification s'il n'existe pas déjà en BDD
		//var_dump($data);
		$user = $this->getUserByIdFb($data->getIdFacebook());
		if($user===null){
			$save = $this->save($data);
		}
		return $this->getUserByIdFb($data->getIdFacebook());
	}

	public function updateUser(user $data){
		$this->update($data);
	}

}