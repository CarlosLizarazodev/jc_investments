<?php
session_start();

include("../config/conexion.php");

if($_SERVER["REQUEST_METHOD"] != "POST"){
    header("Location: login.php");
    exit();
}

$email = trim($_POST['emailUsu']);
$password = $_POST['passUsu'];

$sql = "SELECT u.*, r.codRol
        FROM usuario u
        INNER JOIN rol r
        ON u.idRol = r.idRol
        WHERE u.emailUsu = '$email'
        AND u.estadoUsu = 'ACTIVO'
        LIMIT 1";

$resultado = mysqli_query($conn,$sql);

if(mysqli_num_rows($resultado) == 1){

    $usuario = mysqli_fetch_assoc($resultado);

    if(password_verify($password,$usuario['passUsu'])){

        $_SESSION['idUsu'] = $usuario['idUsu'];

        $_SESSION['nombre'] =
        $usuario['nomUsu1'].' '.
        $usuario['apeUsu1'];

        $_SESSION['codRol'] =
        $usuario['codRol'];

        if($usuario['codRol']=="ADMIN"){

            header("Location: ../admin/dashboard_admin.php");
            exit();

        }else{

            header("Location: ../cliente/dashboard_cliente.php");
            exit();

        }

    }else{

        header("Location: login.php?error=1");
        exit();

    }

}else{

    header("Location: login.php?error=2");
    exit();

}
?>