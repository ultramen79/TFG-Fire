function validarAltaCurso(){ 
    if($('#curso').val()!='' &&   $('#descripcion').val()!='' && $('input[name=activo]:checked', '#formulario').val()!='' ){
        $('input[type="submit"]').show();
    }
    else{
        $('input[type="submit"]').hide();
    }
}