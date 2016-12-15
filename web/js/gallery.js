$(document).ready(function(){
	$('#gallery').ready(function(){
		getContent();
	});

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
	$.ajax({method: "POST",
		data:{
			tri : tri
		},
		url: "gallery/getGallery", 
		success: function(result){
			var listParticipation = JSON.parse(result);
			var code = "";
			//console.log(listParticipation);
			$.each(listParticipation,function(){
				code += "<div class='col-md-3'>";
					code += "<figure>";
						code += "<img class='img-thumbnail' src='"+this.url_photo+"'>";
						code += "<figcaption>";
							code += '<div class="fb-like" data-href="'+this.url_photo+'" data-layout="button_count" data-action="like" data-size="large" data-show-faces="false" data-share="false"></div>';
						code += '</figcaption>';
					code += "</figure>";
				code += "</div>";
			});
			$('#gallery').html(code);
		},
		fail: function(){
			console.log('Pas OK');
		}
	});

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