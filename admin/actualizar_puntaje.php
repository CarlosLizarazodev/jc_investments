<?php

include("../config/conexion.php");

function actualizarPuntaje($idUsu,$puntosNuevos){

global $conn;

$sqlBuscar="

SELECT *

FROM puntaje

WHERE idUsu='$idUsu'

LIMIT 1

";

$res=mysqli_query($conn,$sqlBuscar);

if(mysqli_num_rows($res)==0){

mysqli_query($conn,"

INSERT INTO puntaje(

idUsu,

puntos,

nivel

)

VALUES(

'$idUsu',

0,

'BRONCE'

)

");

}

mysqli_query($conn,"

UPDATE puntaje

SET puntos=puntos+'$puntosNuevos'

WHERE idUsu='$idUsu'

");

$sqlPuntaje="

SELECT *

FROM puntaje

WHERE idUsu='$idUsu'

LIMIT 1

";

$resPuntaje=mysqli_query($conn,$sqlPuntaje);

$datos=mysqli_fetch_assoc($resPuntaje);

$puntos=$datos['puntos'];

$nivel='BRONCE';

if($puntos>=100){

$nivel='PLATA';

}

if($puntos>=300){

$nivel='ORO';

}

if($puntos>=600){

$nivel='PLATINO';

}

if($puntos>=1000){

$nivel='DIAMANTE';

}

mysqli_query($conn,"

UPDATE puntaje

SET nivel='$nivel'

WHERE idUsu='$idUsu'

");

}

?>