<?php

include("../config/conexion.php");

$id = $_GET['id'];

$sql = "SELECT * FROM estadosolicitud
WHERE idEstSol = $id";

$resultado = mysqli_query($conn,$sql);

$fila = mysqli_fetch_assoc($resultado);

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Editar Estado</title>
</head>

<body>

<h2>Editar Estado de Solicitud</h2>

<form action="estadosolicitud_actualizar.php" method="POST">

<input
type="hidden"
name="idEstSol"
value="<?= $fila['idEstSol'] ?>">

<input
type="text"
name="nomEstSol"
value="<?= $fila['nomEstSol'] ?>"
required>

<br><br>

<input
type="text"
name="descEstSol"
value="<?= $fila['descEstSol'] ?>">

<br><br>

<input
type="text"
name="codEstSol"
value="<?= $fila['codEstSol'] ?>"
required>

<br><br>

<button type="submit">
Actualizar
</button>

</form>

</body>
</html>