<?php

include("seguridad_admin.php");

include("../config/conexion.php");

if(!isset($_GET['id'])){

header("Location: retiro_listar.php");

exit();

}

$idRet=$_GET['id'];

$sqlBuscar="

SELECT *

FROM retiro

WHERE idRet='$idRet'

";

$resultado=mysqli_query($conn,$sqlBuscar);

$retiro=mysqli_fetch_assoc($resultado);

if(!$retiro){

header("Location: retiro_listar.php");

exit();

}

$idUsu=$retiro['idUsu'];

$valor=$retiro['valorRet'];



$sqlEstado="

UPDATE retiro

SET estadoRet='RECHAZADO'

WHERE idRet='$idRet'

";

mysqli_query($conn,$sqlEstado);



$sqlBilletera="

UPDATE billetera

SET saldo=saldo+'$valor'

WHERE idUsu='$idUsu'

";

mysqli_query($conn,$sqlBilletera);



$sqlMovimiento="

INSERT INTO movimiento(

idUsu,

tipoMov,

descripcionMov,

valorMov

)

VALUES(

'$idUsu',

'DEVOLUCION',

'Retiro rechazado por administrador',

'$valor'

)

";

mysqli_query($conn,$sqlMovimiento);



header("Location: retiro_listar.php");

exit();

?>