```php
<?php
include("../config/conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Pago</title>

    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <h2>Registrar Pago</h2>

    <form action="pago_guardar.php" method="POST">

        <div class="mb-3">
            <label class="form-label">
                Seleccionar Cuota Pendiente
            </label>

            <select name="datosCuota" class="form-control" required>

                <option value="">
                    Seleccione...
                </option>

                <?php

                $sql = "
                SELECT
                    c.idCuo,
                    c.idPres,
                    p.idUsu,
                    c.numCuo,
                    c.valorCuo,
                    CONCAT(
                        u.nomUsu1,' ',
                        IFNULL(u.nomUsu2,''),' ',
                        u.apeUsu1,' ',
                        IFNULL(u.apeUsu2,'')
                    ) AS cliente
                FROM cuota c
                INNER JOIN prestamo p
                    ON c.idPres = p.idPres
                INNER JOIN usuario u
                    ON p.idUsu = u.idUsu
                WHERE c.estadoCuo='PENDIENTE'
                ORDER BY c.idCuo ASC
                ";

                $resultado = mysqli_query($conn,$sql);

                while($fila=mysqli_fetch_array($resultado))
                {
                ?>

                <option value="<?php
                    echo $fila['idCuo']."|".
                         $fila['idUsu']."|".
                         $fila['valorCuo'];
                ?>">

                    <?php
                    echo "Préstamo #".$fila['idPres'].
                         " - Cuota ".$fila['numCuo'].
                         " - ".$fila['cliente'].
                         " - $ ".number_format(
                                $fila['valorCuo'],
                                2,
                                ',',
                                '.'
                           );
                    ?>

                </option>

                <?php
                }
                ?>

            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">
                Método de Pago
            </label>

            <select name="metodoPag" class="form-control" required>
                <option value="">Seleccione...</option>
                <option value="EFECTIVO">EFECTIVO</option>
                <option value="TRANSFERENCIA">TRANSFERENCIA</option>
                <option value="NEQUI">NEQUI</option>
                <option value="DAVIPLATA">DAVIPLATA</option>
                <option value="PSE">PSE</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">
                Referencia
            </label>

            <input
                type="text"
                name="refPag"
                class="form-control"
                placeholder="Opcional"
            >
        </div>

        <button type="submit" class="btn btn-success">
            Registrar Pago
        </button>

        <a href="pago_listar.php" class="btn btn-secondary">
            Volver
        </a>

    </form>

</div>

</body>
</html>
```
