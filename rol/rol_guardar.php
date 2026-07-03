<?php

include("../config/conexion.php");

$nomRol = $_POST['nomRol'];
$descRol = $_POST['descRol'];
$codRol = $_POST['codRol'];

$sql = "INSERT INTO rol(
nomRol,
descRol,
codRol
)
VALUES(
'$nomRol',
'$descRol',
'$codRol'
)";

mysqli_query($conn, $sql);

header("Location: rol_listar.php");
exit();

?>