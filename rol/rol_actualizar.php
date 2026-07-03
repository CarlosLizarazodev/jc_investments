<?php

include("../config/conexion.php");

$idRol = $_POST['idRol'];

$sql = "UPDATE rol SET

nomRol = '".$_POST['nomRol']."',
descRol = '".$_POST['descRol']."',
codRol = '".$_POST['codRol']."'

WHERE idRol = $idRol";

mysqli_query($conn,$sql);

header("Location: rol_listar.php");
exit();

?>