<?php

include("../config/conexion.php");

$idEstSol = $_POST['idEstSol'];

$sql = "UPDATE estadosolicitud SET

nomEstSol = '".$_POST['nomEstSol']."',
descEstSol = '".$_POST['descEstSol']."',
codEstSol = '".$_POST['codEstSol']."'

WHERE idEstSol = $idEstSol";

mysqli_query($conn,$sql);

header("Location: estadosolicitud_listar.php");
exit();

?>