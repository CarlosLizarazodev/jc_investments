<?php
include("../config/conexion.php");

$sql = "SELECT * FROM tipoprestamo";
$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Tipos de Préstamo</title>

<style>
body{
    font-family: Arial;
    margin:20px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    border:1px solid #ccc;
    padding:8px;
    text-align:center;
}

input{
    width:100%;
    padding:8px;
    margin-bottom:10px;
}

button{
    padding:10px 20px;
}
</style>

</head>
<body>

<h1>Gestión de Tipos de Préstamo</h1>

<form action="tipoprestamo_guardar.php" method="POST">

<input type="text" name="nomTipPres" placeholder="Nombre" required>

<input type="text" name="descTipPres" placeholder="Descripción">

<input type="number" step="0.01" name="tasaInteres" placeholder="Tasa de Interés" required>

<input type="number" name="plazoMin" placeholder="Plazo Mínimo" required>

<input type="number" name="plazoMax" placeholder="Plazo Máximo" required>

<input type="number" step="0.01" name="montoMin" placeholder="Monto Mínimo" required>

<input type="number" step="0.01" name="montoMax" placeholder="Monto Máximo" required>

<input type="text" name="estadoTipPres" placeholder="Estado" value="ACTIVO" required>

<button type="submit">
Guardar
</button>

</form>

<hr>

<table>

<tr>
<th>ID</th>
<th>Nombre</th>
<th>Tasa</th>
<th>Plazo Min</th>
<th>Plazo Max</th>
<th>Monto Min</th>
<th>Monto Max</th>
<th>Estado</th>
<th>Acciones</th>
</tr>

<?php while($fila = mysqli_fetch_assoc($resultado)){ ?>

<tr>

<td><?= $fila['idTipPres'] ?></td>
<td><?= $fila['nomTipPres'] ?></td>
<td><?= $fila['tasaInteres'] ?></td>
<td><?= $fila['plazoMin'] ?></td>
<td><?= $fila['plazoMax'] ?></td>
<td><?= $fila['montoMin'] ?></td>
<td><?= $fila['montoMax'] ?></td>
<td><?= $fila['estadoTipPres'] ?></td>

<td>
<a href="tipoprestamo_editar.php?id=<?= $fila['idTipPres'] ?>">Editar</a>
|
<a href="tipoprestamo_eliminar.php?id=<?= $fila['idTipPres'] ?>">Eliminar</a>
</td>

</tr>

<?php } ?>

</table>

</body>
</html>