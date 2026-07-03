<?php

include("../admin/seguridad_admin.php");

include("../config/conexion.php");

$roles = mysqli_query($conn,"
SELECT *
FROM rol
ORDER BY nomRol
");

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Nuevo Usuario</title>

<style>

*{
box-sizing:border-box;
margin:0;
padding:0;
font-family:'Segoe UI',sans-serif;
}

body{
background:#0d1b2e;
color:#fff;
}

.container{

max-width:900px;

margin:40px auto;

background:#122033;

padding:30px;

border-radius:15px;

}

h1{

margin-bottom:25px;

}

.form-grid{

display:grid;

grid-template-columns:1fr 1fr;

gap:15px;

}

input,select{

width:100%;

padding:12px;

border:none;

border-radius:8px;

background:#0d1b2e;

color:#fff;

}

.btns{

display:flex;

gap:15px;

margin-top:25px;

}

button{

padding:12px 25px;

border:none;

border-radius:8px;

cursor:pointer;

font-weight:600;

}

.guardar{

background:#7c3aed;

color:white;

}

.guardar:hover{

background:#6d28d9;

}

.volver{

background:#2563eb;

color:white;

text-decoration:none;

padding:12px 25px;

border-radius:8px;

}

</style>

</head>

<body>

<div class="container">

<h1>Nuevo Usuario</h1>

<form action="usuario_guardar.php"

method="POST">

<div class="form-grid">

<input

type="text"

name="nomUsu1"

placeholder="Primer nombre"

required>

<input

type="text"

name="nomUsu2"

placeholder="Segundo nombre">

<input

type="text"

name="apeUsu1"

placeholder="Primer apellido"

required>

<input

type="text"

name="apeUsu2"

placeholder="Segundo apellido">

<input

type="text"

name="docUsu"

placeholder="Documento"

required>

<input

type="text"

name="telUsu"

placeholder="Teléfono">

<input

type="email"

name="emailUsu"

placeholder="Correo"

required>

<input

type="password"

name="passUsu"

placeholder="Contraseña"

required>

<select name="estadoUsu">

<option value="ACTIVO">

ACTIVO

</option>

<option value="INACTIVO">

INACTIVO

</option>

</select>

<select name="idRol" required>

<option value="">

Seleccione un rol

</option>

<?php

while($r=mysqli_fetch_assoc($roles)){

?>

<option value="<?= $r['idRol'] ?>">

<?= $r['nomRol'] ?>

</option>

<?php

}

?>

</select>

</div>

<div class="btns">

<button

class="guardar"

type="submit">

Guardar Usuario

</button>

<a

class="volver"

href="usuario_listar.php">

Volver

</a>

</div>

</form>

</div>

</body>

</html>