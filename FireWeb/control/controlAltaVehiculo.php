<?php
require_once("../require/sesionActivada.php");
function test_input($datos) {
  $datos = trim($datos);
  $datos = stripslashes($datos);
  $datos = htmlspecialchars($datos);
  $datos = htmlentities($datos);
  return $datos;
}
if(isset($_POST['submit'])) {
	
 
	require_once("../require/BDInventario.php");
	$veh = test_input($_POST['matricula']);
    
	$sql="insert into matriculas(ma_nu) values('$veh')";
		
	if(!mysqli_query($conexion, $sql)) 
	{
		printf("Errormessage: %s\n", mysqli_error($conexion));
		header('Location: ../panelDeControl/listarVehiculos.php');
		exit();	
	} else {
		echo"<script>alert('Pregunta modificada correctamente.');</script>";
			header('Location: ../panelDeControl/listarVehiculos.php');
			exit();
	}
	
	mysqli_close($conexion);
	
} else{
	echo"<script>alert('No submit.');history.back();</script>";	
	exit();
}
?>