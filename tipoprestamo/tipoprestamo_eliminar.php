<?php

include("../config/conexion.php");

$id = $_GET['id'];

$sql = "DELETE FROM tipoprestamo
WHERE idTipPres = $id";

mysqli_query($conn,$sql);

header("Location: tipoprestamo_listar.php");
exit();

?>