$(document).ready(function(){
	$('.backTop').click(function(){
		$('html, body').animate({
			scrollTop: $(".listPictures").offset().top-100
		}, 100);
	});

	$('#localForm').submit(function(){
		$('.pbFileSize').slideUp();

	    if (window.File && window.FileReader && window.FileList && window.Blob){
	    	if($('#i_file')[0].files[0].size < 10485760) //10Mo
	    		return true;
	    	else
	    		$('.pbFileSize').slideDown();
	    }
	    else
	        alert("Please upgrade your browser, because your current browser lacks some new features we need!");
	    
	    return false;
	});
});