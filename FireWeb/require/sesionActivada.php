<?php
session_start();
if (!isset($_SESSION['administrador'] )){
    header('Location: ../index.php');
}
?>