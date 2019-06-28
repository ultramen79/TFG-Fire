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
    <link rel="stylesheet" href="../css/altaInventario.css">
	<link rel="shortcut icon" type="image/ico" href="../img/favicon.ico" />
	<title>Modificar preguntas</title>
</head>
<body class="body">
    <?php		
	include('../include/menu.php');
	?>
	
        <div class="cuerpo">
		
		<form class="formulario" name="formulario" id="formulario" action="../control/controlAltaInventario.php" method="post" enctype="multipart/form-data">		
        
		<h2>Alta Inventario</h2>
				
		<div class="cuadro">

		<div><h4>Vehiculo</h4></div>
		<label for="">Vehiculo</label>
		<select name="vehiculos" id="vehiculos" autocomplete="off" required="required">
			<option></option>
			<?php
			$seleccionarVehiculos= "select * from matriculas";
			$vehiculos = mysqli_query($conexion,$seleccionarVehiculos);
			while($datos = $vehiculos->fetch_object()){
				echo '<option value="'.$datos->ma_id.'">'. utf8_encode($datos->ma_nu).'</option>';
			}
			?>
		</select>				
		
		
		
		<div><h4>Herramienta</h4></div>
		<label for="">Herramienta</label>
		<select name="herramienta" id="herramienta" autocomplete="off" required="required">
			<option></option>
			<?php
			$seleccionarHerramienta= "select * from herramientas";
			$herrami = mysqli_query($conexion,$seleccionarHerramienta);
			while($datos = $herrami->fetch_object()){
				echo '<option value="'.$datos->he_id.'">'. utf8_encode($datos->he_no).'</option>';
			}
			?>
		</select>				
		</div>
		
		<div class="cuadro">
		
			<div><h4>Nombre</h4></div>
			<input type="nombre" name="nombre" id="nombre" placeholder="Introduzca la modificacion" autocomplete="off" required="required" />
			
			<div><h4>Fecha Salida</h4></div>
			<input type="f_salida" name="f_salida" id="f_salida" placeholder="YYYY-MM-DD" autocomplete="off" required="required"/>
			
			<div><h4>Fecha Entrada</h4></div>
			<input type="f_entrada" name="f_entrada" id="f_entrada" />
			
			<div><h4>Prestado</h4></div>
		
				<label for="">Prestado</label>
				<select name="prestado" id="prestado">
					<option></option>
					<?php
					echo '<option value="0">'. utf8_encode('No').'</option>';
					echo '<option value="1">'. utf8_encode('Si').'</option>';
					?>
				</select>					
		</div>
		
		<div class="cuadro">
		<input type="submit" name="submit" value="Añadir" id="submit">
		</div>
		
		</form>

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
