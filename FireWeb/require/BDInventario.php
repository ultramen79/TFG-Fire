<?php
	$servername="192.168.0.19";
	$dbname="fire";
	$username="fire";
	$contrasena="fire123";
	
//$servername="localhost";
//$username="encuesta";
//$contrasena=".Encuesta123&";
//$dbname="inventario";


//$hostname_localhost="localhost";
	//$database_localhost="id9996794_inventario";
	//$username_localhost="id9996794_inventario";
	//$password_localhost="inventario123";
		//$conexion=mysqli_connect($hostname_localhost,$username_localhost,$password_localhost,$database_localhost);

	
$conexion = @mysqli_connect($servername,$username,$contrasena,$dbname); 
if(mysqli_connect_errno()){
	header('Location: ../errorBD.php');
	exit();
}
mysqli_set_charset($conexion,"utf-8");
?>

