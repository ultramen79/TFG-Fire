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
	
    if(empty($_POST['vehiculos']) || empty($_POST['herramienta']) || empty($_POST['nombre']) || empty($_POST['f_salida']) ) {
		echo "<script language='JavaScript'>alert('Rellene todos los datos  p".test_input($_POST['prestado'])."');history.back();</script>";
		header('Location: ../panelDeControl/listarInventario.php');
		exit();	
	}
	require_once("../require/BDInventario.php");
	$veh = test_input($_POST['vehiculos']);
    $herr = utf8_encode(test_input($_POST['herramienta']));
	$nom = test_input($_POST['nombre']);
	$f_s = test_input($_POST['f_salida']);
	$f_e = test_input($_POST['f_entrada']);
	$pre = test_input($_POST['prestado']);
	$fallo= false;
	$last_id;

	$idP = test_input($_GET['id']);
	if (empty($_POST['f_entrada'])){

		$sql="update inventario set in_ma='".$veh."', in_he='".$herr."', in_no='".$nom."', in_fs='".$f_s."', in_es='".$pre."' 
		where in_id='".$idP."'";
	} else 
		$sql="update inventario set in_ma='".$veh."', in_he='".$herr."', in_no='".$nom."', in_fs='".$f_s."', in_fe='".$f_e."', in_es='".$pre."' 
	where in_id='".$idP."'";
	
		

	if(!mysqli_query($conexion, $sql)) 
	{
		printf("Errormessage: %s\n", mysqli_error($conexion));
		header('Location: ../panelDeControl/listarInventario.php');
		exit();	
	} else {
		echo"<script>alert('Inventario modificado correctamente.');</script>";
		header('Location: ../panelDeControl/listarInventario.php');
		exit();
	}
	
	mysqli_close($conexion);
	
} else{
	echo"<script>alert('No submit.');history.back();</script>";	
	exit();
    header('Location: ../panelDeControl/listarInventario.php');
}
?>