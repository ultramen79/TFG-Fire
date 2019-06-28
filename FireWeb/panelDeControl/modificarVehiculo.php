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
			$consulta = "Select * from matriculas where ma_id=".$id;
			$resultado= $conexion->query($consulta);
			$datP=$resultado->fetch_object();
			
		?>
		<form class="formulario" name="formulario" id="formulario" action="../control/controlModificarVehiculo.php?id=<?php echo $id;?>" method="post" enctype="multipart/form-data">		
        
		<h2>Modificar Vehiculo</h2>
				
		<div class="cuadro">

		
		&nbsp;
		<div class="cuadro">
				<div style="text-align:center;">

			<div><h4>Matricula</h4></div>
			<input type="matricula" name="matricula" id="matricula" placeholder="Introduzca la modificacion" value="<?php echo $datP->ma_nu; ?>" autocomplete="off" required="required" />
						
		</div>
		</div>
				&nbsp;

		<div class="cuadro" >
			<input type="submit" name="submit" value="Modificar" id="submit">
		</div>
		</div>
				&nbsp;

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
