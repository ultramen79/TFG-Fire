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
if(isset($_POST['submit'])) {
	
    if(empty($_POST['matricula'])) {
		echo "<script language='JavaScript'>alert('Rellene todos los datos  p".test_input($_POST['prestado'])."');history.back();</script>";
		header('Location: ../panelDeControl/listarInventario.php');
		exit();	
	}
	require_once("../require/BDInventario.php");
	$veh = test_input($_POST['matricula']);
    

	$idP = test_input($_GET['id']);


	$sql="update matriculas set ma_nu='".$veh."' where ma_id='".$idP."'";

	
		

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
    header('Location: ../panelDeControl/listarVehiculos.php');
}
?>