<?PHP
	require_once("../require/BDInventario.php");
	$json=array();
	$consulta="SELECT he_no FROM herramientas";
	$resultado=mysqli_query($conexion,$consulta);
	while($registro=mysqli_fetch_array($resultado)){
		$json['datos'][]=$registro;
	}
	mysqli_close($conexion);
	echo json_encode($json);

?>