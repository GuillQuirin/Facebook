<?php
/*
*
*/
class template{
  protected $connectedUser = false;
  protected $fb=false;

  public function __construct(){
    
    //Recherche d'un concours ouvert au public
    $competition = searchCompetitions();
    
    if($competition!==NULL){ //Un concours est actif

      require_once __ROOT__.'/web/vendor/autoload.php';
      
      //Connexion à l'application enregistrée
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
      
      //Session ouverte sur 3 mois ou non
      if(isset($_SESSION['ACCESS_TOKEN']))
        //$this->fb->setDefaultAccessToken($_SESSION["LONG_ACCESS_TOKEN"]);
        $this->fb->setDefaultAccessToken($_SESSION["ACCESS_TOKEN"]);
    }
    else //Pas de concours ouverts actuellement
      header('Location: '.WEBPATH.'/noCompetition');
  }

  protected function login(view $v){
    $helper = $this->fb->getRedirectLoginHelper();
    $permissions = ['email','publish_actions',
                    'user_posts','user_likes','user_photos','user_friends',
                    'pages_show_list','manage_pages','pages_manage_cta','publish_pages'];
          
    $loginUrl = (isset($_SERVER['HTTPS'])) ? 
          $helper->getLoginUrl('https://egl.fbdev.fr'.WEBPATH.'/loginCallback', $permissions)
          : $helper->getLoginUrl('http://egl.fbdev.fr'.WEBPATH.'/loginCallback', $permissions);

    $button = (isset($_SESSION['ACCESS_TOKEN'])) ? "<a href='".WEBPATH."/logout'><button>Se déconnecter</button></a>" 
                                                 : "<a href='".$loginUrl."'><button>Se connecter</button></a>";
    $v->assign("urlLoginLogout",$button);
  }

  protected function logout(){
    unset($_SESSION["ACCESS_TOKEN"]);
    header("Location: ".WEBPATH);
  }


  /* Cette methode fournira à la view reçue en parametre les propriétés nécessaires de la classe-mère template */
  protected function assignConnectedProperties(view $v){
    if($this->fb!==false)
      $v->assign("fb",$this->fb);
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