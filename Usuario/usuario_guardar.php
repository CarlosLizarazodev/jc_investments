<?php

include("../config/conexion.php");

if($_SERVER["REQUEST_METHOD"]!="POST"){

header("Location:usuario_listar.php");

exit();

}

$nomUsu1=$_POST['nomUsu1'] ?? '';

$nomUsu2=$_POST['nomUsu2'] ?? '';

$apeUsu1=$_POST['apeUsu1'] ?? '';

$apeUsu2=$_POST['apeUsu2'] ?? '';

$docUsu=$_POST['docUsu'] ?? '';

$telUsu=$_POST['telUsu'] ?? '';

$emailUsu=$_POST['emailUsu'] ?? '';

$passUsu=password_hash(

$_POST['passUsu'],

PASSWORD_DEFAULT

);

$estadoUsu=$_POST['estadoUsu'] ?? 'ACTIVO';

$idRol=$_POST['idRol'] ?? '';

if($idRol==''){

die("Debe seleccionar un rol.");

}

$sql="INSERT INTO usuario(

nomUsu1,

nomUsu2,

apeUsu1,

apeUsu2,

docUsu,

telUsu,

emailUsu,

passUsu,

estadoUsu,

idRol

)

VALUES(

'$nomUsu1',

'$nomUsu2',

'$apeUsu1',

'$apeUsu2',

'$docUsu',

'$telUsu',

'$emailUsu',

'$passUsu',

'$estadoUsu',

'$idRol'

)";

if(mysqli_query($conn,$sql)){

header("Location:usuario_listar.php");

exit();

}

else{

echo mysqli_error($conn);

}

?>