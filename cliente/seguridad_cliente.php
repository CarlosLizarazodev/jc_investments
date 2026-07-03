<?php
session_start();

if(!isset($_SESSION['idUsu'])){
    header("Location: ../login/login.php");
    exit();
}

if($_SESSION['codRol'] != 'CLIENTE'){
    die("ACCESO DENEGADO");
}
?>