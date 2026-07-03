<?php

include("seguridad_cliente.php");
include("../config/conexion.php");

$idUsu = $_SESSION['idUsu'];

$sql = "

SELECT *

FROM prestamo

WHERE idUsu = '$idUsu'

ORDER BY idPres DESC

";

$resultado = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Mis Préstamos</title>

<script src="https://cdn.tailwindcss.com"></script>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>

body{
font-family:'Inter',sans-serif;
}

.font-display{
font-family:'Playfair Display',serif;
}

</style>

</head>

<body class="bg-slate-50">

<div class="max-w-7xl mx-auto p-6">

<div class="bg-white rounded-2xl shadow-sm border p-6">

<h1 class="font-display text-3xl font-bold text-[#0c1f3f] mb-2">
Mis Préstamos
</h1>

<p class="text-slate-500 mb-6">
Consulta el estado actual de todos tus préstamos.
</p>

<div class="overflow-x-auto">

<table class="w-full text-sm">

<thead>

<tr class="border-b bg-slate-100">

<th class="p-3 text-left">ID</th>
<th class="p-3 text-left">Monto</th>
<th class="p-3 text-left">Tasa</th>
<th class="p-3 text-left">Plazo</th>
<th class="p-3 text-left">Desembolso</th>
<th class="p-3 text-left">Vencimiento</th>
<th class="p-3 text-left">Saldo</th>
<th class="p-3 text-left">Estado</th>

</tr>

</thead>

<tbody>

<?php

if(mysqli_num_rows($resultado)>0){

while($fila=mysqli_fetch_assoc($resultado)){

$estado = strtoupper($fila['estadoPres']);

if($estado=="ACTIVO"){

$badge="bg-green-100 text-green-700";

}elseif($estado=="PAGADO"){

$badge="bg-blue-100 text-blue-700";

}elseif($estado=="VENCIDO"){

$badge="bg-red-100 text-red-700";

}else{

$badge="bg-slate-100 text-slate-700";

}

?>

<tr class="border-b hover:bg-slate-50">

<td class="p-3">
<?= $fila['idPres'] ?>
</td>

<td class="p-3">
$ <?= number_format($fila['montoPres'],2) ?>
</td>

<td class="p-3">
<?= $fila['tasaIntPres'] ?>%
</td>

<td class="p-3">
<?= $fila['plazoPres'] ?>
</td>

<td class="p-3">
<?= $fila['fechaDesembolso'] ?>
</td>

<td class="p-3">
<?= $fila['fechaVenc'] ?>
</td>

<td class="p-3">
$ <?= number_format($fila['saldoPres'],2) ?>
</td>

<td class="p-3">

<span class="px-3 py-1 rounded-full text-xs font-semibold <?= $badge ?>">

<?= $estado ?>

</span>

</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="8" class="p-6 text-center text-slate-500">

No tienes préstamos registrados.

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

<div class="mt-6">

<a
href="dashboard_cliente.php"
class="inline-block bg-[#0c1f3f] hover:bg-[#16376d] text-white font-semibold px-5 py-3 rounded-lg">

Volver al Dashboard

</a>

</div>

</div>

</div>

</body>

</html>
