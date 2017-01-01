$(document).ready(function(){
	getContent();

	//Tri
	$('select[name="sort"]').change(function(){
		if($(this).val()!="3")
			getContent();
		else
			getContentByLikes();
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
	$.ajax({method: "POST",
		data:{
			tri : tri
		},
		url: "gallery/getGallery", 
		success: function(result){
			var listParticipation = JSON.parse(result);
			var code = "";
			//console.log(listParticipation);
			$("#loading").hide();
			$.each(listParticipation,function(){
				code += "<div id='"+this.id+"' class='col-md-4'>";
					code += "<figure>";
						code += "<img class='img-thumbnail' src='"+this.url_photo+"'>";
						code += "<figcaption>";
							code += '<p class="col-md-2 report"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/6/6e/VisualEditor_-_Icon_-_Alert.svg/2000px-VisualEditor_-_Icon_-_Alert.svg.png" alt="Signaler"></p>';
							code += '<p class="user col-md-5">'+this.first_name+' '+this.last_name+' '+this.nb_likes+'</p>';
							//code += '<div class="col-md-4 fb-like" data-href="'+this.url_photo+'" data-layout="button_count" data-action="like" data-size="large" data-show-faces="false" data-share="false"></div>'
							code += '<iframe class="fb-like col-md-5" src="https://www.facebook.com/plugins/like.php?href='+this.url_photo_cleaned+'&layout=button_count&action=like&size=large&show_faces=false&share=false&appId=1804945786451180" height="30" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>';
						code += '</figcaption>';
					code += "</figure>";
				code += "</div>";
			});
			$('#gallery').html(code);
			//Appel du code pour signaler APRES le load du contenu ajax
			report();
			like();
		},
		fail: function(){
			console.log('Pas OK');
		}
	});

function getContentByLikes(){

}

function like(){
	$('.fb-like *').click(function(){
		$(this).hide();
		//getContent();
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
}