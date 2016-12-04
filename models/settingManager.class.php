<?php 

class settingManager extends basesql{
	public function __construct(){
		parent::__construct();
	}

    public function getSetting(){
    	$sql = "SELECT * FROM ".$this->table;
		
		$sth = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute();
		$r = $sth->fetchAll(PDO::FETCH_ASSOC);

		return (!empty($r)) ? new setting($r[0]) : null;
	}

	public function updateSetting(setting $data){
		$this->update($data);
	}  

}

/*
*
*/


