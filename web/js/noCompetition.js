$(document).ready(function(){
  var listOfScope = [];
  var listOfScopeGrantedNow = [];
  var maxRerequestScope = 1;
  var numberRerequestScope = 0;
  var reload = false;
  var error = false;

  //Initialisation de la connexion à FB en JS pour affichage des pop-up de droits
  (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/fr_FR/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

  window.fbAsyncInit = function() {
    FB.init({
        appId      : '1804945786451180',
        cookie     : true,  // enable cookies to allow the server to access 
                            // the session
        xfbml      : true,  // parse social plugins on this page
        version    : 'v2.5' // use graph api version 2.5
    });
  };

    $("#login").click(function(){
    FB.login(function(response){
      statusChangeCallback(response);
      reload=true;
    });
    });

    $("#logout").click(function(){
      $.ajax({
          method: "POST",
          url: $('[name="webpath"]').val()+"/index/logout",
          success: function(result){
          location.reload();
          }
        });  
    });

  /************************/

  function checkLoginState() {
      FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
      });
    }

    function statusChangeCallback(response) {
      if(response.status === 'connected') // Logged into your app and Facebook.
        verifyScope(testAPI, response);
    }


    function verifyScope(callback, values){
      error = false;

      FB.api('/me/permissions', function(response) {

        response.data.forEach(function(permission){
            if(permission.status == "granted"){
              listOfScopeGrantedNow.push(permission.permission);

              //Si ancienne permission PHOTO ou POST bloquée alors on reload la page
              if((permission.permission=="user_photos" || permission.permission=="publish_actions" || permission.permission=="public_profile") 
                  && $.inArray(permission.permission, listOfScope)!==-1)
                reload = true;
            }
        });

        listOfScope.forEach(function(permissionAsking){
          if($.inArray(permissionAsking, listOfScopeGrantedNow) == -1)
          {
            console.log("Il manque des permissions : "+permissionAsking);
            error = true;
          }
        })
     
        if(error){
          //AskScope again
            if(numberRerequestScope < maxRerequestScope){
            FB.login(function(response){
                verifyScope(testAPI, response);
            }, {scope: listOfScope.join(), auth_type: 'rerequest'} );

            numberRerequestScope++;
        }
        }
        else
          callback(values);

        return !error;
      });
    }

    function testAPI(response) {
        var infosApi = response.authResponse;
      FB.api('/me', function(response){
          $.ajax({
            method: "POST",
            data:{
              infosApi: infosApi
            },
            url: $('[name="webpath"]').val()+"/index/reupdateUser",
            success: function(result){
              //console.log(result);
              if(($('#isConnected').val()==0 || reload) && !error)
            location.reload();
            }
          });           
      });
    }
});