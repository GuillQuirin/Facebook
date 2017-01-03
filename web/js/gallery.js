$(document).ready(function(){
	getContent(1);

	//Tri
	$('select[name="sort"]').change(function(){
		getContent(1);
	});

	//Quantité
	$('select[name="quantity"]').change(function(){
		getContent(1);
	});
});

function getContent(page){
	//Méthode de tri
	var tri = $('select[name="sort"]').val();

	//Méthode de pagination
	var qtty = $('select[name="quantity"]').val();
	var depart = (page-1) * qtty;
	var arrivee = parseInt(depart)+parseInt(qtty);

	$('#gallery').html('<img src="https://upload.wikimedia.org/wikipedia/commons/b/b1/Loading_icon.gif" alt="Chargement" id="loading">');

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

			var nbPages = 1;
			var code = "";
			var i = 0;
			
			$.each(listParticipation,function(){
				if(i>=depart && i<arrivee){
					code += "<div id='"+this.id+"' class='col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-0 col-md-4'>";

						code += "<figure ";
								code += "data-toggle='modal'";
								code += "data-target='#popUpGallery'";
								code += "data-url='"+this.url_photo+"'";
								code += "data-name='"+this.first_name+" "+this.last_name+"'";
								code += "data-like='"+this.url_photo_cleaned+"'";
								code += "data-report='"+this.id+"'";
							code += "style='background-image:url("+this.url_photo+")'>";

								code += "<figcaption>";
									code += '<p class="report col-xs-2 col-sm-2 col-md-2"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6e/VisualEditor_-_Icon_-_Alert.svg/2000px-VisualEditor_-_Icon_-_Alert.svg.png" alt="Signaler"></p>';
									code += '<p class="user text-center col-xs-6 col-sm-6 col-md-6">'+this.first_name+' '+this.last_name+' '+this.nb_likes+'</p>';
									code += '<div class="fb-like col-xs-4 col-sm-4 col-md-4" data-href="'+this.url_photo_cleaned+'" data-layout="button_count" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div>';				
								code += '</figcaption>';

						code += "</figure>";
					code += "</div>";
				}
				i++;
			});
			
			//Mise à jour de la mosaïque
			$('#gallery').html(code);
			FB.XFBML.parse();

			//Pagination
			code = "";
			for(i=1; i<=Math.ceil(listParticipation.length/qtty); i++){
				code += "<li";
					if(i==page) code += " class='active' ";
				code += "><a href='#' onclick='getContent("+i+")'>"+i+"</a></li>";
			}
			$('ul.pagination').html(code);
			
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

function like(){
	/*$('.fb-like').on('click',function(){
		getContent($(".pagination li.active a").text());
	});*/
}

function openModal(){
	$('#popUpGallery').not('figcaption').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget); // Button that triggered the modal

		var modal = $(this);
		modal.find('.modal-name').text(button.data('name'));
		modal.find('.modal-body').css('background-image','url('+button.data("url")+')');
		modal.find('.modal-report img').attr('idImage',button.data('report'));
		modal.find('.modal-like').html('<div class="fb-like" data-href="'+button.data('like')+'" data-layout="box_count" data-action="like" data-size="large" data-show-faces="true" data-share="false"></div>');
		FB.XFBML.parse();
	});
}

function report(){
	//Signalement
	$('.report').on("click",function(){
		if(confirm("Souhaitez-vous vraiment signaler cette image ?")){
			id = ($(this).attr('idImage')==undefined) ? $(this).parent().parent().parent().prop('id') : $(this).attr("idImage"); 
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
			console.log(id);
		}
	});
}