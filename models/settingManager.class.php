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
		$list = [];
		foreach ($r as $key => $value) {
			$list[] = new setting($value);
		}
		return $list;
	}

	public function updateSetting($regulation, $id_setting){
		$sql = "UPDATE setting SET value = :value WHERE id_setting = :id";
		$table = [
			'id' => $id_setting,
			'value' => $regulation
		];

		$sth = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		$sth->execute($table);
	}  

}

/*
*
*/


