<?php 
class user extends motherClass{

	protected $id_participant=null;
	protected $last_name=null;
	protected $first_name=null;
	protected $email=null;
	protected $birth_date=null;
	protected $validation_cgu=null;
	protected $statut=null;
	protected $idFacebook=null;


	protected $user_posts=null;
	protected $user_likes=null;
	protected $user_photos=null;
	protected $user_friends=null;
	protected $publish_actions=null;
	protected $pages_show_list=null;
	protected $manage_pages=null;
	protected $pages_manage_cta=null;
	protected $publish_pages=null;
	protected $isAdmin = null;

	protected $listParticipation = [];

/*	public function __construct($token){
		$this->hydrate($token);
	}

	private function hydrate($fb){
		//Mise à jour des droits provenant de Facebook
		$response = $fb->get('/me/permissions');
		$pages = $response->getDecodedBody();
		foreach($pages['data'] as $rights => $permission){
			$method = 'set'.ucfirst($permission['permission']);
			if(method_exists($this, $method))
				$this->$method($permission['status']);
		}
	}
*/
	public function get_rights(){
		//Affichage de l'ensemble des droits enregistrés par l'application
		$list = [];
		foreach ($this as $key => $value){
			if($value!==null)
				$list[$key] = $value;
		}
		return $list;
	}

	public function setId_participant($v){$this->id_participant=$v;}
	public function setLast_name($v){$this->last_name=$v;}
	public function setFirst_name($v){$this->first_name=$v;}
	public function setEmail($v){$this->email=$v;}
	public function setBirth_date($v){$this->birth_date=$v;}
	public function setValidation_cgu($v){$this->validation_cgu=$v;}
	public function setStatut($v){$this->statut=$v;}
	public function setidFacebook($v){$this->idFacebook=$v;}

	public function setUser_posts($v){$this->user_posts=$v;}
	public function setUser_likes($v){$this->user_likes=$v;}
	public function setUser_photos($v){$this->user_photos=$v;}
	public function setUser_friends($v){$this->user_friends=$v;}
	public function setPublish_actions($v){$this->publish_actions=$v;}
	public function setPages_show_list($v){$this->pages_show_list=$v;}
	public function setManage_pages($v){$this->manage_pages=$v;}
	public function setPages_manage_cta($v){$this->pages_manage_cta=$v;}
	public function setPublish_pages($v){$this->publish_pages=$v;}
	public function setIsAdmin($v){$this->isAdmin=$v;}
	public function setListParticipation($v){$this->listParticipation=$v;}



	public function getId_participant(){return $this->id_participant;}
	public function getLast_name(){return $this->last_name;}
	public function getFirst_name(){return $this->first_name;}
	public function getEmail(){return $this->email;}
	public function getBirth_date(){return $this->birth_date;}
	public function getValidation_cgu(){return $this->validation_cgu;}
	public function getStatut(){return $this->statut;}
	public function getidFacebook(){return $this->idFacebook;}

	public function getUser_posts(){return $this->user_posts;}
	public function getUser_likes(){return $this->user_likes;}
	public function getUser_photos(){return $this->user_photos;}
	public function getUser_friends(){return $this->user_friends;}
	public function getPublish_actions(){return $this->publish_actions;}
	public function getPages_show_list(){return $this->pages_show_list;}
	public function getManage_pages(){return $this->manage_pages;}
	public function getPages_manage_cta(){return $this->pages_manage_cta;}
	public function getPublish_pages(){return $this->publish_pages;}
	public function getIsAdmin(){return $this->isAdmin;}
	public function getListParticipation(){return $this->listParticipation;}
}