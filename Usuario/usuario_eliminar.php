<?php

include("../config/conexion.php");

$id = $_GET['id'];

$sql =
"DELETE FROM usuario
WHERE idUsu = $id";

mysqli_query($conn,$sql);

header("Location:usuario_listar.php");