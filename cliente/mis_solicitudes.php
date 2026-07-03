<?php

include("seguridad_cliente.php");
include("../config/conexion.php");

$idUsu = $_SESSION['idUsu'];

$sql = "SELECT *
FROM solicitud
WHERE idUsu='$idUsu'
ORDER BY idSol DESC";

$resultado = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Mis Solicitudes</title>

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
Mis Solicitudes
</h1>

<p class="text-slate-500 mb-6">
Consulta el estado de todas tus solicitudes.
</p>

<div class="overflow-x-auto">

<table class="w-full text-sm">

<thead>

<tr class="border-b bg-slate-100">

<th class="p-3 text-left">ID</th>
<th class="p-3 text-left">Tipo</th>
<th class="p-3 text-left">Monto</th>
<th class="p-3 text-left">Plazo</th>
<th class="p-3 text-left">Fecha</th>
<th class="p-3 text-left">Estado</th>
<th class="p-3 text-left">Observación</th>

</tr>

</thead>

<tbody>

<?php

if(mysqli_num_rows($resultado)>0){

while($fila=mysqli_fetch_assoc($resultado)){

$estado = strtoupper($fila['estadoSol']);

if($estado=="PENDIENTE"){

$badge="bg-yellow-100 text-yellow-700";

}elseif($estado=="APROBADA"){

$badge="bg-green-100 text-green-700";

}elseif($estado=="RECHAZADA"){

$badge="bg-red-100 text-red-700";

}else{

$badge="bg-slate-100 text-slate-700";

}

?>

<tr class="border-b hover:bg-slate-50">

<td class="p-3">
<?= $fila['idSol'] ?>
</td>

<td class="p-3">
<?= $fila['idTipPres'] ?>
</td>

<td class="p-3">
$ <?= number_format($fila['montoSol'],2) ?>
</td>

<td class="p-3">
<?= $fila['plazoSol'] ?> meses
</td>

<td class="p-3">
<?= $fila['fechaSol'] ?>
</td>

<td class="p-3">

<span class="px-3 py-1 rounded-full text-xs font-semibold <?= $badge ?>">

<?= $estado ?>

</span>

</td>

<td class="p-3">
<?= $fila['observSol'] ?>
</td>

</tr>

<?php

}

}else{

?>

<tr>

<td colspan="7" class="p-6 text-center text-slate-500">

No tienes solicitudes registradas.

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
