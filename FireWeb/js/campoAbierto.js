$('input[type="radio"]').click(function(){
		 if($(this).hasClass('campo')){
			 var article = 'preg'+$(this).attr('name');
			 var texto = $(this).siblings('span').html();
			 if(!$(this).parent().siblings().hasClass('campo-abierto')){
			 	$("#"+article).append('<div class="campo-abierto"><label>'+texto+'</label><input type="text" required name="campo-abierto-'+ $(this).attr('id') + '"></div>');
			 }
		 }
		else{
			$(this).parent().siblings('.campo-abierto').remove();
			$(this).parent().siblings().children('.campo').prop( "disabled", false );
		}
});