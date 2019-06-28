<?php
require_once("../require/sesionActivada.php");
require_once("../require/BDInventario.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<script defer src="https://use.fontawesome.com/releases/v5.8.2/js/all.js"></script>
    <link rel="stylesheet" href="../css/panelDeControll.css">
    <link rel="stylesheet" href="../css/iconos.css">
    <link rel="stylesheet" href="../css/listarModificarHerramienta.css">    
	<link rel="stylesheet" href="../css/select2.min.css">
	<link rel="shortcut icon" type="image/ico" href="../img/favicon.ico" />
	<title>Listado de Vehiculos</title>
</head>
<body class="body">
		
	<?php		
	include('../include/menu.php');
	?>
	
	<div class="cuerpo">
	&nbsp;

		<div class="cuadro">

			<div class="select">
				<div class="celda"><h2> Añadir registro</h2><a href="AltaVehiculo.php"	class="botonMV" > <i class="fa fa-plus" aria-hidden="true"></i></a></div>
			</div>
				
		</div>
<?php
		
		$q="select * from matriculas";
		$resultado= $conexion->query($q);
		$nn=mysqli_num_rows($resultado);
				if($nn==1)
					echo "<h2>Se encontró ".$nn." resultado.</h2>";
				else
					echo "<h2>Se encontraron ".$nn." resultados.</h2>";
		if($nn>0){
			echo "<table>
		<thead>
			<tr>
				<th>IDENTIFICADOR</td>
				<th>MATRICULA</td>
				<th colspan='2'>OPCIONES </th>  
				
			</tr>
		</thead>
		<tbody>";
			
		$i=0;
		while($datos=$resultado->fetch_object()){
?>
			  
			<tr  class="<?php if($i%2==0){echo "tr1";$i++;}else {echo "tr2";$i++;}?>">
				<td class="td_border celdaEstado"><div class="celda"> <?php echo utf8_encode($datos->ma_id);?></div></td>
				<td class="td_border celdaEstado"><div class="celda"> <?php echo utf8_encode($datos->ma_nu);?></div></td>
				
				<td class="td_border celdaEstado"> <div class="celda"> <a href="modificarVehiculo.php?id=<?php echo $datos->ma_id;?>" class="botonMV"><i class="fa fa-cog" aria-hidden="true"></i></a></div></td>
				<td class="td_border celdaEstado"> <div class="celda"> <a href="../control/controlEliminarVehiculo.php?id=<?php echo $datos->ma_id;?>"	class="botonMV" > <i class="fa fa-trash" aria-hidden="true"></i></a></div></td>
			
			</tr>
			<?php 
		}
			
			?>
	</tbody>
	</table>
				
			<?php
	} else 
		echo "no entra"
			?>
           
	</div>

    </section>
</body>


<script src="../js/jquery.js"></script>

<script src="../js/select2.full.min.js"></script>
<script src="../js/es.js"></script>


<script>
$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});

	</script>
<script src="../js/reloj.php"></script>

</html>
<?php
mysqli_close($conexion);
?>
