<?php

include("seguridad_cliente.php");

include("../config/conexion.php");

$idUsu=$_SESSION['idUsu'];

$sql="

SELECT *

FROM movimiento

WHERE idUsu='$idUsu'

ORDER BY fechaMov DESC

";

$movimientos=mysqli_query($conn,$sql);

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Mis movimientos</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-slate-100">

<div class="max-w-6xl mx-auto mt-10">

<div class="bg-white rounded-xl shadow p-8">

<div class="flex justify-between items-center mb-6">

<h1 class="text-3xl font-bold">

Mis Movimientos

</h1>

<a

href="dashboard_cliente.php"

class="bg-blue-600 text-white px-4 py-2 rounded-lg"

>

Volver

</a>

</div>

<div class="overflow-x-auto">

<table class="w-full">

<thead>

<tr class="bg-slate-200">

<th class="p-3 text-left">

Tipo

</th>

<th class="p-3 text-left">

Descripción

</th>

<th class="p-3 text-left">

Valor

</th>

<th class="p-3 text-left">

Fecha

</th>

</tr>

</thead>

<tbody>

<?php

while($fila=mysqli_fetch_assoc($movimientos)){

?>

<tr class="border-b">

<td class="p-3">

<?php echo $fila['tipoMov']; ?>

</td>

<td class="p-3">

<?php echo $fila['descripcionMov']; ?>

</td>

<td class="p-3 font-bold">

$<?php echo number_format($fila['valorMov'],0,",","."); ?>

</td>

<td class="p-3">

<?php echo $fila['fechaMov']; ?>

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