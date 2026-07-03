<?php

include("../admin/seguridad_admin.php");
include("../config/conexion.php");
include("../admin/actualizar_puntaje.php");

if(!isset($_GET['id'])){
    header("Location: solicitud_listar.php");
    exit();
}

$idSol = $_GET['id'];

$sqlSolicitud = "
    SELECT
        s.*,
        tp.tasaInteres
    FROM solicitud s
    INNER JOIN tipoprestamo tp
    ON s.idTipPres = tp.idTipPres
    WHERE s.idSol = '$idSol'
";

$resultado = mysqli_query($conn, $sqlSolicitud);
$solicitud = mysqli_fetch_assoc($resultado);

if(!$solicitud){
    header("Location: solicitud_listar.php");
    exit();
}

$idUsu = $solicitud['idUsu'];
$monto = $solicitud['montoSol'];
$plazo = $solicitud['plazoSol'];
$tasa  = $solicitud['tasaInteres'];

$fechaDesembolso = date("Y-m-d");
$fechaVenc       = date("Y-m-d", strtotime("+" . $plazo . " month"));

$sqlPrestamo = "
    INSERT INTO prestamo(
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
        '$monto',
        '$tasa',
        '$plazo',
        '$fechaDesembolso',
        '$fechaVenc',
        '$monto',
        'ACTIVO'
    )
";

mysqli_query($conn, $sqlPrestamo);

$idPres = mysqli_insert_id($conn);

$valorCuota = $monto / $plazo;

for($i = 1; $i <= $plazo; $i++){

    $fechaCuota = date("Y-m-d", strtotime("+" . $i . " month"));

    $capital = $valorCuota;
    $interes = ($monto * ($tasa / 100));
    $saldo   = $monto - ($capital * $i);

    if($saldo < 0){
        $saldo = 0;
    }

    $sqlCuota = "
        INSERT INTO cuota(
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
            '$i',
            '$fechaCuota',
            '$valorCuota',
            '$capital',
            '$interes',
            '$saldo',
            'PENDIENTE'
        )
    ";

    mysqli_query($conn, $sqlCuota);
}

// =====================
// CREAR BILLETERA
// =====================

$sqlBuscarBilletera = "
    SELECT *
    FROM billetera
    WHERE idUsu='$idUsu'
    LIMIT 1
";

$resBilletera = mysqli_query($conn, $sqlBuscarBilletera);

if(mysqli_num_rows($resBilletera) == 0){

    $sqlCrearBilletera = "
        INSERT INTO billetera(
            idUsu,
            saldo,
            estadoBil
        )
        VALUES(
            '$idUsu',
            0,
            'ACTIVA'
        )
    ";

    mysqli_query($conn, $sqlCrearBilletera);
}

// =====================
// DEPOSITAR DINERO
// =====================

$sqlDepositar = "
    UPDATE billetera
    SET saldo = saldo + '$monto'
    WHERE idUsu = '$idUsu'
";

mysqli_query($conn, $sqlDepositar);

// =====================
// REGISTRAR MOVIMIENTO
// =====================

$sqlMovimiento = "
    INSERT INTO movimiento(
        idUsu,
        tipoMov,
        descripcionMov,
        valorMov
    )
    VALUES(
        '$idUsu',
        'INGRESO',
        'Desembolso de prestamo aprobado',
        '$monto'
    )
";

mysqli_query($conn, $sqlMovimiento);

// =====================
// ACTUALIZAR SOLICITUD
// =====================

$sqlEstado = "
    UPDATE solicitud
    SET
        idEstSol  = 3,
        estadoSol = 'APROBADA'
    WHERE idSol = '$idSol'
";

mysqli_query($conn, $sqlEstado);

actualizarPuntaje($idUsu, 30);

header("Location: solicitud_listar.php");
exit();

?>