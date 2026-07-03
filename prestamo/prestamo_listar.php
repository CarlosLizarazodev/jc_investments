<?php

include("../admin/seguridad_admin.php");
include("../config/conexion.php");

/* Estadísticas */

$total = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM prestamo
"));

$activos = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM prestamo
WHERE estadoPres='ACTIVO'
"));

$saldo = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT IFNULL(SUM(saldoPres),0) total
FROM prestamo
"));

$desembolsado = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT IFNULL(SUM(montoPres),0) total
FROM prestamo
"));

/* Tabla */

$sql="

SELECT

p.*,

CONCAT(

u.nomUsu1,' ',
IFNULL(u.nomUsu2,''),' ',
u.apeUsu1,' ',
IFNULL(u.apeUsu2,'')

) AS cliente

FROM prestamo p

INNER JOIN usuario u

ON p.idUsu=u.idUsu

ORDER BY p.idPres DESC

";

$resultado=mysqli_query($conn,$sql);

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Préstamos</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Segoe UI',sans-serif;
}

body{
background:#0d1b2e;
color:#fff;
}

.app{
display:flex;
min-height:100vh;
}

/* SIDEBAR */

.sidebar{
width:220px;
background:#0a1525;
display:flex;
flex-direction:column;
}

.logo{
padding:20px;
font-weight:bold;
font-size:20px;
border-bottom:1px solid #1a2d45;
}

.nav-item{

display:block;

padding:15px 20px;

text-decoration:none;

color:#6b8aab;

}

.nav-item:hover{

background:#122033;

}

.active{

background:#7c3aed;

color:white;

}

.logout{

margin-top:auto;

color:#f87171;

}

/* MAIN */

.main{

flex:1;

}

.topbar{

padding:25px;

border-bottom:1px solid #1a2d45;

}

.content{

padding:25px;

}

/* TARJETAS */

.cards{

display:grid;

grid-template-columns:repeat(4,1fr);

gap:15px;

margin-bottom:25px;

}

.card{

background:#122033;

padding:20px;

border-radius:10px;

}

.card p{

color:#6b8aab;

}

.card h1{

margin-top:10px;

}

/* FILTRO */

.buscar{

margin-bottom:20px;

}

.buscar input{

width:300px;

padding:12px;

border:none;

border-radius:8px;

background:#122033;

color:white;

}

/* TABLA */

table{

width:100%;

border-collapse:collapse;

background:#122033;

border-radius:10px;

overflow:hidden;

}

th{

background:#0d1b2e;

padding:15px;

text-align:left;

}

td{

padding:15px;

border-bottom:1px solid #1a2d45;

}

tr:hover{

background:#162232;

}

.estado{

padding:6px 12px;

border-radius:20px;

font-size:12px;

font-weight:bold;

}

.activo{

background:#14532d;

color:#86efac;

}

.finalizado{

background:#1e3a8a;

color:#93c5fd;

}

.mora{

background:#7f1d1d;

color:#fca5a5;

}

.boton{

padding:8px 12px;

border:none;

border-radius:6px;

cursor:pointer;

text-decoration:none;

font-size:12px;

font-weight:bold;

margin-right:5px;

}

.editar{

background:#2563eb;

color:white;

}

.eliminar{

background:#dc2626;

color:white;

}

</style>

</head>

<body>

<div class="app">

<div class="sidebar">

<div class="logo">

JC Investments

</div>

<a href="../admin/dashboard_admin.php"

class="nav-item">

Dashboard

</a>

<a href="../solicitud/solicitud_listar.php"

class="nav-item">

Solicitudes

</a>

<a href="../Usuario/usuario_listar.php"

class="nav-item">

Usuarios

</a>

<a href="prestamo_listar.php"

class="nav-item active">

Préstamos

</a>

<a href="../pago/pago_listar.php"

class="nav-item">

Pagos

</a>

<a href="../reportes/reporte_prestamos.php"

class="nav-item">

Reportes

</a>

<a href="../logout.php"

class="nav-item logout">

Cerrar sesión

</a>

</div>

<div class="main">

<div class="topbar">

<h1>Gestión de Préstamos</h1>

</div>

<div class="content">

<div class="cards">

<div class="card">

<p>Total préstamos</p>

<h1>

<?= $total['total'] ?>

</h1>

</div>

<div class="card">

<p>Activos</p>

<h1>

<?= $activos['total'] ?>

</h1>

</div>

<div class="card">

<p>Saldo pendiente</p>

<h1>

$ <?= number_format($saldo['total'],0) ?>

</h1>

</div>

<div class="card">

<p>Desembolsado</p>

<h1>

$ <?= number_format($desembolsado['total'],0) ?>

</h1>

</div>

</div>

<div class="buscar">

<input

type="text"

id="buscar"

placeholder="Buscar préstamo..."

onkeyup="buscarPrestamo()"

>

</div>

<table id="tabla">

<tr>

<th>ID</th>

<th>Cliente</th>

<th>Monto</th>

<th>Tasa</th>

<th>Plazo</th>

<th>Saldo</th>

<th>Estado</th>

<th>Acciones</th>

</tr>

<?php

while($fila=mysqli_fetch_assoc($resultado)){

?>

<tr>

<td>

<?= $fila['idPres'] ?>

</td>

<td>

<?= $fila['cliente'] ?>

</td>

<td>

$ <?= number_format($fila['montoPres'],0) ?>

</td>

<td>

<?= $fila['tasaIntPres'] ?> %

</td>

<td>

<?= $fila['plazoPres'] ?>

meses

</td>

<td>

$ <?= number_format($fila['saldoPres'],0) ?>

</td>

<td>

<span class="estado">

<?= $fila['estadoPres'] ?>

</span>

</td>

<td>

<a

class="boton editar"

href="prestamo_editar.php?id=<?= $fila['idPres'] ?>">

Editar

</a>

<a

class="boton eliminar"

onclick="return confirm('¿Eliminar préstamo?')"

href="prestamo_eliminar.php?id=<?= $fila['idPres'] ?>">

Eliminar

</a>

</td>

</tr>

<?php

}

?>

</table>

</div>

</div>

</div>

<script>

function buscarPrestamo(){

let input=

document.getElementById("buscar");

let filtro=

input.value.toUpperCase();

let tabla=

document.getElementById("tabla");

let tr=

tabla.getElementsByTagName("tr");

for(let i=1;i<tr.length;i++){

let texto=

tr[i].textContent;

if(texto.toUpperCase().indexOf(filtro)>-1){

tr[i].style.display="";

}

else{

tr[i].style.display="none";

}

}

}

</script>

</body>

</html>