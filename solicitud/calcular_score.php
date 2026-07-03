<?php

function calcularScore($conn,$idUsu){

$puntos=500;


/* antiguedad */

$usuario=mysqli_fetch_assoc(

mysqli_query($conn,"

SELECT *

FROM usuario

WHERE idUsu='$idUsu'

")

);

$dias=

floor(

(

time()

-

strtotime($usuario['fechaRegUsu'])

)

/

86400

);

if($dias>=180){

$puntos+=50;

}


/* pagos */

$pagos=mysqli_num_rows(

mysqli_query($conn,"

SELECT *

FROM pago

WHERE idUsu='$idUsu'

")

);

$puntos+=($pagos*5);


/* mora */

$mora=mysqli_num_rows(

mysqli_query($conn,"

SELECT c.*

FROM cuota c

INNER JOIN prestamo p

ON c.idPres=p.idPres

WHERE p.idUsu='$idUsu'

AND c.estadoCuo='MORA'

")

);

$puntos-=($mora*30);


/* prestamos activos */

$prestamos=mysqli_num_rows(

mysqli_query($conn,"

SELECT *

FROM prestamo

WHERE idUsu='$idUsu'

AND estadoPres='ACTIVO'

")

);

$puntos-=($prestamos*15);


/* limites */

if($puntos<300){

$puntos=300;

}

if($puntos>850){

$puntos=850;

}

return $puntos;

}