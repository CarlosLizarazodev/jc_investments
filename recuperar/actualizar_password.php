<?php

include("../config/conexion.php");

$email = $_POST['emailUsu'];
$pass = $_POST['passNueva'];

$hash = password_hash($pass,PASSWORD_DEFAULT);

$sql = "UPDATE usuario

SET passUsu='$hash'

WHERE emailUsu='$email'";

if(mysqli_query($conn,$sql))
{
    echo "

    <script>

    alert('Contraseña actualizada correctamente');

    window.location='../login/login.php';

    </script>

    ";
}
else
{
    echo "Error al actualizar";
}

?>