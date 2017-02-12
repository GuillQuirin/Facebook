<?php
/*
*
*/
class template{
  protected $fb=NULL;
  protected $competition = NULL;
  protected $isAdmin = NULL;

  public function __construct(){
    if($this->fb===null){
      require_once __ROOT__.'/web/vendor/autoload.php';      
      //Connexion à l'application enregistrée
      $this->fb = new Facebook\Facebook([
        'app_id' => '1804945786451180',
        'app_secret' => APP_SECRET,
        'default_graph_version' => 'v2.8',
        'fileUpload' => true
      ]);
    }
    
    //Recherche d'un concours ouvert au public
    $competitionManager = new competitionManager();
    $this->competition = $competitionManager->searchCompetitions();

    //Session ouverte sur 2 heures
    if(isset($_SESSION['ACCESS_TOKEN'])){
      //$this->fb->setDefaultAccessToken($_SESSION["LONG_ACCESS_TOKEN"]); //60 jours
      $this->fb->setDefaultAccessToken($_SESSION["ACCESS_TOKEN"]);

      //Enregistrement de l'utilisateur en BDD dès sa connexion
      $user = $this->bringDatasUser();

      if($user!=NULL && in_array($user->getIdFacebook(),$this->bringListAdmins()))
        $this->isAdmin = 1;
    }
  }

  // Cette methode enverra à la view reçue en parametre les propriétés nécessaires de la Template
  protected function assignConnectedProperties(view $v){
    if($this->fb!==null)
      $v->assign("fb",$this->fb);

    if($this->competition!==NULL)
      $v->assign("competition",$this->competition);
      
    if(isset($_SESSION['ACCESS_TOKEN'])){  
      //Liste des admins
      $v->assign("listAdmins", $this->bringListAdmins());
       
      //Infos de l'utilisateur
      $v->assign("user", $this->bringDatasUser());  

      //Participation de l'utilisateur à ce concours oui/non
      if($this->competition!==NULL){
        $infosParticipation = [  
          'id_competition' => $this->competition->getId_competition(),
          'id_user' =>  $this->bringDatasUser()->getId_user()
        ];
        $participation = new participate($infosParticipation);
        $participationManager = new participateManager();

        //Vérification de la participation unique du joueur à ce concours
        $canParticipate = $participationManager->checkParticipation($participation);
        $v->assign("canParticipate", $canParticipate);

        //Vérification de la possibilité de publier sur le mur du joueur
        $table[] = "permissions";
        $permissions = $this->dataApi(TRUE, '/me?fields=',$table);
        $cantPublish = true;
        foreach ($permissions['permissions']['data'] as $key => $value) {
          if($value['permission']=="publish_actions" && $value['status']=="granted")
            $cantPublish=false;
        }
        $v->assign("cantPublish", $cantPublish);
      }
    }

    //Renvoi sur la page noCompetition lorsqu'il n'y a pas de concours disponible (si l'utilisateur n'y était pas déjà)
    if(get_class($this)!="noCompetitionController" && $this->competition===NULL && $this->isAdmin==NULL)
      $v->assign("noCompetition",1);

    //Info sur le statut de l'utilisateur
    $v->assign("isAdmin",$this->isAdmin);
  }


  //Importation des administrateurs de l'application
  protected function bringListAdmins(){
    $admins = $this->dataApi(TRUE,'/app/roles',array(),"1804945786451180|yqj6xWNaG2lUvVv3sfwwRbU5Sjk");
    $listAdmins=[];
    foreach ($admins['data'] as $key => $admin) {
      if($admin['role']=="administrators")
        $listAdmins[] = $admin['user'];
    }
    return $listAdmins;
  }

  //Importation des infos de l'utilisateur depuis Facebook
  protected function bringDatasUser($update=0){
      $listInfosUser = ['id','name','first_name','last_name','email','age_range','location'];
      $infosUser = $this->dataApi(TRUE,'/me?fields=',$listInfosUser,"");

      if(is_array($infosUser)){

        if(isset($infosUser['age_range']))
          $infosUser['age_range'] = $infosUser['age_range']['min'];
        
        if(isset($infosUser['location']))
          $infosUser['location'] = $infosUser['location']['name'];
        
        $infosUser['idFacebook'] = $infosUser['id'];
        unset($infosUser['id']);

        $user = new user($infosUser);
        $userManager = new userManager();     
        $userBDD = $userManager->getUserByIdFb($user->getIdFacebook()); 

        if($userBDD==NULL)
          $user = $userManager->saveUser($user);

        //if($update){
          $user->setId_user($userManager->getUserByIdFb($user->getIdFacebook())->getId_user());
          $userManager->updateUser($user);
        //}

        $_SESSION['idFB'] = $user->getIdFacebook();
      }
      else
        $user = NULL;

      return $user;
  }

