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

if(isset($_POST['orden']) && !empty($_POST['orden']))
{
	$buscarUsuario=test_input($_POST['buscarUsuario']);
}



if(isset($_POST['buscarUsuario']) && !empty($_POST['buscarUsuario']))
    $buscarUsuario=test_input($_POST['buscarUsuario']);
else
	$buscarUsuario='';

if(isset($_POST['buscarCentro']) && !empty($_POST['buscarCentro']))
    $buscarCentro=test_input($_POST['buscarCentro']);
else
	$buscarCentro='';

if(isset($_POST['mayorQue']) && !empty($_POST['mayorQue']))
	$mayor=test_input($_POST['mayorQue']);	
else
	$mayor="-1 ";

if(isset($_POST['menorQue']) && !empty($_POST['menorQue']))
	$menor=test_input($_POST['menorQue']);	
else
	$menor="11 ";

if(isset($_POST['menorQue']) && !empty($_POST['menorQue']) && isset($_POST['mayorQue']) && !empty($_POST['mayorQue']) && $menor<$mayor)
{
	$mayor="-1 ";
	$menor="11 ";
}

if(!isset($_POST['provincias']) || empty($_POST['provincias']))
{
	//echo "PRO:".$_POST['provincias'];
	$prov=">0 ";
}	
else{
	//echo "PRO:".$_POST['provincias'];
	$prov="=".test_input($_POST['provincias']);
}




if(!isset($_POST['asignaturas']) || empty($_POST['asignaturas']))
	$asig=">0 ";
else
	$asig="=".test_input($_POST['asignaturas']);




if(!isset($_POST['puesto']) || (empty($_POST['puesto']) && $_POST['puesto']!="0"))
	$rol=">=0 ";
else
	$rol="=".test_input($_POST['puesto']);

if(!isset($_POST['situacion_administrativa']) || empty($_POST['situacion_administrativa']))
	$sitAd=">0 ";
else
	$sitAd="=".test_input($_POST['situacion_administrativa']);
/*
$posicionsubcadena = strpos ($_SERVER["REQUEST_URI"], "listarUsuarios.php");							
$url= substr($_SERVER["REQUEST_URI"],$posicionsubcadena);
$buscar="false";
$filtrarUsuarios="false";
$buscarUsuario;
$estadoActivo=0;
$estadoInactivo=0;
$rolusuario=0;
$estadoAdministrador=0;
if(isset($_GET['submitFiltrarUsuarios'])){
    if(isset($_GET['buscarUsuario'])){
        $buscarUsuario=test_input($_GET['buscarUsuario']);
    }
    else{
        $buscarUsuario='';
    }
        $filtrarUsuarios="true";
        if(isset($_GET['rolusuario'])){
            $rolusuario=$_GET['rolusuario'];
        }
        if(isset($_GET['estadoAdministrador'])){
            $estadoAdministrador=$_GET['estadoAdministrador'];
        }
        if(isset($_GET['estadoActivo'])){
            $estadoActivo=$_GET['estadoActivo'];
        }
        if(isset($_GET['estadoInactivo'])){
            $estadoInactivo=$_GET['estadoInactivo'];
        }
    
}*/
$n=0;
$asignaturasFinal="1";
//$nAsig="1";

if(isset($_POST['asignatura']) && !empty($_POST['asignatura']))
{
	//if(is_array($_POST['asignatura'])){
		$asignaturasFinal="( ";
			//$asignatura = $_POST['asignatura'][0];
			$asignatura = $_POST['asignatura'];
			$n=-1;
			foreach($asignatura as $key => $asig){
				$n++;
				$asignatura[$key] = test_input($asig);
				//echo "key:".$key." ";
				//echo "asig:".$asig." ";
				//echo "nombre:".$asignatura[$key]." ";
				if($n>0)
					$asignaturasFinal.=" or id_asignatura=".$asig." ";
				else
					if($n==0)
						$asignaturasFinal.="id_asignatura=".$asig." ";
					else
						$asignaturasFinal="1";
			}
			
			if($n==0)
			$asignaturasFinal.=" )"; 
			
			//echo "N:".$n;
			if($n>0)
				$asignaturasFinal.=") group by us_id having count(us_id)=".($n+1);	
				
			
		//}
		/*else{
			$asignatura = test_input($_POST['asignatura']);
			$asignaturasFinal="id_asignatura=".$asignatura." ";
		}*/
		
		//$_POST['asignatura']=array();
}



