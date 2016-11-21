<?php
/*
*
*/
class template{
  protected $connectedUser = false;
  protected $fb;

  public function __construct(){
    
    require_once __ROOT__.'/web/vendor/autoload.php';
    
    $this->fb = new Facebook\Facebook([
      'app_id' => '1804945786451180',
      'app_secret' => '0071a8a0031dae4539ae78f37d052dae',
      // ELISE
      // 'app_id' => '187377105043014',
      // 'app_secret' => 'f5012f947d16170a87ae80cd59decde2',
      // GUILLAUME
      //'app_id' => '1804945786451180',
      //'app_secret' => '0071a8a0031dae4539ae78f37d052dae',
      'default_graph_version' => 'v2.5',
      'fileUpload' => true
    ]);

    //$this->checkToken();
  }

  protected function logout(){
    unset($_SESSION["ACCESS_TOKEN"]);
    header("Location: ".WEBPATH);
  }

  protected function getConnectedUser(){return $this->connectedUser;}

  /* Cette methode fournira à la view reçue en parametre les propriétés nécessaires à l'affichage d'un user si ce dernier est bien connecté */
  protected function assignConnectedProperties(view $v){
    // var_dump("ASSIGNING CONNECTION PROPS");

    if(!$this->isCookieAccepted()){
      $v->assign("popupCookie", 1);
    }

    if($this->isVisitorConnected()){
      $v->assign("_isConnected", 1);
      $v->assign("_id", $this->connectedUser->getId());
      $v->assign("_name", $this->connectedUser->getName());
      $v->assign("_firstname", $this->connectedUser->getFirstname());

      if(!empty($this->connectedUser->getIdTeam())){
        $teamBBD = new teamManager();
        $arr['id'] = $this->connectedUser->getIdTeam();
        $team = $teamBBD->getTeam($arr);   
        $v->assign("_nameTeam",$team->getName());
      }

      if($this->isAdmin()){
        $v->assign("_isAdmin", 1);
      }
      else
      {
        $v->assign("_isAdmin",0);
      }
    }
  }
  private function isCookieAccepted(){
    if( isset($_COOKIE[AUTORISATION]) && $_COOKIE[AUTORISATION]==1)
      return true;   
    return false;
  }
  public function acceptCookieAction(){
    setcookie(AUTORISATION, 1, time()+(60*60*24*30), "/");
    echo json_encode(["success"=>true]);
    exit;
  }

  protected function isVisitorConnected(){
    return ($this->connectedUser instanceof user);
  }  

  protected function isAdmin(){
    $var = $this->connectedUser->getStatus();
    //var_dump($var);exit;
    if(isset($var) && $var == "3")
      return true;
    return false;
  }  

  protected function checkToken(){
    // var_dump($_SESSION[COOKIE_EMAIL], $_SESSION[COOKIE_TOKEN], $_COOKIE[COOKIE_EMAIL], $_SESSION[COOKIE_TOKEN]);
    
    $args = array(
      COOKIE_EMAIL   => FILTER_VALIDATE_EMAIL,
      COOKIE_TOKEN   => FILTER_SANITIZE_STRING
    );
    $filteredcookies = filter_input_array(INPUT_COOKIE, $args);
    // var_dump($filteredcookies); 
    // var_dump($_SESSION);
    $requiredCookiesReceived = true;
    foreach ($args as $key => $value) {
      if(!isset($filteredcookies[$key])){
        $requiredCookiesReceived = false;
        break;
      };
    };
    if($requiredCookiesReceived){
     if(isset($_SESSION[COOKIE_EMAIL]) && isset($_SESSION[COOKIE_TOKEN])){      
      if(($_SESSION[COOKIE_EMAIL] === $_COOKIE[COOKIE_EMAIL]) && ($_SESSION[COOKIE_TOKEN] === $_COOKIE[COOKIE_TOKEN])){
        // Bien faire attention à bien envoyer un array en parametre constructeur de user
        $user = new user(['email' => $_SESSION[COOKIE_EMAIL]]);

        // on met à jour la derniere heure de connexion
        $user->setLastConnexion(time());
        
        $dbUser = new userManager();
        $this->connectedUser = $dbUser->validTokenConnect($user);
        
        unset($dbUser, $user);
      }
      else{
        setcookie(COOKIE_TOKEN, null, -1, "/");
        setcookie(COOKIE_EMAIL, null, -1, "/");
      }        
     };
    };
  }

  public function connectionAction(){
    $args = array(
          'email'   => FILTER_VALIDATE_EMAIL,
          'password'   => FILTER_SANITIZE_STRING 
    );
    $filteredinputs = filter_input_array(INPUT_POST, $args);

    // Array final à encoder en json
    $data = [];

    $requiredInputsReceived = true;
    foreach ($args as $key => $value) {
      if(!isset($filteredinputs[$key])){
        $requiredInputsReceived = false;        
        $this->echoJSONerror("inputs","missing input " . $key);
      }
    }

    if($requiredInputsReceived){
      $userManager = new userManager();
      $user = new user($filteredinputs);
      $dbUser = $userManager->tryConnect($user);

      if($dbUser instanceof user){
        // définition du token
        $time = time();
        $expiration = $time + (86400 * 7);
        $token = md5($dbUser->getId().$dbUser->getPseudo().$dbUser->getEmail().SALT.$time);
        $_SESSION[COOKIE_TOKEN] = $token;
        $_SESSION[COOKIE_EMAIL] = $dbUser->getEmail();
        $_SESSION['timeout'] = $expiration;
        setcookie(COOKIE_TOKEN, $token, $expiration, "/");
        setcookie(COOKIE_EMAIL, $dbUser->getEmail(), $expiration, "/");
        $data["connected"] = true;
        $this->connectedUser = $dbUser;
      }
      else if($dbUser === 0){
        $this->echoJSONerror("", "Vous devez valider votre compte à l'aide de l'email de confirmation.");
      }
      else if($dbUser == -1){
        $this->echoJSONerror("", "Vous avez été banni du site.");
      }
      else if($dbUser == -2){
        $this->echoJSONerror("", "Identifiants incorrects");
      }
      else{
       $this->echoJSONerror("", "Vos identifiants ne correspondent pas.");
      }

    }

    echo json_encode($data);
  }

  public function deconnectionAction(){
    $dbUser = new userManager();
    if($this->isVisitorConnected()){
      $this->connectedUser->setIsConnected(0);
      $this->connectedUser->setLastConnexion(time());

      $dbUser->disconnecting($this->connectedUser);

      setcookie(COOKIE_TOKEN, null, -1, "/");
      setcookie(COOKIE_EMAIL, null, -1, "/");
      session_destroy();
      echo json_encode(["connected" => false]);
    }
    // exit;
  }

  protected function echoJSONerror($name = '', $msg){
    if(strlen(trim($name)) > 0)
      $name = $name .' : ';
    
    $data['errors'] = $name.$msg;
    echo json_encode($data);
    flush();
    exit;
  }

  protected function envoiMail($destinataire, $objet, $contenu){
    /* CONFIGURATION DU MAIL*/

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
}


/*  
*
*/