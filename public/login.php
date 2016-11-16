<?php 
	session_start();
	require_once __DIR__."/vendor/autoload.php"; 

	$fb = new Facebook\Facebook([
	  'app_id' => '1804945786451180',
	  'app_secret' => '0071a8a0031dae4539ae78f37d052dae',
	  'default_graph_version' => 'v2.5',
	]);

	$helper = $fb->getRedirectLoginHelper();
	$scope = ['email', 'user_likes'];
	$loginUrl = $helper->getLoginUrl('http://egl.fbdev.fr/Facebook/public/login-callback.php', $scope);
?>

<!DOCTYPE html>
<html>
<head>
	<title>Se connecter à FB</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

	<script src="js/script.js"></script>
	<script>
		/*	 
		   function checkLoginState() {
		      FB.getLoginStatus(function(response) {
		        statusChangeCallback(response);
		      });
		    }
		 
		  function statusChangeCallback(response) {
		      console.log('statusChangeCallback');
		      console.log(response);
		      // The response object is returned with a status field that lets the
		      // app know the current login status of the person.
		      // Full docs on the response object can be found in the documentation
		      // for FB.getLoginStatus().
		      if (response.status === 'connected') {
		        // Logged into your app and Facebook.
		        verifyScope(testAPI, response);
		 
		      } else if (response.status === 'not_authorized') {
		        // The person is logged into Facebook, but not your app.
		        document.getElementById('status').innerHTML = 'Please log ' +
		          'into this app.';
		        $("#subscribe").show();
		        $("#disconnect").hide();
		      } else {
		        // The person is not logged into Facebook, so we're not sure if
		        // they are logged into this app or not.
		        document.getElementById('status').innerHTML = 'Please log ' +
		          'into Facebook.';
		        $("#subscribe").show();
		        $("#disconnect").hide();
		      }
		  }
		 
		 
		    function verifyScope(callback, values){
		 
		      var listOfScopeGrantedNow = [];
		      var error = false;
		 
		      FB.api('/me/permissions', function(response) {
		 
		        response.data.forEach(function(permission){
		          if(permission.status == "granted"){
		            listOfScopeGrantedNow.push(permission.permission);
		          }
		        });
		       
		        listOfScope.forEach(function(permissionAsking){
		          if( $.inArray(permissionAsking, listOfScopeGrantedNow) == -1 )
		          {
		            console.log("Il manque des permissions : "+permissionAsking);
		            error = true;
		          }
		        })
		     
		        if(error){
		          $("#subscribe").show();
		          $("#disconnect").hide();
		          askScopeAgain();
		        }else{
		          $("#subscribe").hide();
		          $("#disconnect").show();
		          console.log(arguments);
		          callback(values);
		        }
		 
		        return !error;
		      });
		    }
		 
		    function askScopeAgain(){
		 
		      if(numberRerequestScope < maxRerequestScope){
		       
		        FB.login(function(response){
		            verifyScope(testAPI, response);
		        }, {scope: listOfScope.join(), auth_type: 'rerequest'} );
		 
		        numberRerequestScope++;
		      }
		 
		    }
		 
		    function testAPI(response) {
		      console.log(response);
		      console.log('Welcome!  Fetching your information.... ');
		      console.log("Access token : "+response.authResponse.accessToken);
		      console.log("User id : "+response.authResponse.userID);
		   
		      FB.api('/me', function(response) {
		        console.log('Successful login for: ' + response.name);
		        document.getElementById('status').innerHTML =
		          'Thanks for logging in, ' + response.name +" "+ response.email + '!';
		      });
		     
		    }
		 
		  $("#subscribe").click(function(){
		    numberRerequestScope = 0;
		    FB.login(function(response){
		      statusChangeCallback(response);
		    }, {scope: listOfScope.join()});
		 
		  });
		 
		 
		  $("#disconnect").click(function(){
		      FB.logout(function(response) {
		        statusChangeCallback(response);
		      });
		  });
		 
		});
		*/
			$(document).ready(function(){
			
				var listOfScope = ['public_profile','email'];
			    var maxRerequestScope = 2;
			    var numberRerequestScope = 0;
			  
			    // Load the SDK asynchronously
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

				  	FB.getLoginStatus(function(response) {
				      statusChangeCallback(response);
				    });

				};
		
			    FB.getLoginStatus(function(response) {
			      statusChangeCallback(response);
			    });

			    $("#suscribe, #login").click(function(){
					FB.login(function(response){
						statusChangeCallback(response);
					});
			  	});
			  	$("#logout").click(function(){
			  		FB.logout(function(response){
						statusChangeCallback(response);
					});
			  	})

			});

				function checkLoginState(){
					FB.getLoginStatus(function(response) {
				      statusChangeCallback(response);
				    });
				}

				function statusChangeCallback(response) {
				    console.log('Statut:');
				    console.log(response);
				    // for FB.getLoginStatus().
				    if (response.status === 'connected') {
				      // Logged into your app and Facebook.
				      $('#suscribe').hide();
				      $('#logout').show();
				      $('#login').hide();
				      testAPI(response);
				    } else if (response.status === 'not_authorized') {
				      // The person is logged into Facebook, but not your app.
				      document.getElementById('status').innerHTML = 'Please log ' +
				        'into this app.';
				    } else {
				      // The person is not logged into Facebook, so we're not sure if
				      // they are logged into this app or not.
				      document.getElementById('status').innerHTML = 'Please log ' +
				        'into Facebook.';
				       $('#suscribe').show();
				       $('#logout').hide();
				       $('#login').show();
				    }
				}
			    function testAPI(response) {
			    	console.log('Welcome!  Fetching your information.... ');
			    	console.log("Access token: "+response.authResponse.accessToken);
			    	console.log("User ID: "+response.authResponse.userID);
				    FB.api('/me', function(response) {
				      console.log('Successful login for: ' + response.name);
				      document.getElementById('status').innerHTML =
				        'Thanks for logging in, ' + response.name + '!';
				    });
				}

				function verifyScope(callback, values){
					FB.api('/me/permissions',function(response){
						var error = false;
						//On vérifie qu'il y a le bon nom de permissions ou plus
						if(listeScope.length > response.data.length){
							console.log('Il manque des permissions');
							error = true;
						}
						else{
							response.data.forEach(function(permissions){
								if($.inArray(permission.permission, listeScope) = -1){
									console.log('Les permissions ne correspondent pas: '+permission.permission);
									error = true;
								}else if(permissions.status == "declined"){
									console.log(permission.permission+" -> "+permission.status);
									error = true;
								}
							});
						}

						if(error){
							$('#suscribe').show();
							$('#logout').hide();
							askScopeAgain();
						}else{
							$("#suscribe").hide();
							$('#logout').show();
							callback(values);
						}
						
					});
				}
	</script>
</head>
<body>
	<h1>Facebook</h1>
	<!-- scope: infos recuperees de l'utilisateur-->
	<!-- <fb:login-button scope="public_profile,email" id="login" onlogin="checkLoginState();"></fb:login-button> -->
	<div id="status"></div>
	<button id="suscribe">S'inscrire</button>
	<button id="logout">Se déconnecter</button>
</body>
</html>