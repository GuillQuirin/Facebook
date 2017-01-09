$(document).ready(function(){
	getContent();

	//Tri
	$('select[name="sort"]').change(function(){
		getContent();
	});

	//Quantité
	$('select[name="quantity"]').change(function(){
		getContent();
	});




	var listOfScope = [];
	var listOfScopeGrantedNow = [];
	var maxRerequestScope = 1;
	var numberRerequestScope = 0;
	var reloadPage = false;

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
	}

	//Check des autorisations pour les infos manquantes en BDD
	$('.errorSend a').click(function(){
		listOfScope.push("public_profile");
		numberRerequestScope = 0;
		FB.getLoginStatus(function(response) {
		  statusChangeCallback(response);
		});
		return false;
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
      var error = false;

      FB.api('/me/permissions', function(response) {

        response.data.forEach(function(permission){
          	if(permission.status == "granted"){
            	listOfScopeGrantedNow.push(permission.permission);

	            //Si ancienne permission PHOTO ou POST bloquée alors on reload la page
    	        if((permission.permission=="public_profile") 
            			&& $.inArray(permission.permission, listOfScope)!==-1)
        	    	reload = true;
          	}
        });

        listOfScope.forEach(function(permissionAsking){
          if( $.inArray(permissionAsking, listOfScopeGrantedNow) == -1 )
          {
            //console.log("Il manque des permissions : "+permissionAsking);
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
          //console.log(arguments);
          callback(values);
        }

        return !error;
      });
    }

    function testAPI(response) {
      	//console.log("Access token : "+response.authResponse.accessToken);
      	//console.log("User id : "+response.authResponse.userID);
    	FB.api('/me', function(response) {
	        
	        $.ajax({
	          method: "POST",
	          url: $('[name="webpath"]').val()+"/index/reupdateUser"
	        });

	        if(reload)
	        	location.reload();

	       // console.log('Successful login for: ' + response.name);
	    });
    }
});



function getContent(){
	//Méthode de tri
	var tri = $('select[name="sort"]').val();
	var qtty = $('select[name="quantity"]').val();
	$('#gallery').html('<img src="facebook.gif" alt="Chargement" id="loading">');

	$.ajax({method: "POST",
		data:{
			tri : tri
		},
		url: "gallery/getGallery", 
		success: function(result){

			$("#loading").remove();

			//Tri par like décroissant
			var listParticipation = JSON.parse(result);
			if($('select[name="sort"]').val()=="3"){
				listParticipation.sort(function(a, b) {
				    return parseInt(b.nb_likes) - parseInt(a.nb_likes);
				});
			}

			var code = "";
			$.each(listParticipation,function(){
				code += "<div id='"+this.id_participate+"'>";
					code += "<figure ";
							code += "data-toggle='modal'";
							code += "data-target='#popUpGallery'";
							code += "data-url='"+this.url_photo+"'";
							code += "data-name='"+this.first_name+" "+this.last_name+"'";
							code += "data-like='"+this.id_participate+"'";
							code += "data-report='"+this.id_participate+"'";
						code += "style='background-image:url("+this.url_photo+")'>";

							code += "<figcaption>";
								code += '<span class="nb_likes">'+this.nb_likes+'</span>';
								code += '<p class="report col-xs-2 col-sm-2 col-md-2"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6e/VisualEditor_-_Icon_-_Alert.svg/2000px-VisualEditor_-_Icon_-_Alert.svg.png" alt="Signaler"></p>';
								code += '<p class="user text-center col-xs-6 col-sm-6 col-md-6">'+this.first_name+' '+this.last_name+'</p>';			
								if(this.is_liked==0)
									code += '<p class="col-xs-2 col-sm-2 col-md-2 like"></p>';
							code += '</figcaption>';

					code += "</figure>";
				code += "</div>";
			});
			//Mise à jour de la mosaïque
			$('#gallery').html(code);
			
			//Pagination de départ
			getPage(1);
			
			//Appel du code pour signaler APRES le load du contenu ajax
			openModal();
			report();
			like();
		},
		fail: function(){
			console.log('Pas OK');
		}
	});
}

function getPage(page){
	//Récupération du contenu selon la page selectionnée
	var qtty = $('select[name="quantity"]').val();
	var depart = (page-1) * qtty;
	var arrivee = parseInt(depart)+parseInt(qtty);
	var i=0;

	$('#gallery>div').each(function(){
		if(i>=depart && i<arrivee)
			$(this).removeClass( "hidden-xs hidden-sm hidden-md" ).addClass('col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-0 col-md-4');
		else
			$(this).removeClass("col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-0 col-md-4").addClass('hidden-xs hidden-sm hidden-md');
		i++;
	});
	creationPagination($('#gallery>div').length,page);
}

function creationPagination(nbElements,idActive){
	//Conception du menu de pagination
	var i = 0;
	var qtty = $('select[name="quantity"]').val();
	code = "";
	for(i=1; i<=Math.ceil(nbElements/qtty); i++){
		code += "<li";
			if(i==idActive) code += " class='active' ";
		code += "><a href='#' onclick='getPage("+i+")'>"+i+"</a></li>";
	}
	$('ul.pagination').html(code);
}

function like(){
	$('.like').click(function(){
		var img = $(this).parent().parent().parent();
		$.ajax({method: "POST",
			data:{
				id_participate : img.prop('id')
			},
			url: "gallery/addLike", 
			success: function(result){
				var vote = JSON.parse(result);
				img.find('.nb_likes').html(vote);
				img.find('.like').fadeOut();
			}
		});
		return false;
	});
}

function openModal(){
	$('#popUpGallery').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal

		var modal = $(this);
		modal.find('.modal-name').text(button.data('name'));
		modal.find('.modal-body').css('background-image','url('+button.data("url")+')');
		modal.find('.modal-report img').attr('idimage',button.data('report'));
	});
}

function report(){
	//Signalement
	$('.report img').on("click",function(){
		if(confirm("Souhaitez-vous vraiment signaler cette image ?")){
			id = ($(this).attr('idimage')==undefined) ? $(this).parent().parent().parent().prop('id') : $(this).attr('idimage'); 
			$.ajax({method: "POST",
				data:{
					id : id
				},
				url: "gallery/report", 
				success: function(result){
					//console.log(result);
					$("#"+id+" .report").addClass("reportSent").html("Signalement envoyé.");
				}
			});
		}
		return false;
	});
}