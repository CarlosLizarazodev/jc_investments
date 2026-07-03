<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<title>Recuperar Contraseña</title>

<style>

body{
font-family:Arial;
background:#f4f6f9;
}

.contenedor{
width:400px;
margin:80px auto;
background:white;
padding:20px;
border-radius:10px;
box-shadow:0px 0px 10px rgba(0,0,0,.1);
}

input{
width:100%;
padding:10px;
margin-bottom:10px;
}

button{
width:100%;
padding:10px;
background:#059669;
color:white;
border:none;
cursor:pointer;
}

a{
text-decoration:none;
}

</style>

</head>

<body>

<div class="contenedor">

<h2>Recuperar Contraseña</h2>

<form action="actualizar_password.php" method="POST">

<input
type="email"
name="emailUsu"
placeholder="Correo registrado"
required>

<input
type="password"
name="passNueva"
placeholder="Nueva contraseña"
required>

<button type="submit">
Actualizar Contraseña
</button>

</form>

<br>

<a href="../login/login.php">
Volver al Login
</a>

</div>

</body>
</html>