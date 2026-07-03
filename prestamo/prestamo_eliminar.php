<?php

include("../config/conexion.php");

$id = $_GET['id'];

$sql = "DELETE FROM prestamo
WHERE idPres = '$id'";

mysqli_query($conn,$sql);

header("Location: prestamo_listar.php");
exit();

?>