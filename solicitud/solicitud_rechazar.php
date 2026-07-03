<?php

include("../admin/seguridad_admin.php");
include("../config/conexion.php");

if(!isset($_GET['id'])){

    header("Location: solicitud_listar.php");
    exit();

}

$id = $_GET['id'];

$sql = "

UPDATE solicitud

SET

idEstSol = 4,
estadoSol = 'RECHAZADA'

WHERE idSol = '$id'

";

mysqli_query($conn,$sql);

header("Location: solicitud_listar.php");
exit();

?>
