<?php

include("../config/conexion.php");

$nomUsu1 = trim($_POST['nomUsu1']);
$nomUsu2 = trim($_POST['nomUsu2']);
$apeUsu1 = trim($_POST['apeUsu1']);
$apeUsu2 = trim($_POST['apeUsu2']);
$docUsu = trim($_POST['docUsu']);
$telUsu = trim($_POST['telUsu']);
$emailUsu = trim($_POST['emailUsu']);

$passUsu = password_hash(
    $_POST['passUsu'],
    PASSWORD_DEFAULT
);

$idRol = 2;
$estadoUsu = "ACTIVO";


/* VALIDAR DOCUMENTO */

$consultaDoc = mysqli_query(
    $conn,
    "SELECT idUsu
     FROM usuario
     WHERE docUsu='$docUsu'"
);

if(mysqli_num_rows($consultaDoc) > 0){

    echo "
    <h2>El documento ya se encuentra registrado.</h2>

    <a href='registro.php'>
    Volver al registro
    </a>
    ";

    exit();
}


/* VALIDAR CORREO */

$consultaCorreo = mysqli_query(
    $conn,
    "SELECT idUsu
     FROM usuario
     WHERE emailUsu='$emailUsu'"
);

if(mysqli_num_rows($consultaCorreo) > 0){

    echo "
    <h2>El correo electrónico ya se encuentra registrado.</h2>

    <a href='registro.php'>
    Volver al registro
    </a>
    ";

    exit();
}


/* GUARDAR USUARIO */

$sql = "INSERT INTO usuario(

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

    echo "

    <h2>
    Usuario registrado correctamente
    </h2>

    <p>
    Ya puede iniciar sesión.
    </p>

    <a href='../login/login.php'>
    Ir al Login
    </a>

    ";

}else{

    echo "

    <h2>
    Error al registrar usuario
    </h2>

    <p>
    ".mysqli_error($conn)."
    </p>

    <a href='registro.php'>
    Volver
    </a>

    ";

}

?>