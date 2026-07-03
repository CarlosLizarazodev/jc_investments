<?php

include("../config/conexion.php");

$idUsu = $_POST['idUsu'];

$sql = "UPDATE usuario SET

nomUsu1 = '".$_POST['nomUsu1']."',
nomUsu2 = '".$_POST['nomUsu2']."',
apeUsu1 = '".$_POST['apeUsu1']."',
apeUsu2 = '".$_POST['apeUsu2']."',
docUsu = '".$_POST['docUsu']."',
telUsu = '".$_POST['telUsu']."',
emailUsu = '".$_POST['emailUsu']."',
estadoUsu = '".$_POST['estadoUsu']."',
idRol = '".$_POST['idRol']."'

WHERE idUsu = $idUsu";

mysqli_query($conn,$sql);

header("Location:usuario_listar.php");