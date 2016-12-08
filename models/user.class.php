<?php 
class user extends motherClass{

	protected $id_user=null;
	protected $last_name=null;
	protected $first_name=null;
	protected $email=null;
	protected $birthday=null;
	protected $validation_cgu=null;
	protected $status=null;
	protected $location=null;
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

/*	
	public function __construct($token){
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

	public function setId_user($v){$this->id_user=$v;}
	public function setLast_name($v){$this->last_name=$v;}
	public function setFirst_name($v){$this->first_name=$v;}
	public function setEmail($v){$this->email=$v;}
	public function setBirthday($v){$this->birthday=$v;}
	public function setValidation_cgu($v){$this->validation_cgu=$v;}
	public function setStatus($v){$this->status=$v;}
	public function setLocation($v){$this->location=$v;}
	public function setIdFacebook($v){$this->idFacebook=$v;}

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



	public function getId_user(){return $this->id_user;}
	public function getLast_name(){return $this->last_name;}
	public function getFirst_name(){return $this->first_name;}
	public function getEmail(){return $this->email;}
	public function getBirthday(){return $this->birthday;}
	public function getValidation_cgu(){return $this->validation_cgu;}
	public function getStatus(){return $this->status;}
	public function getLocation(){return $this->location;}
	public function getIdFacebook(){return $this->idFacebook;}

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
}