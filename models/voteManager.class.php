<?php 

class voteManager extends basesql{
	public function __construct(){
		parent::__construct();
	}

	public function register(vote $vote){
		$this->save($vote);
	}

}