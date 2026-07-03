<?php

include("seguridad_cliente.php");
include("../config/conexion.php");

$idUsu=$_SESSION['idUsu'];

$sqlBilletera="

SELECT *

FROM billetera

WHERE idUsu='$idUsu'

LIMIT 1

";

$resBilletera=mysqli_query($conn,$sqlBilletera);

$billetera=mysqli_fetch_assoc($resBilletera);

$saldo=0;

if($billetera){

$saldo=$billetera['saldo'];

}

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Retirar dinero</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-slate-100">

<div class="max-w-3xl mx-auto mt-10">

<div class="bg-white p-8 rounded-xl shadow">

<h1 class="text-3xl font-bold mb-6">

Retirar dinero a banco

</h1>

<div class="bg-blue-600 text-white p-5 rounded-xl mb-8">

<p>Saldo disponible</p>

<h2 class="text-4xl font-bold">

$<?php echo number_format($saldo,2,",","."); ?>

</h2>

</div>

<form action="guardar_retiro.php" method="POST" class="space-y-5">

<div>

<label class="font-semibold">

Banco

</label>

<input

type="text"

name="bancoRet"

required

class="w-full border p-3 rounded-lg"

>

</div>

<div>

<label class="font-semibold">

Número de cuenta

</label>

<input

type="text"

name="cuentaRet"

required

class="w-full border p-3 rounded-lg"

>

</div>

<div>

<label class="font-semibold">

Titular

</label>

<input

type="text"

name="titularRet"

required

class="w-full border p-3 rounded-lg"

>

</div>

<div>

<label class="font-semibold">

Valor a retirar

</label>

<input

type="number"

name="valorRet"

required

class="w-full border p-3 rounded-lg"

>

</div>

<button

class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-bold"

>

Solicitar retiro

</button>

</form>

</div>

</div>

</body>

</html>