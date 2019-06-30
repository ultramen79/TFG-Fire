<?PHP

	require_once("../require/BDInventario.php");
	$json=array();		
	if(isset($_GET["matricula"])){
		$matricula=$_GET['matricula'];		
		$consulta="SELECT in_id, he_no, in_no FROM ( 
						SELECT MAX(in_id) id FROM (
							SELECT in_id, ma_nu, he_no, in_no, in_fs, in_fe, in_es FROM inventario 
							INNER JOIN matriculas on in_ma=ma_id 
							INNER JOIN herramientas on in_he= he_id 
							WHERE ma_nu='{$matricula}' 
							ORDER BY in_fs DESC) as res 
						GROUP BY res.he_no) as resul, inventario 
						INNER JOIN herramientas on in_he=he_id 
						WHERE in_id=resul.id";
		$resultado=mysqli_query($conexion,$consulta);
		while($registro=mysqli_fetch_array($resultado)){
			$json['datos'][]=$registro;
		}
		mysqli_close($conexion);
		echo json_encode($json);
	}
	else{
		$resultar["success"]=0;
		$resultar["message"]='No conecta';
		$json['datos'][]=$resultar;
		echo json_encode($json);
	}
?>

