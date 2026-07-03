<?php

include("seguridad_admin.php");

include("../config/conexion.php");

$sql="

SELECT

r.*,

u.nomUsu1,

u.apeUsu1

FROM retiro r

INNER JOIN usuario u

ON r.idUsu=u.idUsu

ORDER BY r.fechaRet DESC

";

$retiros=mysqli_query($conn,$sql);

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Administrar Retiros</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-slate-100">

<div class="max-w-7xl mx-auto mt-10">

<div class="bg-white rounded-xl shadow p-8">

<div class="flex justify-between items-center mb-6">

<h1 class="text-3xl font-bold">

Administrar Retiros

</h1>

</div>

<div class="overflow-x-auto">

<table class="w-full">

<thead>

<tr class="bg-slate-200">

<th class="p-3">Cliente</th>

<th class="p-3">Banco</th>

<th class="p-3">Cuenta</th>

<th class="p-3">Valor</th>

<th class="p-3">Estado</th>

<th class="p-3">Acciones</th>

</tr>

</thead>

<tbody>

<?php

while($fila=mysqli_fetch_assoc($retiros)){

?>

<tr class="border-b">

<td class="p-3">

<?php

echo $fila['nomUsu1']." ".$fila['apeUsu1'];

?>

</td>

<td class="p-3">

<?php echo $fila['bancoRet']; ?>

</td>

<td class="p-3">

<?php echo $fila['cuentaRet']; ?>

</td>

<td class="p-3">

$<?php echo number_format($fila['valorRet'],0,",","."); ?>

</td>

<td class="p-3">

<?php echo $fila['estadoRet']; ?>

</td>

<td class="p-3 flex gap-2">

<a

href="retiro_aprobar.php?id=<?php echo $fila['idRet']; ?>"

class="bg-green-600 text-white px-3 py-1 rounded"

>

Aprobar

</a>

<a

href="retiro_rechazar.php?id=<?php echo $fila['idRet']; ?>"

class="bg-red-600 text-white px-3 py-1 rounded"

>

Rechazar

</a>

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>

</div>

</body>

</html>