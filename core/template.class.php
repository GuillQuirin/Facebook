<?php
/*
*
*/
class template{
  protected $fb=NULL;
  protected $competition = NULL;

  public function __construct(){
    
    if($this->fb===null){
      require_once __ROOT__.'/web/vendor/autoload.php';      
      //Connexion à l'application enregistrée
      $this->fb = new Facebook\Facebook([
        'app_id' => '1804945786451180',
        'app_secret' => APP_SECRET,
        'default_graph_version' => 'v2.5',
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
      $this->bringDatasUser();
    }
    
    //Renvoi sur la page noCompetition lorsqu'il n'y a pas de concours disponible (si l'utilisateur n'y était pas déjà)
    //if(get_class($this)!="noCompetitionController" && $this->competition===NULL)
     // header('Location: '.WEBPATH.'/noCompetition');

  }

  // Cette methode enverra à la view reçue en parametre les propriétés nécessaires de la Template
  protected function assignConnectedProperties(view $v){
    if($this->fb!==null)
      $v->assign("fb",$this->fb);

    if($this->competition!==NULL)
      $v->assign("competition",$this->competition);
      
    if(isset($_SESSION['ACCESS_TOKEN'])){  
      //Liste des admins
      $admins = $this->dataApi(TRUE,'/app/roles',array(),"1804945786451180|yqj6xWNaG2lUvVv3sfwwRbU5Sjk");
      $listAdmins=[];
      foreach ($admins['data'] as $key => $admin) {
        if($admin['role']=="administrators")
          $listAdmins[] = $admin['user'];
      }
      $v->assign("listAdmins", $listAdmins);
       
      //Infos de l'utilisateur
      $infosUser = ['id','name','first_name','last_name','email','birthday','location'];
      $v->assign("user", $this->dataApi(TRUE,'/me?fields=',$infosUser,"",FALSE));
    }

  }

  //Authentification
  protected function login(view $v){
    $helper = $this->fb->getRedirectLoginHelper();
    $permissions = ['public_profile','email','user_birthday','user_location','publish_actions',
                    'user_posts','user_likes','user_photos','user_friends'];

    $http = (isset($_SERVER['HTTPS'])) ? "https" : "http";          
    $loginUrl = $helper->getLoginUrl($http.'://egl.fbdev.fr'.WEBPATH.'/loginCallback', $permissions);

    $v->assign("urlLoginLogout",$loginUrl);
  }

  //Importation des infos de l'utilisateur depuis Facebook
  protected function bringDatasUser(){
      $listInfosUser = ['id','name','first_name','last_name','email','birthday','location'];
      $infosUser = $this->dataApi(TRUE,'/me?fields=',$listInfosUser,"");
      
      $infosUser['location'] = $infosUser['location']['name'];
      $infosUser['idFacebook'] = $infosUser['id'];
      unset($infosUser['id']);

      $user = new user($infosUser);
      $userManager = new userManager();     
      
      if($userManager->getUserByIdFb($user->getIdFacebook())==NULL)
        $user = $userManager->saveUser($user);

      $_SESSION['idFB'] = $user->getIdFacebook();
      return $user;
  }

  protected function logout(){
    unset($_SESSION["ACCESS_TOKEN"]);
    header("Location: ".WEBPATH);
  }

  //Fonction Facebook : soit récupération d'un élèment, soit envoi d'un fichier dans un album photo
  protected function dataApi($callElement = TRUE, $idElement = "/me",$listParam = [], $dataPost = [], $returnDecodedBody = TRUE){
    $string = (is_array($listParam)) ? $idElement.implode(',',$listParam) : $idElement.$listParam;
    //var_dump($string);
    try{
      $response = ($callElement===TRUE) ? $this->fb->get($string,$dataPost) : $this->fb->post($string,$dataPost);
    }
    catch(Facebook\Exceptions\FacebookResponseException $e) {
      //echo 'Graph returned an error: ' . $e->getMessage();
      //exit;
    }
    catch(Facebook\Exceptions\FacebookSDKException $e) {
      //echo 'Facebook SDK returned an error: ' . $e->getMessage();
      //exit;
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

  /*protected function envoiMail($destinataire, $objet, $contenu){
    // CONFIGURATION DU MAIL

    $adrPHPM = "web/lib/PHPMailer/"; 
    include $adrPHPM."PHPMailerAutoload.php";
    try{
      $mail = new PHPmailer(true); 
      $mail->IsSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->Port = 465;
      $mail->SMTPAuth = true;
      $mail->Username = "breakemall.contact@gmail.com";
      $mail->Password = "EveryAm75";
      $mail->IsHTML(true); 

      $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
      //$mail->SMTPDebug  = 4; 

      //Expediteur (le site)

      $mail->From='breakemall.contact@gmail.com'; 
      $mail->FromName='Administrateur Breakem All'; 
      $mail->AddReplyTo('breakemall.contact@gmail.com');      
      $mail->AddAddress($destinataire);
      $mail->setFrom('breakemall.contact@gmail.com', 'Admin BEA');         
      
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
  */

}