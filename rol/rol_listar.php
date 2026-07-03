<?php
include("../admin/seguridad_admin.php");
include("../config/conexion.php");

$sql = "SELECT * FROM rol";
$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Roles</title>

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
    padding:10px;
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

<h1>Gestión de Roles</h1>

<form action="rol_guardar.php" method="POST">

<h3>Nuevo Rol</h3>

<input type="text"
name="nomRol"
placeholder="Nombre del Rol"
required>

<input type="text"
name="descRol"
placeholder="Descripción">

<input type="text"
name="codRol"
placeholder="Código del Rol"
required>

<button type="submit">
Guardar Rol
</button>

</form>

<hr>

<h3>Listado de Roles</h3>

<table>

<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Descripción</th>
    <th>Código</th>
    <th>Acciones</th>
</tr>

<?php while($fila = mysqli_fetch_assoc($resultado)){ ?>

<tr>

<td><?= $fila['idRol'] ?></td>
<td><?= $fila['nomRol'] ?></td>
<td><?= $fila['descRol'] ?></td>
<td><?= $fila['codRol'] ?></td>

<td>

<a href="rol_editar.php?id=<?= $fila['idRol'] ?>">
Editar
</a>

|

<a href="rol_eliminar.php?id=<?= $fila['idRol'] ?>">
Eliminar
</a>

</td>

</tr>

<?php } ?>

</table>

</body>
</html>