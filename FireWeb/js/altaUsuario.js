$(document).ready(function(){
$('input[type="submit"]').hide();
validarAltaUsuario();
$('#submit').click(function(){
    var dni= $('#dni').val();
    var pass= $('#password').val();
    var passOk = $('#passwordOk').val();
    var activo = $('input[name=activo]:checked', '#formulario').val();
    var rol = $('input[name=rol]:checked', '#formulario').val();
    var datos = $("#formulario").serialize(); 
    // "dni="+dni+"&password="+pass +"&passwordOk=" + passOk + "&activo="+activo+"&rol="+rol
    if(dni!='' && pass!=''  &&  passOk!='' && activo!='' && rol!='')
    $.ajax({
	   type: "POST",
	   url: "../control/controlAltaUsuario.php",
       data:datos,
	   success: function(dato){
         var error_msg;
	   if(dato == "true"){
         $('#submit').val('Alta');
         $('#dni').val('');
          var correcto_msg="EL usuario ha sido de alta";
         $('#correcto p').text(correcto_msg);
         $('#correcto').show();
        setTimeout(function(){$('#correcto').fadeOut(500);},1500);
		   $('input[type="submit"]').hide();
        }
        else {
            if(dato == '1')
            error_msg='Rellene todos los datos';
            if(dato == '2')
            error_msg='Las contraseñas no coinciden';
            if(dato == '3')
            error_msg='Selecciona el rol de usuario';
            if(dato =='4')
            error_msg='Usuario ya existe.';
            
            $('#submit').val('Alta');
            $('#error p').text(error_msg);
            $('#error').show();
            setTimeout(function(){$('#error').fadeOut(500);},1500);
        }
            
	   },
	   beforeSend:function()
	   {
		$('#submit').val('Alta...');
	   }
	  });
      return false;
});
});
// TODO: Arreglar el los mensajes a la hora de subir correctamente un usuario y vaciar el input del dni y manejar los mensajes de error