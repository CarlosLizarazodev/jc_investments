<?php

include("seguridad_admin.php");

include("../config/conexion.php");

if(!isset($_GET['id'])){

header("Location: retiro_listar.php");

exit();

}

$idRet=$_GET['id'];

$sql="

UPDATE retiro

SET estadoRet='APROBADO'

WHERE idRet='$idRet'

";

mysqli_query($conn,$sql);

header("Location: retiro_listar.php");

exit();

?>