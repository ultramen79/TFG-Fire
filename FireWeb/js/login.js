$(document).ready(function(){

$('input[type="submit"]').hide();

$('#submit').click(function(){
    var user= $('#nombreUsuario').val();
    var pass= $('#password').val();
    if(user!='' && pass!=''){
    $.ajax({
	   type: "POST",
	   url: "control/controlSesion.php",
       data:"nombreUsuario="+user+"&password="+pass,
	   success: function(dato){
	   if(dato == "true"){
		 window.location="panelDeControl/inicio.php";
        }
		else {
            $('#submit').val('Entrar');
            $('#error').show();
            setTimeout(function(){$('#error').fadeOut(500);},1500)
		}
	   },
	   beforeSend:function()
	   {
		$('#submit').val('Conectando...');
	   }
	  });
      return false;
	}
});
});