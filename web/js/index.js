$(document).ready(function(){
	$('#listPictures h3').click(function(){
		var id = $(this).attr('id');
		$('#album-'+id).slideToggle();
	});
});