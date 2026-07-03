<?php
include("../config/conexion.php");

$sql = "SELECT * FROM estadosolicitud";
$resultado = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Estados de Solicitud</title>

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

<h1>Gestión de Estados de Solicitud</h1>

<form action="estadosolicitud_guardar.php" method="POST">

<h3>Nuevo Estado</h3>

<input
type="text"
name="nomEstSol"
placeholder="Nombre del Estado"
required>

<input
type="text"
name="descEstSol"
placeholder="Descripción">

<input
type="text"
name="codEstSol"
placeholder="Código"
required>

<button type="submit">
Guardar Estado
</button>

</form>

<hr>

<h3>Listado</h3>

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

<td><?= $fila['idEstSol'] ?></td>
<td><?= $fila['nomEstSol'] ?></td>
<td><?= $fila['descEstSol'] ?></td>
<td><?= $fila['codEstSol'] ?></td>

<td>

<a href="estadosolicitud_editar.php?id=<?= $fila['idEstSol'] ?>">
Editar
</a>

|

<a href="estadosolicitud_eliminar.php?id=<?= $fila['idEstSol'] ?>">
Eliminar
</a>

</td>

</tr>

<?php } ?>

</table>

</body>
</html>