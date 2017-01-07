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

	    if (window.File && window.FileReader && window.FileList && window.Blob){
	    	if($('#i_file')[0].files[0].size < 10485760 && controlDatas()) //10Mo
	    		return true;
	    	else
	    		$('.pbFileSize').slideDown();
	    }
	    else
	        alert("Please upgrade your browser, because your current browser lacks some new features we need!");
	    
	    return false;
	});

	$('.onlineForm').submit(function(){
		controlDatas();
		return false;
	});

	//Check des infos utilisateur avant envoi
	function controlDatas(){
		$.ajax({
          method: "GET",
          url: $('[name="webpath"]').val()+"/index/checkUser"
        })
          .done(function( msg ){
            var resultUser = JSON.parse(msg);
            $('.modal-footer').append("Certaines informations manquent pour finaliser votre participation:");
            $.each(resultUser,function(index, value){
            	$('.modal-footer').append(value);
            });
            return false;
          });
	}
});