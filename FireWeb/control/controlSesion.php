<?php
session_start();
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH'])&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' || isset($_POST['submit'])){
    require_once("../require/BDInventario.php");
    function test_input($datos) {
      $datos = trim($datos);
      $datos = stripslashes($datos);
      $datos = htmlspecialchars($datos);
      $datos = htmlentities($datos);
      return $datos;
    }
    $usuario = test_input($_POST['nombreUsuario']);
    $password =test_input($_POST['password']);
    $password =hash('sha256',$password);

    $consulta="SELECT * FROM usuarioadmin WHERE usad_correo='".$usuario."' and usad_password='".$password."'";
    $resultado = mysqli_query($conexion, $consulta);
    $coincidencia= mysqli_num_rows($resultado);

    if($coincidencia > 0){
		
		$datos = $resultado->fetch_object();
		$_SESSION['administrador']='administrador';
		if(isset($_POST['submit']))
		header('Location: ../panelDeControl/inicio.php');
		mysqli_close($conexion);
		echo "true";
    }
    else{
        mysqli_close($conexion);
        if(isset($_POST['submit']))
        echo "<script language='JavaScript'>alert('Contraseña o usuario incorrecta');history.back();</script>";
        echo "false";
    }
 }
else{
	echo "false";
	
}
?>
