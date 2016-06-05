$(document).ready(function(){
	$('.main-notification-box').delay(5000).slideUp(500);
/*	$('.deleteUpdate').ajaxForm({
	beforeSend: function() {
		console.log(this);
		 $('.deleteUpdate .submit').attr('value','Deleting...');
	},
	complete: function() { 
	alert('Deleted!');
	// $('#sacc-inputimg-button').attr('value','Click here to Upload');
	}
})*/
	
	$('.deleteUpdate').submit(function(){

		var form = $(this),
		formData = form.serialize(),
		formUrl = form.attr('action'),
    	formMethod = form.attr('method');
    	form.hide();
		$.ajax({
    	url: formUrl,
    	type: formMethod,
    	data: formData,
    	success:function(){
    		form.parent().parent().fadeOut(500);
    	},
    	error:function(){
    		form.show();
    	}
	});
		return false;
  });

	$('.grid').masonry({
    itemSelector: '.grid-item',
    columnWidth: 450,
    gutter: 20
  });
});