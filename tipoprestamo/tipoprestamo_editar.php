<?php

include("../config/conexion.php");

$id = $_GET['id'];

$sql = "SELECT * FROM tipoprestamo
WHERE idTipPres = $id";

$resultado = mysqli_query($conn,$sql);

$fila = mysqli_fetch_assoc($resultado);

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Editar Tipo de Préstamo</title>
</head>

<body>

<h2>Editar Tipo de Préstamo</h2>

<form action="tipoprestamo_actualizar.php" method="POST">

<input
type="hidden"
name="idTipPres"
value="<?= $fila['idTipPres'] ?>">

Nombre:
<input
type="text"
name="nomTipPres"
value="<?= $fila['nomTipPres'] ?>"
required>

<br><br>

Descripción:
<input
type="text"
name="descTipPres"
value="<?= $fila['descTipPres'] ?>">

<br><br>

Tasa Interés:
<input
type="number"
step="0.01"
name="tasaInteres"
value="<?= $fila['tasaInteres'] ?>"
required>

<br><br>

Plazo Mínimo:
<input
type="number"
name="plazoMin"
value="<?= $fila['plazoMin'] ?>"
required>

<br><br>

Plazo Máximo:
<input
type="number"
name="plazoMax"
value="<?= $fila['plazoMax'] ?>"
required>

<br><br>

Monto Mínimo:
<input
type="number"
step="0.01"
name="montoMin"
value="<?= $fila['montoMin'] ?>"
required>

<br><br>

Monto Máximo:
<input
type="number"
step="0.01"
name="montoMax"
value="<?= $fila['montoMax'] ?>"
required>

<br><br>

Estado:
<input
type="text"
name="estadoTipPres"
value="<?= $fila['estadoTipPres'] ?>"
required>

<br><br>

<button type="submit">
Actualizar
</button>

</form>

</body>
</html>