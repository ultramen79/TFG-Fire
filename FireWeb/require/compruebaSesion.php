<?php
session_start();
if (isset($_SESSION['administrador'] )){
    header('Location: panelDeControl/inicio.php');
}
?>