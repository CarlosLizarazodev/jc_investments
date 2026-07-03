<?php

include("../config/conexion.php");

$id = $_GET['id'];

$sql =
"SELECT * FROM usuario
WHERE idUsu = $id";

$resultado =
mysqli_query($conn,$sql);

$fila =
mysqli_fetch_assoc($resultado);

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Editar Usuario</title>
</head>

<body>

<h2>Editar Usuario</h2>

<form action="usuario_actualizar.php"
method="POST">

<input
type="hidden"
name="idUsu"
value="<?= $fila['idUsu'] ?>">

<input
type="text"
name="nomUsu1"
value="<?= $fila['nomUsu1'] ?>"
required>

<input
type="text"
name="nomUsu2"
value="<?= $fila['nomUsu2'] ?>">

<input
type="text"
name="apeUsu1"
value="<?= $fila['apeUsu1'] ?>"
required>

<input
type="text"
name="apeUsu2"
value="<?= $fila['apeUsu2'] ?>">

<input
type="text"
name="docUsu"
value="<?= $fila['docUsu'] ?>"
required>

<input
type="text"
name="telUsu"
value="<?= $fila['telUsu'] ?>">

<input
type="email"
name="emailUsu"
value="<?= $fila['emailUsu'] ?>"
required>

<select name="estadoUsu">

<option value="ACTIVO">
ACTIVO
</option>

<option value="INACTIVO">
INACTIVO
</option>

</select>

<input
type="number"
name="idRol"
value="<?= $fila['idRol'] ?>">

<button type="submit">
Actualizar
</button>

</form>

</body>
</html>