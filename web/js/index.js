$(document).ready(function(){
	$('.backTop').click(function(){
		$('html, body').animate({
			scrollTop: $(".listPictures").offset().top-100
		}, 100);
	});

	$('.panel-heading').click(function(){
		var panelDefault = $(this).parent().parent();

		panelDefault.toggleClass("col-md-10",5000);
		panelDefault.toggleClass("col-md-6",5000);
		panelDefault.toggleClass("col-md-offset-3",5000);
		panelDefault.toggleClass("col-md-offset-1",5000);
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