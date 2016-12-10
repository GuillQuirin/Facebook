<?php
/*
*
*/
class template{
  protected $connectedUser = false;
  protected $fb=false;
  protected $competition = NULL;

  public function __construct(){
    
    //Recherche d'un concours ouvert au public
    $competitionManager = new competitionManager();
    $this->competition = $competitionManager->searchCompetitions();
    
    if($this->competition!==NULL){ //Un concours est actif

      require_once __ROOT__.'/web/vendor/autoload.php';
      
      //Connexion à l'application enregistrée
      $this->fb = new Facebook\Facebook([
        'app_id' => '1804945786451180',
        'app_secret' => APP_SECRET,
        'default_graph_version' => 'v2.5',
        'fileUpload' => true
      ]);
      //Session ouverte sur 2 heures
      if(isset($_SESSION['ACCESS_TOKEN']))
        //$this->fb->setDefaultAccessToken($_SESSION["LONG_ACCESS_TOKEN"]); //60 jours
        $this->fb->setDefaultAccessToken($_SESSION["ACCESS_TOKEN"]);
    }
    else //Pas de concours ouverts actuellement
      header('Location: '.WEBPATH.'/noCompetition');
  }

  // Cette methode enverra à la view reçue en parametre les propriétés nécessaires de la Template
  protected function assignConnectedProperties(view $v){
    if($this->fb!==false)
      $v->assign("fb",$this->fb);

    if($this->competition!==NULL)
      $v->assign("competition",$this->competition);
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

  protected function logout(){
    unset($_SESSION["ACCESS_TOKEN"]);
    header("Location: ".WEBPATH);
  }

  //Fonction Facebook : soit récupération d'un élèment, soit envoi d'un fichier dans un album photo
  protected function dataApi($callElement = TRUE, $idElement = "me",$listParam = [], $dataPost = [], $returnDecodedBody = TRUE){
    $string = (is_array($listParam)) ? $idElement.implode(',',$listParam) : $idElement.$listParam;

    try{
      $response = ($callElement===TRUE) ? $this->fb->get($string,$dataPost) : $this->fb->post($string,$dataPost);
    }
    catch(Facebook\Exceptions\FacebookResponseException $e) {
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
    }
    catch(Facebook\Exceptions\FacebookSDKException $e) {
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
    }
    return ($returnDecodedBody===TRUE) ? $response->getDecodedBody() : $response->getGraphUser();
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


/*  
*
*/