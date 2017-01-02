$(document).ready(function(){
	getContent();

	//Tri
	$('select[name="sort"]').change(function(){
		getContent();
	});

	//Pagination
	/*$('select[name="sort"]').change(function(){
		getContent(1);
	});*/
});

function getContent(){
	//Méthode de tri
	var tri = $('select[name="sort"]').val();
	$('#gallery').html('<img src="https://upload.wikimedia.org/wikipedia/commons/b/b1/Loading_icon.gif" alt="Chargement" id="loading">');

	setTimeout(function(){
			$.ajax({method: "POST",
				data:{
					tri : tri
				},
				url: "gallery/getGallery", 
				success: function(result){
					var listParticipation = JSON.parse(result);
					
					//Tri par like décroissant
					if($('select[name="sort"]').val()=="3"){
						listParticipation.sort(function(a, b) {
						    return parseInt(b.nb_likes) - parseInt(a.nb_likes);
						});
					}

					var code = "";
					$("#loading").hide();
					$.each(listParticipation,function(){
						code += "<div id='"+this.id+"' class='col-xs-12 col-sm-6 col-md-4'>";
							code += "<figure>";
								code += "<img class='img-thumbnail' src='"+this.url_photo+"'>";
								code += "<figcaption>";
									code += '<p class="report col-xs-2 col-sm-2 col-md-2"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6e/VisualEditor_-_Icon_-_Alert.svg/2000px-VisualEditor_-_Icon_-_Alert.svg.png" alt="Signaler"></p>';
									code += '<p class="user text-center col-xs-6 col-sm-6 col-md-6">'+this.first_name+' '+this.last_name+' '+this.nb_likes+'</p>';
									code += '<div class="fb-like col-xs-4 col-sm-4 col-md-4" data-href="'+this.url_photo_cleaned+'" data-layout="button_count" data-action="like" data-size="large" data-show-faces="false" data-share="false"></div>';				
								code += '</figcaption>';
							code += "</figure>";
						code += "</div>";
					});
					$('#gallery').html(code);
					FB.XFBML.parse();
					//dispPagination();
					//Appel du code pour signaler APRES le load du contenu ajax
					report();
					like();
				},
				fail: function(){
					console.log('Pas OK');
				}
			});
		}, 1000);
}

function like(){
	$('.fb-like').on('click',function(){
		getContent();
	});
}


function report(){
	//Signalement
	$('.report').on("click",function(){
		if(confirm("Souhaitez-vous vraiment signaler cette image ?")){
			id = $(this).parent().parent().parent().prop('id'); 
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
	});
}

	/*
		foreach($listParticipation as $key => $participation){
		$result .= '<div class="col-md-3">';
			$result .= '<div class="thumbnail">';
				$result .= '<img src="'.$participation->getUrl_photo().'" alt="Photo de concours">';
				$result .= '<div class="caption">';
					$result .= '<p>123 likes</p>';
				$result .= '</div>';
			$result .= '</div>';
		$result .= '</div>';
		}
	*/