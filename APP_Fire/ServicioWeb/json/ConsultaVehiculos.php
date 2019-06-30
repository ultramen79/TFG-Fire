<?PHP
	require_once("../require/BDInventario.php");
	$json=array();
	$consulta="SELECT ma_nu FROM matriculas";
	$resultado=mysqli_query($conexion,$consulta);
	while($registro=mysqli_fetch_array($resultado)){
		$json['datos'][]=$registro;
	}
	mysqli_close($conexion);
	echo json_encode($json);
?>