<?php

include("../config/conexion.php");

$idTipPres = $_POST['idTipPres'];

$sql = "UPDATE tipoprestamo SET

nomTipPres = '".$_POST['nomTipPres']."',
descTipPres = '".$_POST['descTipPres']."',
tasaInteres = '".$_POST['tasaInteres']."',
plazoMin = '".$_POST['plazoMin']."',
plazoMax = '".$_POST['plazoMax']."',
montoMin = '".$_POST['montoMin']."',
montoMax = '".$_POST['montoMax']."',
estadoTipPres = '".$_POST['estadoTipPres']."'

WHERE idTipPres = $idTipPres";

mysqli_query($conn,$sql);

header("Location: tipoprestamo_listar.php");
exit();

?>