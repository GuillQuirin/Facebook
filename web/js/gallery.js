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
			console.log(JSON.parse(result));
			$('#gallery').html(JSON.parse(result));
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