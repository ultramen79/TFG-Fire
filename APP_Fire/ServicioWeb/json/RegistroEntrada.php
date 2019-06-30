<?PHP
	require_once("../require/BDInventario.php");
	$json=array();
	if(isset($_GET["matricula"]) && isset($_GET["herramienta"]) && isset($_GET ["nombre"]) && isset($_GET["fecha"])){
		$matri=$_GET['matricula'];
		$herram=$_GET['herramienta'];
		$nombre=$_GET['nombre'];
		$fecha_e=$_GET['fecha'];
	
		$her="SELECT ma_id FROM matriculas where ma_nu = '{$matri}'";
		$resultadom=mysqli_query($conexion,$her);
		
		if($registroma=mysqli_fetch_array($resultadom)){

			$matrip=$registroma['ma_id'];
			$her="SELECT he_id FROM herramientas where he_no = '{$herram}'";
			$resultadoh=mysqli_query($conexion,$her);
			
			if($registroh=mysqli_fetch_array($resultadoh)){
				$herp=$registroh['he_id'];

				$her="SELECT in_id, in_es FROM inventario where (in_ma = '{$matrip}' && in_he = '{$herp}')";
				$resultadocon=mysqli_query($conexion,$her);
				if($registroselec=mysqli_fetch_array($resultadocon)){
					$prestada=$registroselec['in_es'];
					$prestadaid=$registroselec['in_id'];

					if ($prestada=='0'){
						$resulta["nombre"]="La herramienta ya esta prestada";
						$json['datos'][]=$resulta;
						echo json_encode($json);
					} else {

						$upd="UPDATE inventario SET in_fe = '{$fecha_e}', in_es = '0' WHERE in_id='{$prestadaid}'";
						$resultados=mysqli_query($conexion,$upd);
						if($resultados){
							$resulta["nombre"]="Herramienta devuelta con exito";
							$json['datos'][]=$resulta;					
							echo json_encode($json);
						} else {
							$resulta["nombre"]="Fallo en la devolucion.... Intentelo de nuevo";
							$json['datos'][]=$resulta;					
							echo json_encode($json);
						}
					}
				} else {		
					$resulta["nombre"]="La herramienta NO prestada";
					$json['datos'][]=$resulta;					
					echo json_encode($json);
					
				}				
			}	
		}
	}
	
	else{
			$resulta["nombre"]="Faltan valores por rellenar";
			$json['usuario'][]=$resulta;
			echo json_encode($json);
	}	
	mysqli_close($conexion);

?>

