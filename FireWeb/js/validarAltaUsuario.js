function validarAltaUsuario(){ 
    if($('#dni').val()!='' && $('#dni').val().length==9 &&  $('#password').val()!='' && $('#password').val()!='' && $('input[name=activo]:checked', '#formulario').val()!='' && $('input[name=rol]:checked', '#formulario').val()!=''){
        if(dni.value.match(/^\d{8}[a-zA-Z]{1}$/))
            $('input[type="submit"]').show();
    }
    else{
        $('input[type="submit"]').hide();
    }
}