?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/panelDeControl.css">
    <link rel="stylesheet" href="../css/iconos.css">
    <link rel="stylesheet" href="../css/listarModificarUsuarios.css">    
	<link rel="stylesheet" href="../css/select2.min.css">
	<link rel="shortcut icon" type="image/ico" href="../img/favicon.ico" />
	<title>Listado de Usuarios</title>
</head>
<body class="body">
		
		<?php		
		include('../include/menu.php');
		?>
        
        <div class="cuerpo">
		
<?php
		
	$q="select * from inventario";
	$resultado= $conexion->query($q);
	$nn=mysqli_num_rows($resultado);
			if($nn==1)
				echo "<h2>Se encontró ".$nn." resultado.</h2>";
			else
				echo "<h2>Se encontraron ".$nn." resultados.</h2>";
	if($nn>0){
		echo "<table>
	<thead>
		<tr>
			<th>MATRICULA</td>
			<th>HERRAMIENTA</td>
			<th>NOMBRE</td>
			<th>FECHA SALIDA</td>
			<th>FECHA ENTRADA</td>
			<th>PRESTADO</td>
			<th colspan='2'>OPCIONES </th>  
			
		</tr>
	</thead>
	<tbody>";
		
	$i=0;
		while($datos=$resultado->fetch_object()){
							
							

						$res=$conexion->query("select ma_nu from matriculas where ma_id=".$datos->in_ma);
						$nombrematri=$res->fetch_array();
						
						$res=$conexion->query("select he_no from herramientas where he_id=".$datos->in_he);
						$nombreherra=$res->fetch_array();
						
?>
					  
					 <tr  class="<?php if($i%2==0){echo "tr1";$i++;}else {echo "tr2";$i++;}?>">
                        <td class="td_border celdaEstado"><div class="celda"> <?php echo utf8_encode ($nombrematri[0]);?></div></td>
                        <td class="td_border celdaEstado"><div class="celda"> <?php echo utf8_encode ($nombreherra[0]);?></div></td>
                        <td class="td_border celdaEstado"><div class="celda"> <?php echo utf8_encode($datos->in_no);?></div></td>
                        <td class="td_border celdaEstado"><div class="celda"> <?php echo utf8_encode($datos->in_fs);?></div></td>
                        <td class="td_border celdaEstado"><div class="celda"> <?php echo utf8_encode($datos->in_fe);?></div></td>
						 <td class="td_border celdaEstado"><div class="celda">  <?php if($datos->in_es<1){echo "PRESTADO";}else{echo "NO PRESTADO";}?></div></td>
						
						<td class="td_border celdaEstado"> <div class="celda"> <a href="inicio.php" class="botonMV"><i class="fa fa-cog" aria-hidden="true"></i></a></div></td>
						<td class="td_border celdaEstado"> <div class="celda"> <a href="../control/controlEliminarPregunta.php?id=<?php echo $datP->preg_id;?>"	class="botonMV" > <i class="fa fa-trash" aria-hidden="true"></i></a></div></td>
					
					</tr>
			<?php 
		}
			
			?>
	</tbody>
	</table>
				
			<?php
	} else 
		echo "no entra"
			?>
           
        </div>

    </section>
</body>


<script src="../js/jquery.js"></script>

<script src="../js/select2.full.min.js"></script>
<script src="../js/es.js"></script>


<script>
$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});

	</script>
<script src="../js/reloj.php"></script>

</html>
<?php
mysqli_close($conexion);
?>
