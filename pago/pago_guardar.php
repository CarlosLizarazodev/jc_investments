```php
<?php

include("../config/conexion.php");

$datos = explode("|", $_POST['datosCuota']);

$idCuo = $datos[0];
$idUsu = $datos[1];
$valorPag = $datos[2];

$metodoPag = $_POST['metodoPag'];
$refPag = $_POST['refPag'];

$estadoPag = "REGISTRADO";

/*
|--------------------------------------------------------------------------
| GUARDAR PAGO
|--------------------------------------------------------------------------
*/

$sqlPago = "INSERT INTO pago(

idCuo,
idUsu,
valorPag,
metodoPag,
refPag,
estadoPag

)

VALUES(

'$idCuo',
'$idUsu',
'$valorPag',
'$metodoPag',
'$refPag',
'$estadoPag'

)";

if(!mysqli_query($conn,$sqlPago)){
    die("Error al registrar pago: ".mysqli_error($conn));
}

/*
|--------------------------------------------------------------------------
| MARCAR CUOTA COMO PAGADA
|--------------------------------------------------------------------------
*/

$sqlCuota = "UPDATE cuota
SET estadoCuo='PAGADA'
WHERE idCuo='$idCuo'";

if(!mysqli_query($conn,$sqlCuota)){
    die("Error al actualizar cuota: ".mysqli_error($conn));
}

/*
|--------------------------------------------------------------------------
| OBTENER DATOS DEL PRÉSTAMO
|--------------------------------------------------------------------------
*/

$sqlDatos = "
SELECT
    c.idPres,
    c.capitalCuo,
    p.saldoPres
FROM cuota c
INNER JOIN prestamo p
    ON c.idPres = p.idPres
WHERE c.idCuo='$idCuo'
";

$resultadoDatos = mysqli_query($conn,$sqlDatos);

$fila = mysqli_fetch_assoc($resultadoDatos);

$idPres = $fila['idPres'];
$capitalCuo = $fila['capitalCuo'];
$saldoActual = $fila['saldoPres'];

/*
|--------------------------------------------------------------------------
| ACTUALIZAR SALDO DEL PRÉSTAMO
|--------------------------------------------------------------------------
*/

$nuevoSaldo = $saldoActual - $capitalCuo;

if($nuevoSaldo < 0){
    $nuevoSaldo = 0;
}

$sqlPrestamo = "
UPDATE prestamo
SET saldoPres='$nuevoSaldo'
WHERE idPres='$idPres'
";

if(!mysqli_query($conn,$sqlPrestamo)){
    die("Error al actualizar saldo del préstamo: ".mysqli_error($conn));
}

/*
|--------------------------------------------------------------------------
| VALIDAR SI QUEDAN CUOTAS PENDIENTES
|--------------------------------------------------------------------------
*/

$sqlPendientes = "
SELECT COUNT(*) AS total
FROM cuota
WHERE idPres='$idPres'
AND estadoCuo='PENDIENTE'
";

$resultadoPendientes = mysqli_query($conn,$sqlPendientes);

$filaPendientes = mysqli_fetch_assoc($resultadoPendientes);

if($filaPendientes['total'] == 0){

    $sqlFinalizar = "
    UPDATE prestamo
    SET
        estadoPres='FINALIZADO',
        saldoPres='0'
    WHERE idPres='$idPres'
    ";

    mysqli_query($conn,$sqlFinalizar);
}

header("Location: pago_listar.php");
exit();

?>
```
