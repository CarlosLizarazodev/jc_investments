<?php

include("../config/conexion.php");

$id = $_GET['id'];

$sql = "SELECT * FROM prestamo
WHERE idPres = '$id'";

$resultado = mysqli_query($conn,$sql);

$fila = mysqli_fetch_assoc($resultado);

?>

<!DOCTYPE html>
<html lang="es">
<head>

<meta charset="UTF-8">
<title>Editar Préstamo</title>

<style>

body{
font-family:Arial;
margin:20px;
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

<h1>Editar Préstamo</h1>

<form action="prestamo_actualizar.php" method="POST">

<input
type="hidden"
name="idPres"
value="<?= $fila['idPres'] ?>"
>

<label>Monto</label>

<input
type="number"
step="0.01"
name="montoPres"
value="<?= $fila['montoPres'] ?>"
required
>

<label>Tasa de Interés</label>

<input
type="number"
step="0.01"
name="tasaIntPres"
value="<?= $fila['tasaIntPres'] ?>"
required
>

<label>Plazo</label>

<input
type="number"
name="plazoPres"
value="<?= $fila['plazoPres'] ?>"
required
>

<label>Fecha Desembolso</label>

<input
type="date"
name="fechaDesembolso"
value="<?= $fila['fechaDesembolso'] ?>"
required
>

<label>Fecha Vencimiento</label>

<input
type="date"
name="fechaVenc"
value="<?= $fila['fechaVenc'] ?>"
required
>

<label>Saldo</label>

<input
type="number"
step="0.01"
name="saldoPres"
value="<?= $fila['saldoPres'] ?>"
required
>

<label>Estado</label>

<input
type="text"
name="estadoPres"
value="<?= $fila['estadoPres'] ?>"
required
>

<button type="submit">
Actualizar
</button>

</form>

</body>
</html>