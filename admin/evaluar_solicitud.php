<?php

include("../config/conexion.php");

function evaluarSolicitud($idSol){

    global $conn;

    $sql = "
        SELECT
            s.*,
            u.idUsu
        FROM solicitud s
        INNER JOIN usuario u
        ON s.idUsu = u.idUsu
        WHERE s.idSol = '$idSol'
        LIMIT 1
    ";

    $res      = mysqli_query($conn, $sql);
    $solicitud = mysqli_fetch_assoc($res);

    if(!$solicitud){
        return;
    }

    $idUsu   = $solicitud['idUsu'];
    $puntaje = 40;

    $sqlNivel = "
        SELECT *
        FROM puntaje
        WHERE idUsu='$idUsu'
        LIMIT 1
    ";

    $resNivel = mysqli_query($conn, $sqlNivel);
    $nivel    = mysqli_fetch_assoc($resNivel);

    if($nivel){
        if($nivel['nivel'] == 'PLATA')   { $puntaje += 20; }
        if($nivel['nivel'] == 'ORO')     { $puntaje += 40; }
        if($nivel['nivel'] == 'PLATINO') { $puntaje += 60; }
        if($nivel['nivel'] == 'DIAMANTE'){ $puntaje += 80; }
    }

    $sqlPagos = "
        SELECT COUNT(*) total
        FROM pago
        WHERE idUsu='$idUsu'
    ";

    $resPagos   = mysqli_query($conn, $sqlPagos);
    $datosPagos = mysqli_fetch_assoc($resPagos);

    if($datosPagos['total'] >= 3){
        $puntaje += 20;
    }

    $sqlPendientes = "
        SELECT COUNT(*) total
        FROM cuota c
        INNER JOIN prestamo p
        ON c.idPres = p.idPres
        WHERE
            p.idUsu      = '$idUsu'
        AND c.estadoCuo  = 'PENDIENTE'
    ";

    $resPend   = mysqli_query($conn, $sqlPendientes);
    $datosPend = mysqli_fetch_assoc($resPend);

    if($datosPend['total'] <= 2){
        $puntaje += 20;
    }

    $riesgo       = 'ALTO';
    $recomendacion = 'RECHAZAR';

    if($puntaje >= 60){
        $riesgo       = 'MEDIO';
        $recomendacion = 'REVISAR';
    }

    if($puntaje >= 80){
        $riesgo       = 'BAJO';
        $recomendacion = 'APROBAR';
    }

    $detalle = 'Evaluacion automatica del sistema';

    mysqli_query($conn, "
        INSERT INTO evaluacion(
            idSol,
            puntaje,
            riesgo,
            recomendacion,
            detalle
        )
        VALUES(
            '$idSol',
            '$puntaje',
            '$riesgo',
            '$recomendacion',
            '$detalle'
        )
    ");

}

?>