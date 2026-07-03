<?php

include("../config/conexion.php");

$idSol = $_POST['idSol'];

$sql = "UPDATE solicitud SET

idUsu = '".$_POST['idUsu']."',
idTipPres = '".$_POST['idTipPres']."',
montoSol = '".$_POST['montoSol']."',
plazoSol = '".$_POST['plazoSol']."',
observSol = '".$_POST['observSol']."',
idEstSol = '".$_POST['idEstSol']."'

WHERE idSol = $idSol";

mysqli_query($conn,$sql);

header("Location: solicitud_listar.php");
exit();

?>