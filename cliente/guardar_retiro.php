<?php

include("seguridad_cliente.php");

include("../config/conexion.php");

$idUsu=$_SESSION['idUsu'];

$banco=$_POST['bancoRet'];

$cuenta=$_POST['cuentaRet'];

$titular=$_POST['titularRet'];

$valor=$_POST['valorRet'];



// Buscar billetera

$sqlBilletera="

SELECT *

FROM billetera

WHERE idUsu='$idUsu'

LIMIT 1

";

$res=mysqli_query($conn,$sqlBilletera);

$billetera=mysqli_fetch_assoc($res);



if(!$billetera){

die("No existe billetera");

}



$saldo=$billetera['saldo'];



// Validar saldo

if($valor>$saldo){

die("Saldo insuficiente");

}



// Guardar retiro

$sqlRetiro="

INSERT INTO retiro(

idUsu,

bancoRet,

cuentaRet,

titularRet,

valorRet,

estadoRet

)

VALUES(

'$idUsu',

'$banco',

'$cuenta',

'$titular',

'$valor',

'PENDIENTE'

)

";

mysqli_query($conn,$sqlRetiro);



// Descontar dinero

$sqlDescontar="

UPDATE billetera

SET saldo=saldo-'$valor'

WHERE idUsu='$idUsu'

";

mysqli_query($conn,$sqlDescontar);



// Registrar movimiento

$sqlMovimiento="

INSERT INTO movimiento(

idUsu,

tipoMov,

descripcionMov,

valorMov

)

VALUES(

'$idUsu',

'RETIRO',

'Retiro solicitado a banco',

'$valor'

)

";

mysqli_query($conn,$sqlMovimiento);



header("Location: dashboard_cliente.php");

exit();

?>