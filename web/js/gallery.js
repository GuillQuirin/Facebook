$(document).ready(function(){
	$('#gallery').ready(function(){
		getContent(1);
	});
});

function getContent(page){
	var url = $('#url').val();
	$.ajax({method: "GET",
		/*data:{
			page : page
		},*/
		url: "gallery/getGallery", 
		success: function(result){
			var listParticipation = JSON.parse(result);
			console.log(JSON.parse(result));
			var code = "";
			$.each(listParticipation,function(){
				code += "<div class='col-md-3'><img class='img-thumbnail' src='"+this.url_photo+"'></div>";
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