<?php

include("../config/conexion.php");

$sql = "SELECT * FROM usuario";
$resultado = mysqli_query($conn,$sql);

?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<title>Reporte Usuarios</title>

<style>

body{
font-family:Arial;
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

th{
background:#f2f2f2;
}

</style>

</head>

<body>

<h1>Reporte de Usuarios</h1>

<table>

<tr>

<th>ID</th>
<th>Nombre</th>
<th>Documento</th>
<th>Correo</th>
<th>Estado</th>
<th>Rol</th>

</tr>

<?php while($fila=mysqli_fetch_assoc($resultado)){ ?>

<tr>

<td><?= $fila['idUsu'] ?></td>

<td>
<?= $fila['nomUsu1']." ".$fila['apeUsu1'] ?>
</td>

<td><?= $fila['docUsu'] ?></td>

<td><?= $fila['emailUsu'] ?></td>

<td><?= $fila['estadoUsu'] ?></td>

<td><?= $fila['idRol'] ?></td>

</tr>

<?php } ?>

</table>

</body>
</html>