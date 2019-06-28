$('#email').blur(function(){
	var email = $(this).val();
	console.log(email);
	$.post('control/existEmail.php',{email: email},function(result){
		console.log(result);
		if(result){
			$('#email-message').css('display','flex');
			$('body').css('overflow','hidden');
		}
	});	
});
$('#email-message .card button').click(function(){
	$('body').css('display','visible');
	$('#email-message').css('display','none');
	$('#email').focus();
	if($(this).hasClass('error')){
		$(this).removeClass('error');
	}
	$('#email').addClass('error');
});
$('#message .card button').click(function(){
	$('#message').css('display','none');
});