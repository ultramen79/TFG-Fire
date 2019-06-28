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
	
    if(empty($_POST['vehiculos']) || empty($_POST['herramienta']) || empty($_POST['nombre']) || empty($_POST['f_salida']) ){
        echo "<script language='JavaScript'>alert('Rellene todos los datos');history.back();</script>";
        exit;
    }
	
	require_once("../require/BDInventario.php");
	$veh = test_input($_POST['vehiculos']);
    $herr = test_input($_POST['herramienta']);
	$nom = utf8_encode(test_input($_POST['nombre']));
	
	$f_s = test_input($_POST['f_salida']);
	$pre = test_input($_POST['prestado']);
		
	if (empty($_POST['f_entrada'])) {
		$sql="insert into inventario(in_ma, in_he, in_no, in_fs, in_es) values('$veh','$herr', '$nom', '$f_s', '$pre')";
	} else 
		$sql="insert into inventario(in_ma, in_he, in_no, in_fs, in_fe, in_es) values('$veh','$herr', '$nom', '$f_s', '$f_e', '$pre')";
		
	if(!mysqli_query($conexion, $sql)) 
	{
		printf("Errormessage: %s\n", mysqli_error($conexion));
		header('Location: ../panelDeControl/listarInventario.php');
		exit();	
	} else {
		echo"<script>alert('Pregunta modificada correctamente.');</script>";
			header('Location: ../panelDeControl/listarInventario.php');
			exit();
	}
	
	mysqli_close($conexion);
	
} else{
	echo"<script>alert('No submit.');history.back();</script>";	
	exit();
}
?>