<?php

include("seguridad_cliente.php");
include("../config/conexion.php");
include("../admin/evaluar_solicitud.php");

$idUsu     = $_SESSION['idUsu'];
$idTipPres = $_POST['idTipPres'];
$montoSol  = $_POST['montoSol'];
$plazoSol  = $_POST['plazoSol'];
$observSol = $_POST['observSol'];

/* ==========================
   GUARDAR SOLICITUD
========================== */

mysqli_query($conn, "
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
        '$montoSol',
        '$plazoSol',
        '$observSol',
        'PENDIENTE',
        1
    )
");

$idSol = mysqli_insert_id($conn);

/* ==========================
   EVALUAR SOLICITUD
========================== */

evaluarSolicitud($idSol);

/* ==========================
   OBTENER RESULTADO
========================== */

$evaluacion = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "
        SELECT *
        FROM evaluacion
        WHERE idSol='$idSol'
        ORDER BY idEva DESC
        LIMIT 1
        "
    )
);

if($evaluacion){

    if($evaluacion['recomendacion'] == 'APROBAR'){

        mysqli_query($conn, "
            UPDATE solicitud
            SET
                estadoSol = 'APROBADA',
                idEstSol  = 3
            WHERE idSol = '$idSol'
        ");

        /* OBTENER DATOS DEL TIPO DE PRESTAMO */

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
        $fechaVenc       = date('Y-m-d', strtotime("+$plazoSol month"));

        /* CREAR PRESTAMO */

        mysqli_query($conn, "
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
                '$montoSol',
                '$tasa',
                '$plazoSol',
                '$fechaDesembolso',
                '$fechaVenc',
                '$montoSol',
                'ACTIVO'
            )
        ");

        $idPres = mysqli_insert_id($conn);

        /* CREAR CUOTAS */

        $valorCuota = $montoSol / $plazoSol;

        for($i = 1; $i <= $plazoSol; $i++){

            $fechaCuota = date('Y-m-d', strtotime("+$i month"));
            $capital    = $valorCuota;
            $interes    = ($montoSol * ($tasa / 100));
            $saldo      = $montoSol - ($capital * $i);

            if($saldo < 0){
                $saldo = 0;
            }

            mysqli_query($conn, "
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
            ");
        }

        /* ACTUALIZAR BILLETERA */

        $billetera = mysqli_fetch_assoc(
            mysqli_query(
                $conn,
                "
                SELECT *
                FROM billetera
                WHERE idUsu='$idUsu'
                LIMIT 1
                "
            )
        );

        if($billetera){

            mysqli_query($conn, "
                UPDATE billetera
                SET saldo = saldo + '$montoSol'
                WHERE idUsu = '$idUsu'
            ");

        }
        else{

            mysqli_query($conn, "
                INSERT INTO billetera(
                    idUsu,
                    saldo
                )
                VALUES(
                    '$idUsu',
                    '$montoSol'
                )
            ");

        }

        /* GUARDAR MOVIMIENTO */

        mysqli_query($conn, "
            INSERT INTO movimiento(
                idUsu,
                tipoMov,
                descripcionMov,
                valorMov
            )
            VALUES(
                '$idUsu',
                'INGRESO',
                'Prestamo aprobado automaticamente',
                '$montoSol'
            )
        ");

    }

    elseif($evaluacion['recomendacion'] == 'REVISAR'){

        mysqli_query($conn, "
            UPDATE solicitud
            SET
                estadoSol = 'REVISION',
                idEstSol  = 2
            WHERE idSol = '$idSol'
        ");

    }

    else{

        mysqli_query($conn, "
            UPDATE solicitud
            SET
                estadoSol = 'RECHAZADA',
                idEstSol  = 4
            WHERE idSol = '$idSol'
        ");

    }

}

header("Location: mis_solicitudes.php");
exit();

?>