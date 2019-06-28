$('#email').blur(function(){
	var expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if($(this).hasClass('error')){
		$(this).removeClass('error');
	}
    if ( !expr.test($(this).val()) && $(this).val().length > 0 ){
		$(this).addClass('error');
		return false;
	}
	
});
$('#centro_educativo').blur(function(){	
	var expr = /.*[aA-zZ]+.*/;
	if($(this).hasClass('error')){
		$(this).removeClass('error');
	}
    if (!expr.test($(this).val()) && $(this).val().length > 0 ){
        $(this).addClass('error');
		return false;
	}
});