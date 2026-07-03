<?php

include("../config/conexion.php");

$id = $_GET['id'];

$sql = "DELETE FROM rol WHERE idRol = $id";

mysqli_query($conn,$sql);

header("Location: rol_listar.php");
exit();

?>