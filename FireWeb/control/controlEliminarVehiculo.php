<?php
require_once("../require/sesionActivada.php");
function test_input($datos) {
  $datos = trim($datos);
  $datos = stripslashes($datos);
  $datos = htmlspecialchars($datos);
  $datos = htmlentities($datos);
  return $datos;
}

require_once("../require/BDInventario.php");
$id =test_input($_GET['id']);

		$sql = "delete from matriculas where ma_id='".$id."'";  
		    echo"<script>alert('$sql');history.back();</script>";

		if (!mysqli_query($conexion, $sql)) 
		{
			printf("Errormessage: %s\n", mysqli_error($conexion));
			mysqli_close($conexion);
			//echo"<script>alert('Error al eliminar.');history.back();</script>";
		}
		else{
			mysqli_close($conexion);
			echo"<script>alert('Registro del inventario eliminado correctamente.');history.back();</script>";	
		}
?>