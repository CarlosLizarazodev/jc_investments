<?php
include("seguridad_cliente.php");
include("../config/conexion.php");

$tipos = mysqli_query($conn,"
SELECT *
FROM tipoprestamo
ORDER BY nomTipPres
");
?>

<!DOCTYPE html>

<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Nueva Solicitud</title>

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

<div class="max-w-4xl mx-auto p-6">

<div class="bg-white rounded-2xl shadow-sm border p-8">

<h1 class="font-display text-3xl font-bold text-[#0c1f3f] mb-2">
Nueva Solicitud
</h1>

<p class="text-slate-500 mb-8">
Solicita un nuevo préstamo.
</p>

<form action="guardar_solicitud_cliente.php" method="POST" class="space-y-6">

<div>
<label class="block text-sm font-semibold mb-2">
Tipo de Préstamo
</label>

<select
name="idTipPres"
required
class="w-full border rounded-lg px-4 py-3">

<option value="">
Seleccione...
</option>

<?php while($tp=mysqli_fetch_assoc($tipos)){ ?>

<option value="<?= $tp['idTipPres'] ?>">
<?= $tp['nomTipPres'] ?>
</option>

<?php } ?>

</select>
</div>

<div>
<label class="block text-sm font-semibold mb-2">
Monto Solicitado
</label>

<input
type="number"
name="montoSol"
step="0.01"
required
class="w-full border rounded-lg px-4 py-3">

</div>

<div>
<label class="block text-sm font-semibold mb-2">
Plazo (Meses)
</label>

<input
type="number"
name="plazoSol"
required
class="w-full border rounded-lg px-4 py-3">

</div>

<div>
<label class="block text-sm font-semibold mb-2">
Observación
</label>

<textarea
name="observSol"
rows="5"
class="w-full border rounded-lg px-4 py-3"></textarea>

</div>

<div class="flex gap-3">

<button
type="submit"
class="bg-[#0c1f3f] hover:bg-[#16376d] text-white font-semibold px-6 py-3 rounded-lg">

Enviar Solicitud

</button>

<a
href="dashboard_cliente.php"
class="bg-slate-200 hover:bg-slate-300 px-6 py-3 rounded-lg font-semibold">

Volver

</a>

</div>

</form>

</div>

</div>

</body>
</html>
