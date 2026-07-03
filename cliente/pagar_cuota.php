<?php

include("seguridad_cliente.php");
include("../config/conexion.php");

$idUsu = $_SESSION['idUsu'];
$idCuo = $_GET['idCuo'];

/* OBTENER DATOS DE LA CUOTA */

$sql = "
    SELECT
        c.*,
        p.idPres,
        p.saldoPres
    FROM cuota c
    INNER JOIN prestamo p
    ON c.idPres = p.idPres
    WHERE
        c.idCuo  = '$idCuo'
    AND p.idUsu  = '$idUsu'
    LIMIT 1
";

$res   = mysqli_query($conn, $sql);
$cuota = mysqli_fetch_assoc($res);

if(!$cuota){
    header("Location: mis_cuotas.php");
    exit();
}

/* EVITAR PAGAR DOS VECES */

if($cuota['estadoCuo'] == "PAGADA"){
    header("Location: mis_cuotas.php");
    exit();
}

$valor  = $cuota['valorCuo'];
$idPres = $cuota['idPres'];

/* ACTUALIZAR CUOTA */

mysqli_query($conn, "
    UPDATE cuota
    SET estadoCuo = 'PAGADA'
    WHERE idCuo = '$idCuo'
");

/* REGISTRAR PAGO */

mysqli_query($conn, "
    INSERT INTO pago(
        idCuo,
        idUsu,
        valorPag,
        metodoPag,
        estadoPag
    )
    VALUES(
        '$idCuo',
        '$idUsu',
        '$valor',
        'SISTEMA',
        'REGISTRADO'
    )
");

/* ACTUALIZAR SALDO DEL PRESTAMO */

$nuevoSaldo = $cuota['saldoPres'] - $valor;

if($nuevoSaldo < 0){
    $nuevoSaldo = 0;
}

mysqli_query($conn, "
    UPDATE prestamo
    SET saldoPres = '$nuevoSaldo'
    WHERE idPres = '$idPres'
");

/* REGISTRAR MOVIMIENTO */

mysqli_query($conn, "
    INSERT INTO movimiento(
        idUsu,
        tipoMov,
        descripcionMov,
        valorMov
    )
    VALUES(
        '$idUsu',
        'PAGO',
        'Pago de cuota',
        '$valor'
    )
");

header("Location: mis_cuotas.php");
exit();

?>