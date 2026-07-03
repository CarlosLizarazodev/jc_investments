<?php

include("../config/conexion.php");

$sql = "

SELECT

p.*,

CONCAT(
u.nomUsu1,' ',
u.apeUsu1
) AS cliente

FROM prestamo p

INNER JOIN usuario u
ON p.idUsu=u.idUsu

";

$resultado=mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<title>Reporte Prestamos</title>

<style>

body{
font-family:Arial;
margin:20px;
}

table{
width:100%;
border-collapse:collapse;
}

th,td{
border:1px solid #ccc;
padding:10px;
text-align:center;
}

th{
background:#f2f2f2;
}

</style>

</head>

<body>

<h1>Reporte de Préstamos</h1>

<table>

<tr>

<th>ID</th>
<th>Cliente</th>
<th>Monto</th>
<th>Saldo</th>
<th>Estado</th>

</tr>

<?php while($fila=mysqli_fetch_assoc($resultado)){ ?>

<tr>

<td><?= $fila['idPres'] ?></td>
<td><?= $fila['cliente'] ?></td>
<td><?= $fila['montoPres'] ?></td>
<td><?= $fila['saldoPres'] ?></td>
<td><?= $fila['estadoPres'] ?></td>

</tr>

<?php } ?>

</table>

</body>
</html>