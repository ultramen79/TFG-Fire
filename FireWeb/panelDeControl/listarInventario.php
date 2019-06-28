<?php
require_once("../require/sesionActivada.php");
require_once("../require/BDInventario.php");
function test_input($datos) {
  $datos = trim($datos);
  $datos = stripslashes($datos);
  $datos = htmlspecialchars($datos);
  $datos = htmlentities($datos);
  return $datos;
}

if(!isset($_POST['herramienta']) || empty($_POST['herramienta']))
	$buscarHerramienta=">0 ";
else
	$buscarHerramienta="=".test_input($_POST['herramienta']);


if(!isset($_POST['matricula']) || empty($_POST['matricula']))
	$buscarMatricula=">0 ";
else
	$buscarMatricula="=".test_input($_POST['matricula']);

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
    <link rel="stylesheet" href="../css/listarModificarI.css">    
	<link rel="stylesheet" href="../css/select2.min.css">
	<link rel="shortcut icon" type="image/ico" href="../img/favicon.ico" />
	<title>Listado de Usuarios</title>
</head>
<body class="body">
		
	<?php		
	include('../include/menu.php');
	?>
	
	<div class="cuerpo">
	
		&nbsp;

		<div class="cuadro">

				<div class="select">
				<div class="celda"><h2> Añadir registro</h2><a href="AltaInventario.php"	class="botonMV" > <i class="fa fa-plus" aria-hidden="true"></i></a></div>
				</div>
				
		</div>
	
		<form action="" method="post" class="formularioFiltrarUsuarios">
			  
			<div class="cuadro">
				<div class="select">
				<div>
					<label for="">Matricula</label>
					<select name="matricula" id="matricula">
						<option></option>
						<?php
						$seleccionarMatricula= "select * from matriculas";
						$matricula = @mysqli_query($conexion,$seleccionarMatricula);
						while($datos = $matricula->fetch_object()){
							echo '<option value="'.$datos->ma_id.'">'. utf8_encode($datos->ma_nu).'</option>';
						}
						?>
					</select>
				</div>
					<div>
					<label for="">Herramienta</label>
					<select name="herramienta" id="herramienta">
						<option></option>
						<?php
						$seleccionarHerramienta= "select * from herramientas";
						$herramienta = mysqli_query($conexion,$seleccionarHerramienta);
						while($datos = $herramienta->fetch_object()){
							echo '<option value="'.$datos->he_id.'">'. utf8_encode($datos->he_no).'</option>';
						}
						?>
					</select>
					</div>
				</div>
					&nbsp;
					<div style="text-align:center;">
					<input type="submit" name="submitFiltrarUsuarios" value="Filtrar" id="filtrarUsuarios">
					</div>
			   </div>        
		</form>
<?php

		$q="select * from inventario where in_ma".$buscarMatricula." and in_he".$buscarHerramienta." order by in_fs desc";
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
					<th>MATRICULA</td>
					<th>HERRAMIENTA</td>
					<th>NOMBRE</td>
					<th>FECHA SALIDA</td>
					<th>FECHA ENTRADA</td>
					<th>ESTADO</td>
					<th colspan='2'>OPCIONES </th>  
				
				</tr>
			</thead>
		<tbody>";
			
			$i=0;
			while($datos=$resultado->fetch_object()){
								
				$res=$conexion->query("select ma_nu from matriculas where ma_id=".$datos->in_ma);
				$nombrematri=$res->fetch_array();
				
				$res=$conexion->query("select he_no from herramientas where he_id=".$datos->in_he);
				$nombreherra=$res->fetch_array();
				?>
				<tr  class="<?php if($i%2==0){echo "tr1";$i++;}else {echo "tr2";$i++;}?>">
					<td class="td_border celdaEstado"><div class="celda"> <?php echo utf8_encode ($nombrematri[0]);?></div></td>
					<td class="td_border celdaEstado"><div class="celda"> <?php echo utf8_encode ($nombreherra[0]);?></div></td>
					<td class="td_border celdaEstado"><div class="celda"> <?php echo utf8_encode($datos->in_no);?></div></td>
					<td class="td_border celdaEstado"><div class="celda"> <?php echo utf8_encode($datos->in_fs);?></div></td>
					<td class="td_border celdaEstado"><div class="celda"> <?php echo utf8_encode($datos->in_fe);?></div></td>
					<td class="td_border celdaEstado"><div class="celda">  <?php if($datos->in_es<1){echo "ESTA";}else{echo "NO ESTA";}?></div></td>
					
					<td class="td_border celdaEstado"> <div class="celda"> <a href="modificarInventario.php?id=<?php echo $datos->in_id;?>" class="botonMV"><i class="fa fa-cog" aria-hidden="true"></i></a></div></td>
					<td class="td_border celdaEstado"> <div class="celda"> <a href="../control/controlEliminarInventario.php?id=<?php echo $datos->in_id;?>"	class="botonMV" > <i class="fa fa-trash" aria-hidden="true"></i></a></div></td>
				</tr>
				<?php 
			}
				
				?>
		</tbody>
		</table>
				
			<?php
	} else 
		echo "No hay herramientas prestadasentra"
			?>
           
        </div>
    </section>
</body>

<script src="../js/jquery.js"></script>
<script src="../js/select2.full.min.js"></script>
<script src="../js/es.js"></script>

<<script>
$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});

		 (function() {
  			$("#matricula").select2({
				placeholder: "Selecciona una matricula",
				allowClear: true,
				language: "es"
			});
  			$("#herramienta").select2({
				placeholder: "Selecciona una herramienta",
				allowClear: true,
				language: "es"
			});
		 })();
	</script>
<script src="../js/reloj.php"></script>

</html>
<?php
mysqli_close($conexion);
?>
