<?php

include("../config/conexion.php");

$idPres = $_POST['idPres'];
$montoPres = $_POST['montoPres'];
$tasaIntPres = $_POST['tasaIntPres'];
$plazoPres = $_POST['plazoPres'];
$fechaDesembolso = $_POST['fechaDesembolso'];
$fechaVenc = $_POST['fechaVenc'];
$saldoPres = $_POST['saldoPres'];
$estadoPres = $_POST['estadoPres'];

$sql = "UPDATE prestamo SET

montoPres = '$montoPres',
tasaIntPres = '$tasaIntPres',
plazoPres = '$plazoPres',
fechaDesembolso = '$fechaDesembolso',
fechaVenc = '$fechaVenc',
saldoPres = '$saldoPres',
estadoPres = '$estadoPres'

WHERE idPres = '$idPres'
";

mysqli_query($conn,$sql);

header("Location: prestamo_listar.php");
exit();

?>