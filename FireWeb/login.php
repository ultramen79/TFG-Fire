<?php
    require_once ("require/compruebaSesion.php");
 ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<script defer src="https://use.fontawesome.com/releases/v5.8.2/js/all.js"></script>
    <link rel="stylesheet" href="css/loginn.css">
    <link rel="stylesheet" href="css/iconos.css">
    <title>Inicar sesión</title>
</head>
<body>
    <header>
        <img src="img/escudo.jpg" alt="Logo Bomberos">
    </header>
    <section class="contenedor">
        <form action="control/controlSesion.php" method="post" class="formulario" id="formulario">
			<h2>Gestión de la Base de Datos</h2>
            <h2>Personal Autorizado</h2>
            <div class="inputGroup">
            <label for="nombreUsuario">Nombre Usuario</label>
            <span><i class="fa fa-user" aria-hidden="true"></i>
    </span>
            <input type="text" name="nombreUsuario" id="nombreUsuario" placeholder="Nombre de usuario" required="required" autocomplete="off" title="Tu Correo" onchange="validar()" oninput="validar()">
            </div>
            <div class="inputGroup">
            <label for="contraseña" >Contraseña</label>
            <span><i class="fa fa-key" aria-hidden="true"></i>
    </span>
            <input type="password" placeholder="Contraseña" autocomplete="off" name="password" id="password" required="required" onchange="validar()" oninput="validar()">
            </div>
    
            <input type="submit" value="Entrar" name="submit" id="submit" >
            <div id="error" class="error">
                <p>Usuario o Contraseña incorrecta</p>
            </div>
        </form>
    </section>
	
	    <script  src="js/login.js"></script>

    <script>
    function validar(){
        if($('#nombreUsuario').val()!='' && $('#password').val()!=''){
            $('input[type="submit"]').show();
        }
        else{
            $('input[type="submit"]').hide();
        }
    }
    </script>
    <script src="js/login.js"></script>
	    <script  src="js/jquery.js"></script>

</body>
</html>