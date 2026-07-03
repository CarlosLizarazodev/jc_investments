<?php

include("../config/conexion.php");

$sql = "INSERT INTO tipoprestamo(

nomTipPres,
descTipPres,
tasaInteres,
plazoMin,
plazoMax,
montoMin,
montoMax,
estadoTipPres

)

VALUES(

'".$_POST['nomTipPres']."',
'".$_POST['descTipPres']."',
'".$_POST['tasaInteres']."',
'".$_POST['plazoMin']."',
'".$_POST['plazoMax']."',
'".$_POST['montoMin']."',
'".$_POST['montoMax']."',
'".$_POST['estadoTipPres']."'

)";

mysqli_query($conn,$sql);

header("Location: tipoprestamo_listar.php");
exit();

?>