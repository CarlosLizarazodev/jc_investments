<?php

include("../config/conexion.php");

$id = $_GET['id'];

$sql = "DELETE FROM estadosolicitud
WHERE idEstSol = $id";

mysqli_query($conn,$sql);

header("Location: estadosolicitud_listar.php");
exit();

?>