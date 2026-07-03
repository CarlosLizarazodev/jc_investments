<?php

include("../config/conexion.php");

$id = $_GET['id'];

$solicitud = mysqli_query($conn,
"SELECT * FROM solicitud WHERE idSol = $id");

$fila = mysqli_fetch_assoc($solicitud);

$usuarios = mysqli_query($conn,"SELECT * FROM usuario");
$tipos = mysqli_query($conn,"SELECT * FROM tipoprestamo");
$estados = mysqli_query($conn,"SELECT * FROM estadosolicitud");

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Editar Solicitud</title>
</head>

<body>

<h2>Editar Solicitud</h2>

<form action="solicitud_actualizar.php" method="POST">

<input
type="hidden"
name="idSol"
value="<?= $fila['idSol'] ?>">

Usuario

<select name="idUsu">

<?php while($u=mysqli_fetch_assoc($usuarios)){ ?>

<option
value="<?= $u['idUsu'] ?>"
<?= ($u['idUsu']==$fila['idUsu']) ? 'selected' : '' ?>>

<?= $u['nomUsu1'] ?> <?= $u['apeUsu1'] ?>

</option>

<?php } ?>

</select>

<br><br>

Tipo de préstamo

<select name="idTipPres">

<?php while($tp=mysqli_fetch_assoc($tipos)){ ?>

<option
value="<?= $tp['idTipPres'] ?>"
<?= ($tp['idTipPres']==$fila['idTipPres']) ? 'selected' : '' ?>>

<?= $tp['nomTipPres'] ?>

</option>

<?php } ?>

</select>

<br><br>

Monto

<input
type="number"
step="0.01"
name="montoSol"
value="<?= $fila['montoSol'] ?>">

<br><br>

Plazo

<input
type="number"
name="plazoSol"
value="<?= $fila['plazoSol'] ?>">

<br><br>

Estado

<select name="idEstSol">

<?php while($e=mysqli_fetch_assoc($estados)){ ?>

<option
value="<?= $e['idEstSol'] ?>"
<?= ($e['idEstSol']==$fila['idEstSol']) ? 'selected' : '' ?>>

<?= $e['nomEstSol'] ?>

</option>

<?php } ?>

</select>

<br><br>

Observación

<textarea name="observSol"><?= $fila['observSol'] ?></textarea>

<br><br>

<button type="submit">
Actualizar
</button>

</form>

</body>
</html>