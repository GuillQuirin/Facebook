<?php
abstract class basesql{

	protected $table;
	protected static $openedConnection = false;
	protected $pdo;
	public $mirrorObject = false;
	protected $columns = [];

	public function __construct(){

		$this->table = get_called_class();
		$this->table = str_replace("Manager", "", $this->table);

		if(self::$openedConnection === false){
			
			$dsn = "mysql:dbname=".DBNAME.";host=".DBHOST;
			try{
				self::$openedConnection = new PDO($dsn,DBUSER,DBPWD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
			}catch(Exception $e){
				error_log("[#### ERREURSQL #### [\r\n".$e->getMessage())."\r\n]\r\n";
			}
		}

		$this->pdo = self::$openedConnection;
	
		//get_object_vars : retourner toutes les variables de mon objet
		$all_vars = get_object_vars($this);
		//get_class permet de récuperer le nom de la class
		//get_class_vars : permet de récupérer les variables de la classe
		$class_vars = get_class_vars(get_class());
		$this->columns = array_keys(array_diff_key($all_vars,$class_vars));
	
	}

	public function create(){
		// Check afin de savoir qui appelle cette méthode
		$e = new Exception();
		$trace = $e->getTrace();

		// get calling class:
		$calling_class = (isset($trace[1]['class'])) ? $trace[1]['class'] : false;
		// get calling method
		$calling_method = (isset($trace[1]['function'])) ? $trace[1]['function'] : false;


		if(!$calling_class || !$calling_method)
			return false;

		$this->table = strtolower(get_class($this->mirrorObject));	
		$this->columns = [];
		$object_methods = get_class_methods($this->mirrorObject);

		foreach ($object_methods as $key => $method) {
			if(strpos($method, 'get') !== FALSE && strpos($method, 'get')===0){
				$col = lcfirst(str_replace('get', '', $method));
				$this->columns[$col] = ($col==="img" || $col==="pImg" || $col==="gameImg") ? $this->mirrorObject->$method(true) : $this->mirrorObject->$method();
			};
		}
		$this->columns = array_filter($this->columns);
		return $this->save();
	}

	protected function save(){
		$sql = "INSERT INTO ".$this->table." (".implode(",",array_keys($this->columns)).")
		VALUES (:".implode(",:", array_keys($this->columns)).")";

		$query = $this->pdo->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
		foreach($this->columns as $key => $value) 
			$data[$key] = $value;

		return $query->execute($data);
	}

	protected function update($data){
		$listColumns=$this->getColumns();
		
		$sql = "UPDATE ".$this->table." SET";
		$i=0;
		foreach ($listColumns as $column) {
			if($i!=0){ //On saute le premier élèment qui correspond normalement à l'ID
				$sql .= " ".$column."=:".$column;
				if($column!=end($listColumns))
					$sql.=",";
			}
			$i++;
		}
		reset($listColumns); //obligatoire pour récupérer le 1er élement d'un tableau apres son parcours
		$sql.= " WHERE ".key($listColumns)."=:".key($listColumns);

		
		$sth = $this->pdo->prepare($sql);

		foreach ($listColumns as $key => $attribute){
			$method = 'get'.ucfirst($attribute);
			$value = $data->$method();
			$array[$key]=$value;
		}

		$sth->execute($array);	
	}

	protected function getColumns(){
		//Retourne les colonnes appartenant d'une la table visée
		$sql = "SELECT COLUMN_NAME 
				FROM INFORMATION_SCHEMA.COLUMNS 
				WHERE TABLE_SCHEMA = '".DBNAME."' AND TABLE_NAME = '".$this->table."'";

		$sth = $this->pdo->prepare($sql);
		$sth->execute();
		$r = $sth->fetchAll(PDO::FETCH_NUM);
		$list = [];

		foreach ($r as $key => $value)
			$list[$value[0]]=$value[0];

		return $list;
	}

}
