<?php

include("../config/conexion.php");

$id = $_GET['id'];

$sql = "DELETE FROM solicitud
WHERE idSol = $id";

mysqli_query($conn,$sql);

header("Location: solicitud_listar.php");
exit();

?>