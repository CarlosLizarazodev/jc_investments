<?php

include("seguridad_cliente.php");
include("../config/conexion.php");
include("../admin/evaluar_solicitud.php");

/* =========================
   DECISION AUTOMATICA
========================= */

if($score >= 650){
    $idEstado   = 2;
    $estadoTexto = "APROBADA";
}
elseif($score >= 500){
    $idEstado   = 1;
    $estadoTexto = "REVISION";
}
else{
    $idEstado   = 3;
    $estadoTexto = "RECHAZADA";
}

/* =========================
   GUARDAR SOLICITUD
========================= */

mysqli_query(
    $conn,
    "
    INSERT INTO solicitud(
        idUsu,
        idTipPres,
        montoSol,
        plazoSol,
        observSol,
        estadoSol,
        idEstSol
    )
    VALUES(
        '$idUsu',
        '$idTipPres',
        '$monto',
        '$plazo',
        '$observacion',
        '$estadoTexto',
        '$idEstado'
    )
    "
);

/* =========================
   OBTENER ID SOLICITUD
========================= */

$idSol = mysqli_insert_id($conn);

evaluarSolicitud($idSol);

/* =========================
   SI SE APRUEBA
   CREAR PRESTAMO
========================= */

if($estadoTexto == "APROBADA"){

    $tipo = mysqli_fetch_assoc(
        mysqli_query(
            $conn,
            "
            SELECT *
            FROM tipoprestamo
            WHERE idTipPres='$idTipPres'
            "
        )
    );

    $tasa            = $tipo['tasaInteres'];
    $fechaDesembolso = date('Y-m-d');
    $fechaVenc       = date('Y-m-d', strtotime("+$plazo month"));

    mysqli_query(
        $conn,
        "
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
        "
    );

}

header("Location: solicitud_listar.php");
exit();

?>