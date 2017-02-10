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
	    }
	    else{
	        alert("Veuillez mettre à jour votre navigateur Internet afin de pouvoir accèder au concours.");
	    	result = false;
	    }
	    
	    return result;
	});

	//Affichage des erreurs
	$('.onlineForm').submit(function(){
		//controlDatas('.errorSend');
		//return false;
	});

	//Ouverture d'une pop-up image
	$('img').click(function(){
		$('.errorSend, .errorUpload').hide();
	});





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
		    version    : 'v2.8' // use graph api version 2.5
		});
	};

    $("#login").click(function(){
		FB.login(function(response){
			statusChangeCallback(response);
			reload=true;
		}, {scope: 'email,user_location,publish_actions'});
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

  	$(".publish_autorization").click(function(event){
  		event.preventDefault();
  		numberRerequestScope = 0;

		if($.inArray("publish_actions",listOfScope) == -1)
			listOfScope.push('publish_actions');

		checkLoginState();
		return false;
  	});

	//Check des autorisations pour les infos manquantes en BDD
	$('.errorSend a').click(function(){
		numberRerequestScope = 0;
		checkLoginState();
		return false;
	});

	//Check de l'autorisation de récupération des albums
	$('.getPhotos').click(function(){
		numberRerequestScope = 0;

		if($.inArray("user_photos",listOfScope) == -1)
			listOfScope.push('user_photos');

		checkLoginState();
	});

	//Check de l'autorisation de publication des photos
	$('.postPhotos').click(function(event){
		event.preventDefault();
		numberRerequestScope = 0;

		if($.inArray("publish_actions",listOfScope) == -1)
			listOfScope.push('publish_actions');

		checkLoginState();
		return false;
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
            	$(classError+' .listError').append('<li>'+value+'</li>');
            	listOfScope.push(index);
            });
          });
          return false;
	}

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
	          	console.log(result);
	          	if(($('#isConnected').val()==0 || reload) && !error)
			    	location.reload();
	          }
	        });	        	
	    });
    }
});