  public function logoutAction(){
    unset($_SESSION["ACCESS_TOKEN"]);
    header('Location: '.WEBPATH);
  }


  //Fonction Facebook : soit récupération d'un élèment, soit envoi d'un fichier dans un album photo
  protected function dataApi($callElement = TRUE, $idElement = "/me",$listParam = [], $dataPost = [], $returnDecodedBody = TRUE){
    $string = (is_array($listParam)) ? $idElement.implode(',',$listParam) : $idElement.$listParam;
    //var_dump($string);
    try{
      $response = ($callElement===TRUE) ? $this->fb->get($string,$dataPost) : $this->fb->post($string,$dataPost);
    }
    catch(Facebook\Exceptions\FacebookResponseException $e) {
      //var_dump('ok2');exit;
      //Deconnexion automatique lorsque le token ne serait plus valable
      header('Location: '.WEBPATH.'/index/logout');
    }
    catch(Facebook\Exceptions\FacebookSDKException $e) {
      exit;
      $this->logoutAction();
    }

    if(isset($response))
      return ($returnDecodedBody===TRUE) ? $response->getDecodedBody() : $response->getGraphUser();
    else
      return NULL;
  }



  //Encodage en UTF-8 de tableaux
  public function utf8ize($d) {
      if (is_array($d)) {
          foreach ($d as $k => $v) {
              $d[$k] = $this->utf8ize($v);
          }
      } else if (is_string ($d)) {
          return utf8_encode($d);
      }
      return $d;
  }

  protected function checkWinner(){
    $competitionManager = new competitionManager();
    if(isset($this->competition)){
      $competition = $competitionManager->checkEndOfCompetition($this->competition);
      if($competition){
  
        $participationManager = new participateManager();
        $users = $participationManager->getParticipantsByCompetition($this->competition,3);
  
        //Selection du gagnant
        $winner = $users[0];
        $competition->setActive(2);
        $competition->setId_winner($winner['id_user']);
        $competitionManager->updateCompetition($competition);

        //Envoi d'un message sur le mur de tous les participants
        foreach ($users as $key => $user) {
          $text = [
            'message' =>"Le concours de Pardon Maman est désormais terminé ! Voici la photo du gagnant du concours !",
            'object_attachment' => $winner['id_photo']
          ];
          $idFbPhoto = $this->dataApi(FALSE,'/'.$user['idFacebook']."/feed","",$text);  
        }
        
        //Envoi d'un mail aux admins
        $userManager = new userManager();
        $admins = $this->bringListAdmins();
        foreach ($admins as $key => $admin) {
          $user = $userManager->getUserByIdFb($admin);
          if($user) //Si enregistré dans la liste des utilisateurs de l'application
            $this->envoiMail($user->getEmail(),"Résultat du concours", "Test");
        }
      }
    }
  }

  protected function envoiMail($destinataire, $objet, $contenu){
    // CONFIGURATION DU MAIL

    $adrPHPM = "web/lib/PHPMailer/"; 
    include $adrPHPM."PHPMailerAutoload.php";
    try{
      $mail = new PHPmailer(true); 
      $mail->IsSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->Port = 465;
      $mail->SMTPAuth = true;
      $mail->Username = "pardon.maman.facebook@gmail.com";
      $mail->Password = "Facebook";
      $mail->IsHTML(true); 

      $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
      $mail->SMTPDebug  = 4; 

      //Expediteur (le site)

      $mail->From='pardon.maman.facebook@gmail.com'; 
      $mail->FromName='Administrateur Pardon maman'; 
      $mail->AddReplyTo('pardon.maman.facebook@gmail.com');      
      $mail->AddAddress($destinataire);
      $mail->setFrom('pardon.maman.facebook@gmail.com', 'Administrateur Pardon maman');         
      
      $mail->CharSet='UTF-8';
      $mail->Subject=$objet; 


      $mail->Body=$contenu;

      //  Décommentez pour réactiver le mail
      $erreur = $mail->Send();

      if(isset($erreur) && $erreur){ 
        echo $mail->ErrorInfo; 
      }

      $mail->SmtpClose(); 
      unset($mail);
    }catch(Exception $e){

    }
  }
}