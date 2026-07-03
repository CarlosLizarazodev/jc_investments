<?php

include("../config/conexion.php");

$idSol = $_GET['idSol'];


/* ==========================
OBTENER DATOS DE LA SOLICITUD
========================== */

$sql = "

SELECT
s.idSol,
s.idUsu,
s.montoSol,
s.plazoSol,

u.nomUsu1,
u.apeUsu1,
u.estadoUsu,
u.fechaRegUsu

FROM solicitud s

INNER JOIN usuario u
ON s.idUsu=u.idUsu

WHERE s.idSol='$idSol'

";

$res = mysqli_query($conn,$sql);

$datos = mysqli_fetch_assoc($res);

if(!$datos){

header("Location: solicitud_listar.php");
exit();

}


/* ==========================
INICIAR PUNTAJE
========================== */

$puntaje=0;


/* ==========================
ANTIGUEDAD DEL CLIENTE
========================== */

$fechaRegistro = strtotime($datos['fechaRegUsu']);

$dias = floor(

(time()-$fechaRegistro)

/

(60*60*24)

);

if($dias>=365){

$puntaje+=30;

}
elseif($dias>=180){

$puntaje+=20;

}
elseif($dias>=90){

$puntaje+=10;

}



/* ==========================
MONTO SOLICITADO
========================== */

if($datos['montoSol']<=5000000){

$puntaje+=30;

}
elseif($datos['montoSol']<=10000000){

$puntaje+=20;

}
elseif($datos['montoSol']<=20000000){

$puntaje+=10;

}



/* ==========================
PLAZO
========================== */

if($datos['plazoSol']<=12){

$puntaje+=25;

}
elseif($datos['plazoSol']<=24){

$puntaje+=15;

}
else{

$puntaje+=5;

}



/* ==========================
HISTORIAL DE PRÉSTAMOS
========================== */

$sqlPrestamos="

SELECT COUNT(*) total

FROM prestamo

WHERE idUsu='".$datos['idUsu']."'

AND estadoPres='ACTIVO'

";

$resPrestamos=mysqli_query($conn,$sqlPrestamos);

$rowPrestamos=mysqli_fetch_assoc($resPrestamos);

$totalPrestamos=$rowPrestamos['total'];

if($totalPrestamos==0){

$puntaje+=20;

}
elseif($totalPrestamos<=2){

$puntaje+=10;

}
else{

$puntaje-=20;

}



/* ==========================
DECISIÓN FINAL
========================== */

if($puntaje>=70){

$idEstado=3;

}
elseif($puntaje>=50){

$idEstado=2;

}
else{

$idEstado=4;

}



/* ==========================
ACTUALIZAR SOLICITUD
========================== */

$sqlUpdate="

UPDATE solicitud

SET

idEstSol='$idEstado'

WHERE idSol='$idSol'

";

mysqli_query($conn,$sqlUpdate);



/* ==========================
SI FUE APROBADA
CREAR PRÉSTAMO
========================== */

if($idEstado==3){

$sqlExiste="

SELECT *

FROM prestamo

WHERE idSol='$idSol'

";

$resExiste=mysqli_query($conn,$sqlExiste);

if(mysqli_num_rows($resExiste)==0){

$fechaHoy=date("Y-m-d");

$fechaVenc=date(

"Y-m-d",

strtotime("+".$datos['plazoSol']." month")

);

$sqlPrestamo="

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

'".$datos['idSol']."',

'".$datos['idUsu']."',

'".$datos['montoSol']."',

2.5,

'".$datos['plazoSol']."',

'$fechaHoy',

'$fechaVenc',

'".$datos['montoSol']."',

'ACTIVO'

)

";

mysqli_query($conn,$sqlPrestamo);

}

}



header("Location: solicitud_listar.php");

exit();

?>