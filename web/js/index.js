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
		console.log(controlDatas('.errorSend'));
		return false;
	});

	//Ouverture d'une pop-up image
	$('img').click(function(){
		$('.errorSend, .errorUpload').hide();
	});

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
            	$(classError+' .listError').append('<li>'+index+': '+value+'</li>');
            });
            //$('.errorSend a').attr('href',resultUser.url);
            console.log(resultUser.url);
            return false;
            return (resultUser.length==0);
          });
          return false;
	}

	var listOfScope = ['user_birthday','user_location','public_profile','email'];
	var maxRerequestScope = 2;
	var numberRerequestScope = 0;

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
	        console.log(response);
	        console.log('Successful login for: ' + response.name);
	        document.getElementById('status').innerHTML =
	          'Thanks for logging in, ' + response.name + '!';
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