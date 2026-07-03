<?php

include("../config/conexion.php");

$id = $_GET['id'];

$sql = "SELECT * FROM rol WHERE idRol = $id";

$resultado = mysqli_query($conn,$sql);

$fila = mysqli_fetch_assoc($resultado);

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Editar Rol</title>
</head>

<body>

<h2>Editar Rol</h2>

<form action="rol_actualizar.php" method="POST">

<input
type="hidden"
name="idRol"
value="<?= $fila['idRol'] ?>">

<input
type="text"
name="nomRol"
value="<?= $fila['nomRol'] ?>"
required>

<br><br>

<input
type="text"
name="descRol"
value="<?= $fila['descRol'] ?>">

<br><br>

<input
type="text"
name="codRol"
value="<?= $fila['codRol'] ?>"
required>

<br><br>

<button type="submit">
Actualizar
</button>

</form>

</body>
</html>