<?php

include("../config/conexion.php");

$nomEstSol = $_POST['nomEstSol'];
$descEstSol = $_POST['descEstSol'];
$codEstSol = $_POST['codEstSol'];

$sql = "INSERT INTO estadosolicitud(
nomEstSol,
descEstSol,
codEstSol
)
VALUES(
'$nomEstSol',
'$descEstSol',
'$codEstSol'
)";

mysqli_query($conn,$sql);

header("Location: estadosolicitud_listar.php");
exit();

?>