<?PHP

	require_once("../require/BDInventario.php");
	$json=array();	

	$nombre = $_POST["nombre"];
	$imagen = $_POST["imagen"];

	$path = "../imagenes/$nombre.jpg";

	//$url = "http://$hostname_localhost/ejemploBDRemota/$path";
	//$url = "../imagenes/".$nombre.".jpg";

	file_put_contents($path,base64_decode($imagen));
	echo "registra";


	
	mysqli_close($conexion);
?>

