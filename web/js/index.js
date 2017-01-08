$(document).ready(function(){
	//Flèches vers le haut
	$('.backTop').click(function(){
		$('html, body').animate({
			scrollTop: $(".listPictures").offset().top-100
		}, 100);
	});

	//Volet déroulant
	$('.panel-heading').click(function(){
		$('.panel-heading').not(this).parent().parent().removeClass("col-md-10").removeClass("col-md-offset-1").addClass("col-md-6").addClass("col-md-offset-3");
		var panelDefault = $(this).parent().parent();

		panelDefault.toggleClass("col-md-10",5000);
		panelDefault.toggleClass("col-md-6",5000);
		panelDefault.toggleClass("col-md-offset-3",5000);
		panelDefault.toggleClass("col-md-offset-1",5000);
	});

	//Check de la taille de l'image avant envoi
	$('#localForm').submit(function(){
		$('.pbFileSize').slideUp();

		var result = true;
	    if(window.File && window.FileReader && window.FileList && window.Blob){
	    	if($('#i_file')[0].files[0].size > 10485760){ //10Mo
	    		$('.pbFileSize').slideDown();
	    		result = false;
	    	}
			
			//Affichage des erreurs
	    	if(!controlDatas('.errorUpload'))
	    		result = false;
	    }
	    else{
	        alert("Veuillez mettre à jour votre navigateur Internet afin de pouvoir accèder au concours.");
	    	result = false;
	    }
	    
	    return result;
	});

	//Affichage des erreurs
	$('.onlineForm').submit(function(){
		controlDatas('.errorSend');
		return false;
	});

	//Ouverture d'une pop-up image
	$('img').click(function(){
		$('.errorSend, .errorUpload').hide();
	});


	var listOfScope = [];
	var maxRerequestScope = 3;
	var numberRerequestScope = 0;

	//Check des autorisations utilisateur
	function controlDatas(classError){
		$(classError+' .listError').html('');

		$.ajax({
          method: "GET",
          url: $('[name="webpath"]').val()+"/index/checkUser"
        })
          .done(function( msg ){
            var resultUser = JSON.parse(msg);
        	$(classError).show();
            $.each(resultUser,function(index, value){
            	$(classError+' .listError').append('<li>'+value+'</li>');
            	listOfScope.push(index);
            });
          });
          return false;
	}



	$('.errorSend a').click(function(){
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

		    console.log(listOfScope);
		  	FB.getLoginStatus(function(response) {
		  	  statusChangeCallback(response);
		  	});
	  	};
		return false;
	});

	/*********************** */

   	function checkLoginState() {
      FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
      });
    }

  	function statusChangeCallback(response) {
      console.log(response);

      if(response.status === 'connected') // Logged into your app and Facebook.
        verifyScope(testAPI, response);
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
        	//AskScope again
          	if(numberRerequestScope < maxRerequestScope){
	       		FB.login(function(response){
	            	verifyScope(testAPI, response);
	        	}, {scope: listOfScope.join(), auth_type: 'rerequest'} );

	        	numberRerequestScope++;
	    	}
        }
        else{
          console.log(arguments);
          callback(values);
        }

        return !error;
      });
    }

    function testAPI(response) {
      	console.log("Access token : "+response.authResponse.accessToken);
      	console.log("User id : "+response.authResponse.userID);
    	FB.api('/me', function(response) {
	        console.log(response);
	        console.log('Successful login for: ' + response.name);
	    });
    }
});