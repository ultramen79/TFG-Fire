<?php
require_once("../require/sesionActivada.php");
include_once("../require/BDInventario.php");
?>

<!DOCTYPE html>
<script>
var numOpc = 1;
</script>
<html lang="es">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<script defer src="https://use.fontawesome.com/releases/v5.8.2/js/all.js"></script>
    <link rel="stylesheet" href="../css/panelDeControll.css">
    <link rel="stylesheet" href="../css/iconos.css">
	<link rel="stylesheet" href="../css/listarModificarInventario.css">    
    <link rel="stylesheet" href="../css/altaVehiculo.css">
	<link rel="shortcut icon" type="image/ico" href="../img/favicon.ico" />
	<title>Modificar preguntas</title>
</head>
<body class="body">
    <?php		
	include('../include/menu.php');
	?>
	
        <div class="cuerpo">
		
		<form class="formulario" name="formulario" id="formulario" action="../control/controlAltaVehiculo.php" method="post" enctype="multipart/form-data">		
        
		<h2>Alta Vehiculo</h2>
				
		<div class="cuadro">

		
		
				&nbsp;


		
		<div class="cuadro">
		
			<div><h4>Matricula</h4></div>
			<input type="matricula" name="matricula" id="matricula" placeholder="Introduzca la matricula" autocomplete="off" required="required" />
			
						
		</div>
				&nbsp;

		<div class="cuadro">
							<div style="text-align:center;">

		<input type="submit" name="submit" value="Añadir" id="submit">
		</div>
		</div>
		
		</form>
		&nbsp;

        </div>
    </section>
</body>


<script src="../js/reloj.php"></script>
<script src="../js/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.bundle.min.js"></script>
<script type="text/javascript"></script>
</html>
<?php
mysqli_close($conexion);
?>
