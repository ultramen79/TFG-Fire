<?php
require_once("../require/sesionActivada.php");
require_once("../require/BDInventario.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	
	<script defer src="https://use.fontawesome.com/releases/v5.8.2/js/all.js"></script>
	
    <link rel="stylesheet" href="../css/panelDeControll.css">
  <link href="/your-path-to-fontawesome/css/fontawesome.css" rel="stylesheet">
  <link href="/your-path-to-fontawesome/css/brands.css" rel="stylesheet">
  <link href="/your-path-to-fontawesome/css/solid.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/iconos.css">
    <link rel="stylesheet" href="../css/inicio.css">
	<link rel="shortcut icon" type="image/ico" href="../img/escudo.jpg" />
    <title>Panel de Control</title>
</head>
<body class="body">
		<?php		
		include('../include/menu.php');
		?>

    <div class="cuerpo">
	
		<div class="top">
					<article class="total">
                   <div>
                    <h6><i class="fa fa-tools" aria-hidden="true"></i>&nbsp;TOTAL HERRAMIENTAS</h6>
                    <p><?php
							$consulta = 'Select he_id from herramientas';
                            $resultado = mysqli_query($conexion, $consulta);
                            $totalUsuarios= mysqli_num_rows($resultado);
                            echo $totalUsuarios;
                        ?>
                    </p>
                    </div>
                </article>
                <article class="total">
                   <div>
                    <h6><i class="fa fa-file" aria-hidden="true"></i>&nbsp;TOTAL PRESTADAS</h6>
                    <p><?php
                            $consulta = 'Select in_id from inventario where in_es=0';
                            $resultado = mysqli_query($conexion, $consulta);
                            $totalUsuarios= mysqli_num_rows($resultado);
                            echo $totalUsuarios;
                        ?>
                    </p>
					<p class="activo">
                    	<?php
                            $consulta = 'Select in_id from inventario where in_es=1';
                            $resultado = mysqli_query($conexion, $consulta);
                            $totalUsuarios= mysqli_num_rows($resultado);
                            echo "Pendientes de recoger:  " .$totalUsuarios;
                        ?>
                    </p>
					</div>
                </article>
                <article class="total">
                   <div>
                    <h6><i class="fa fa-book" aria-hidden="true"></i>&nbsp;HERRAMIENTA MAS USADA</h6>
                    <p><?php
						$totalAnterior=0;
						$he=0;
						for ($i=1; $i < 6; $i++) {
							
						
							$consulta = 'Select in_he from inventario where in_he='.$i.'';
                            $resultado = mysqli_query($conexion, $consulta);
                            $totalHerramientas= mysqli_num_rows($resultado);	
							
							if ($totalAnterior<$totalHerramientas) {
								$totalAnterior=$totalHerramientas;
								$he=$i;
							}
						}
						$consulta = 'Select he_no from herramientas where he_id='.$he.'';
                            $resultado = mysqli_query($conexion, $consulta);
							$nombreherra=$resultado->fetch_array();
							$nombreherra[0]=strtoupper($nombreherra[0]);
                            echo $nombreherra[0];
                        ?>
                    </p>

					</div>
                </article>
		</div>
			
		<div class="top5">
			<div class="">
				
				<?php 
					$consulta = 'Select he_no, in_no, in_fs, in_fe from inventario INNER JOIN herramientas on in_he= he_id
					where in_es=0 order by in_fs desc limit 5';
					$resultado = mysqli_query($conexion, $consulta);
					$contador=0;
				?>
				<h5 >Herramientas Devueltas</h5>
				<ul>
				<?php  while($datos=$resultado->fetch_object()){
					$contador++;
					
					?>
					<li><?php echo  $datos->he_no ." - ".  $datos->in_no ." - ". $datos->in_fs ." - ". $datos->in_fe; ?></li>
				<?php 
					}
					if($contador < 5){
						for($i = $contador; $i < 5; $i++ ){
				?>
						<li></li>
						<?php
						}
					}
					?>
				</ul>
			</div>
			<div class="">
				
				<?php $consulta = 'Select he_no, in_no, in_fs from inventario INNER JOIN herramientas on in_he= he_id
				where in_es=1 order by in_fs desc limit 5';
					$resultado = mysqli_query($conexion, $consulta);
					$nUs=mysqli_num_rows($resultado);
					$contador=0;
				?>
				<h5 >Herramientas Prestadas</h5>
				<ul>
				<?php  while($datos=$resultado->fetch_object()){
					$contador++;
					
					?>
					<li><?php echo  $datos->he_no ." - ".  $datos->in_no ." - ". $datos->in_fs; ?></li>
				<?php }
					if($contador < 5){
						for($i = $contador; $i < 5; $i++ ){
						?>
						<li></li>
						<?php
						}
					} 
					?>
				</ul>
			</div>
		</div>
			<?php 
			if($nUs>0)
			{
			?>	
		<canvas id="grafica"></canvas>
		<canvas id="grafica1"></canvas>
		<canvas id="grafica2"></canvas>
			<?php
			}
			?>
	</div>
	</section>
        
    <script src="../js/reloj.php"></script>
    <script src="../js/jquery.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.bundle.min.js"></script>
</body>

</html>
<?php
mysqli_close($conexion);
?>