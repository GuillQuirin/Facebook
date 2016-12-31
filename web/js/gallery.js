$(document).ready(function(){
	$('#gallery').ready(function(){
		getContent();
	});

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
	$("#loading").show();
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
				code += "<div class='col-md-4'>";
					code += "<figure>";
						code += "<img class='img-thumbnail' src='"+this.url_photo+"'>";
						code += "<figcaption>";
							code += '<button>Signaler</button>';
							code += this.first_name+' '+this.last_name;
							code += this.nb_likes;
							code += '<div class="fb-like" data-href="https://developers.facebook.com/docs/plugins/" data-layout="standard" data-action="like" data-show-faces="true"></div>'
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

function getContentByLikes(){

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