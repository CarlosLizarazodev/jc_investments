<?php

include("../config/conexion.php");

$datos = explode("|", $_POST['datosSolicitud']);

$idSol = $datos[0];
$idUsu = $datos[1];
$montoPres = $datos[2];
$plazoPres = $datos[3];

$tasaIntPres = $_POST['tasaIntPres'];
$fechaDesembolso = $_POST['fechaDesembolso'];
$fechaVencimiento = $_POST['fechaVencimiento'];

$saldoPres = $montoPres;
$estadoPres = "ACTIVO";

$sql = "INSERT INTO prestamo(
    idSol,
    idUsu,
    montoPres,
    tasaIntPres,
    plazoPres,
    fechaDesembolso,
    fechaVenc,
    saldoPres,
    estadoPres
)
VALUES(
    '$idSol',
    '$idUsu',
    '$montoPres',
    '$tasaIntPres',
    '$plazoPres',
    '$fechaDesembolso',
    '$fechaVencimiento',
    '$saldoPres',
    '$estadoPres'
)";

if(!mysqli_query($conn,$sql)){
    die("Error al guardar préstamo: " . mysqli_error($conn));
}

$idPres = mysqli_insert_id($conn);

$P = (float)$montoPres;
$i = ((float)$tasaIntPres) / 100;
$n = (int)$plazoPres;

$cuota = ($P * ($i * pow((1 + $i), $n))) /
         (pow((1 + $i), $n) - 1);

$saldo = $P;

for($num = 1; $num <= $n; $num++){

    $interes = $saldo * $i;

    $capital = $cuota - $interes;

    $saldo = $saldo - $capital;

    if($saldo < 0){
        $saldo = 0;
    }

    $fechaVencCuo = date(
        'Y-m-d',
        strtotime($fechaDesembolso . " +$num month")
    );

    $sqlCuota = "INSERT INTO cuota(
        idPres,
        numCuo,
        fechaVencCuo,
        valorCuo,
        capitalCuo,
        interesCuo,
        saldoCuo,
        estadoCuo
    )
    VALUES(
        '$idPres',
        '$num',
        '$fechaVencCuo',
        '$cuota',
        '$capital',
        '$interes',
        '$saldo',
        'PENDIENTE'
    )";

    if(!mysqli_query($conn,$sqlCuota)){
        die("Error al generar cuota #".$num.": ".mysqli_error($conn));
    }
}

header("Location: prestamo_listar.php");
exit();

?>
