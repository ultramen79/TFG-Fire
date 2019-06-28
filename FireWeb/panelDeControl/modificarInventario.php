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
		<?php 
			$id=$_GET['id'];
			$consulta = "Select * from inventario where in_id=".$id;
			$resultado= $conexion->query($consulta);
			$datP=$resultado->fetch_object();
			
			$consultas = "Select * from matriculas where ma_id=$datP->in_ma";
			$resultados= $conexion->query($consultas);
			$dats=$resultados->fetch_object();
		?>
		<form class="formulario" name="formulario" id="formulario" action="../control/controlModificarInventario.php?id=<?php echo $id;?>" method="post" enctype="multipart/form-data">		
        
		<h2>Modificar Inventario</h2>
				
		<div class="cuadro">

		<div><h4>Vehiculo</h4></div>
		<label for="">Vehiculo</label>
		<select name="vehiculos" id="vehiculos">
			<option></option>
			<?php
			$seleccionarVehiculos= "select * from matriculas";
			$vehiculos = mysqli_query($conexion,$seleccionarVehiculos);
			while($datos = $vehiculos->fetch_object()){
				echo '<option '; if ($datos->ma_id==$datP->in_ma) {echo 'selected value="'.$datos->ma_id.'">'. utf8_encode($datos->ma_nu).'</option>';}
								else echo 'value="'.$datos->ma_id.'">'. utf8_encode($datos->ma_nu).'</option>';
			}
			?>
		</select>				
		
		
		
		<div><h4>Herramienta</h4></div>
		<label for="">Herramienta</label>
		<select name="herramienta" id="herramienta">
			<option></option>
			<?php
			$seleccionarHerramienta= "select * from herramientas";
			$herrami = mysqli_query($conexion,$seleccionarHerramienta);
			while($datos = $herrami->fetch_object()){
				echo '<option '; if ($datos->he_id==$datP->in_he) {echo 'selected value="'.$datos->he_id.'">'. utf8_encode($datos->he_no).'</option>';}
								else echo 'value="'.$datos->he_id.'">'. utf8_encode($datos->he_no).'</option>';
			}
			?>
		</select>				
		</div>
		
		<div class="cuadro">
		
			<div><h4>Nombre</h4></div>
			<input type="nombre" name="nombre" id="nombre" placeholder="Introduzca la modificacion" value="<?php echo $datP->in_no; ?>" autocomplete="off" required="required" />
			
			<div><h4>Fecha Salida</h4></div>
			<input type="f_salida" name="f_salida" id="f_salida" placeholder="YYYY-MM-DD" value="<?php echo $datP->in_fs; ?> " autocomplete="off" required="required"/>
			
			<div><h4>Fecha Entrada</h4></div>
			<input type="f_entrada" name="f_entrada" id="f_entrada" value="<?php echo $datP->in_fe; ?>" autocomplete="off" />
			
			
			<div><h4>Prestado</h4></div>
		
				<label for="">Prestado</label>
				<select name="prestado" id="prestado">
					<option></option>
					
					<?php
					$Si=si;
					$No=no;
					echo '<option '; if ($datP->in_es=='1') {echo 'selected value="1">'. utf8_encode($Si).'</option>';}
								else echo 'value="1">'. utf8_encode($Si).'</option>';
								
					echo '<option '; if ($datP->in_es=='0') {echo 'selected value="0">'. utf8_encode($No).'</option>';}
								else echo 'value="0">'. utf8_encode($No).'</option>';

					
					?>
				</select>					
		</div>
		
		<div class="cuadro" >
		<div align='center'>
		
			<input type="submit" name="submit" value="Modificar" id="submit">
			</div>
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
