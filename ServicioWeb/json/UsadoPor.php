<?PHP
	require_once("../require/BDInventario.php");
	$json=array();		
	if(isset($_GET["matricula"]) && isset($_GET["herramienta"])){
		$matricula=$_GET['matricula'];	
		$herramienta=$_GET['herramienta'];

		$mat="SELECT ma_id FROM matriculas where ma_nu = '{$matricula}'";
		$resultadom=mysqli_query($conexion,$mat);
		
		if($registroma=mysqli_fetch_array($resultadom)){
			
			$matrip=$registroma['ma_id'];
			$her="SELECT he_id FROM herramientas where he_no = '{$herramienta}'";
			$resultadoh=mysqli_query($conexion,$her);
			
			if($registroh=mysqli_fetch_array($resultadoh)){
				$herp=$registroh['he_id'];

				$cons="SELECT MAX(in_id) nombre FROM inventario where (in_ma = '{$matrip}' && in_he = '{$herp}')";
				$resultadocon=mysqli_query($conexion,$cons);
				if($registrocon=mysqli_fetch_array($resultadocon)){
					$nombr= $registrocon['nombre'];
					
					$cons="SELECT in_no as nombre FROM inventario where (in_id = '{$nombr}')";
					$resultadocon2=mysqli_query($conexion,$cons);
					if($registrocon2=mysqli_fetch_array($resultadocon2)){
							$json['datos'][]=$registrocon2;
							echo json_encode($json);
					} else {
						$resulta["nombre"]="Fallo en la consulta.... Intentelo de nuevo";
						$json['datos'][]=$resulta;					
						echo json_encode($json);
					}
				} else {
					$resulta["nombre"]="Fallo en la consulta.... Intentelo de nuevo";
					$json['datos'][]=$resulta;					
					echo json_encode($json);
				}
				
			} else {
				$resulta["nombre"]="Fallo no encuentra la herramienta ... Intentelo de nuevo";
				$json['datos'][]=$resulta;					
				echo json_encode($json);
			}
		} else {
		$resulta["nombre"]= "Fallo no encuentra la matricula";
			$json['datos'][]=$resulta;					
			echo json_encode($json);
		}
	}
	else{
		$resultar["success"]=0;
		$resultar["message"]='No hay resultados';
		$json['datos'][]=$resultar;
		echo json_encode($json);
	}
	mysqli_close($conexion);
?>
