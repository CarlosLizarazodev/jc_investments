```php
<?php

include("../admin/seguridad_admin.php");

include("../config/conexion.php");

/* ESTADISTICAS */

$total = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) total
FROM solicitud
"));

$aprobadas = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) total
FROM solicitud
WHERE estadoSol='APROBADA'
"));

$pendientes = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) total
FROM solicitud
WHERE estadoSol='PENDIENTE'
"));

$rechazadas = mysqli_fetch_assoc(
mysqli_query($conn,"
SELECT COUNT(*) total
FROM solicitud
WHERE estadoSol='RECHAZADA'
"));

/* CONSULTA PRINCIPAL */

$sql="

SELECT

s.*,

CONCAT(

u.nomUsu1,' ',

IFNULL(u.nomUsu2,''),' ',

u.apeUsu1,' ',

IFNULL(u.apeUsu2,'')

) AS cliente,

tp.nomTipPres

FROM solicitud s

INNER JOIN usuario u

ON s.idUsu=u.idUsu

INNER JOIN tipoprestamo tp

ON s.idTipPres=tp.idTipPres

ORDER BY s.idSol DESC

";

$resultado=mysqli_query($conn,$sql);

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width,initial-scale=1.0">

<title>Solicitudes</title>

<style>

*{
box-sizing:border-box;
margin:0;
padding:0;
font-family:'Segoe UI',sans-serif;
}

body{
background:#0d1b2e;
color:#e0e8f0;
font-size:14px;
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
padding:18px 20px;
border-bottom:1px solid #1a2d45;
}

.logo h2{
font-size:18px;
}

.nav-item{

display:flex;

align-items:center;

padding:14px 20px;

text-decoration:none;

color:#6b8aab;

}

.nav-item:hover{

background:#0f1f35;

color:#fff;

}

.active{

background:#7c3aed22;

border-left:3px solid #7c3aed;

color:#a78bfa;

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

padding:20px 30px;

border-bottom:1px solid #1a2d45;

}

.page-title{

font-size:24px;

font-weight:700;

}

.page-sub{

color:#5a7a9a;

margin-top:5px;

}

.content{

padding:25px;

}

/* CARDS */

.stats-row{

display:grid;

grid-template-columns:repeat(4,1fr);

gap:15px;

margin-bottom:25px;

}

.stat-card{

background:#122033;

padding:20px;

border-radius:10px;

}

.stat-label{

color:#5a7a9a;

}

.stat-val{

font-size:30px;

font-weight:bold;

margin-top:10px;

}

.blue{color:#60a5fa;}

.green{color:#22c55e;}

.yellow{color:#fbbf24;}

.red{color:#ef4444;}

/* FILTROS */

.filters-row{

display:flex;

gap:10px;

margin-bottom:20px;

}

.search-box{

padding:10px;

width:280px;

border:none;

border-radius:8px;

background:#122033;

color:#fff;

}

.btn-primary{

padding:10px 20px;

border:none;

border-radius:8px;

background:#7c3aed;

color:white;

cursor:pointer;

}

/* TABLA */

.table-wrap{

background:#122033;

border-radius:10px;

overflow:hidden;

}

table{

width:100%;

border-collapse:collapse;

}

thead{

background:#0d1b2e;

}

th{

padding:15px;

text-align:left;

}

td{

padding:15px;

border-bottom:1px solid #162232;

}

tr:hover{

background:#162232;

}

.pill{

padding:5px 12px;

border-radius:20px;

font-size:12px;

font-weight:bold;

}

.pill-green{

background:#14532d;

color:#86efac;

}

.pill-yellow{

background:#78350f;

color:#fde68a;

}

.pill-red{

background:#7f1d1d;

color:#fca5a5;

}

.actions{

display:flex;

gap:6px;

}

.icon-btn{

padding:7px 10px;

border:none;

border-radius:6px;

background:#1a2d45;

color:white;

text-decoration:none;

}

.icon-btn:hover{

background:#2563eb;

}

</style>

</head>

<body>

<div class="app">

<div class="sidebar">

<div class="logo">

<h2>JC Investments</h2>

</div>

<a href="../admin/dashboard_admin.php"

class="nav-item">

Dashboard

</a>

<a href="solicitud_listar.php"

class="nav-item active">

Solicitudes

</a>

<a href="../Usuario/usuario_listar.php"

class="nav-item">

Usuarios

</a>

<a href="../prestamo/prestamo_listar.php"

class="nav-item">

Préstamos

</a>

<a href="../pago/pago_listar.php"

class="nav-item">

Pagos

</a>

<a href="../reportes/reporte_usuarios.php"

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

<div class="page-title">

Gestión de Solicitudes

</div>

<div class="page-sub">

Total de préstamos registrados en el sistema

</div>

</div>

<div class="content">

<div class="stats-row">

<div class="stat-card">

<div class="stat-label">

Total solicitudes

</div>

<div class="stat-val blue">

<?= $total['total'] ?>

</div>

</div>

<div class="stat-card">

<div class="stat-label">

Aprobadas

</div>

<div class="stat-val green">

<?= $aprobadas['total'] ?>

</div>

</div>

<div class="stat-card">

<div class="stat-label">

Pendientes

</div>

<div class="stat-val yellow">

<?= $pendientes['total'] ?>

</div>

</div>

<div class="stat-card">

<div class="stat-label">

Rechazadas

</div>

<div class="stat-val red">

<?= $rechazadas['total'] ?>

</div>

</div>

</div>

<div class="filters-row">

<input

id="buscar"

class="search-box"

placeholder="Buscar"

onkeyup="buscarSolicitud()"

>

</div>

<div class="table-wrap">

<table id="tabla">

<thead>

<tr>

<th>ID</th>

<th>Cliente</th>

<th>Tipo</th>

<th>Monto</th>

<th>Fecha</th>

<th>Estado</th>

<th>Acciones</th>

</tr>

</thead>

<tbody>

<?php

while($fila=mysqli_fetch_assoc($resultado)){

if($fila['estadoSol']=="APROBADA"){

$color="pill-green";

}

elseif($fila['estadoSol']=="RECHAZADA"){

$color="pill-red";

}

else{

$color="pill-yellow";

}

?>

<tr>

<td>

#SOL-<?= $fila['idSol'] ?>

</td>

<td>

<?= $fila['cliente'] ?>

</td>

<td>

<?= $fila['nomTipPres'] ?>

</td>

<td>

$<?= number_format($fila['montoSol'],0) ?>

</td>

<td>

<?= $fila['fechaSol'] ?>

</td>

<td>

<span class="pill <?= $color ?>">

<?= $fila['estadoSol'] ?>

</span>

</td>

<td>

<div class="actions">

<a

class="icon-btn"

href="solicitud_aprobar.php?id=<?= $fila['idSol'] ?>">

✔

</a>

<a

class="icon-btn"

href="solicitud_rechazar.php?id=<?= $fila['idSol'] ?>">

✖

</a>

<a

class="icon-btn"

href="solicitud_editar.php?id=<?= $fila['idSol'] ?>">

✏

</a>

<a

class="icon-btn"

href="solicitud_eliminar.php?id=<?= $fila['idSol'] ?>">

🗑

</a>

</div>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>

</div>

</div>

<script>

function buscarSolicitud(){

let input=document.getElementById("buscar");

let filtro=input.value.toUpperCase();

let tabla=document.getElementById("tabla");

let tr=tabla.getElementsByTagName("tr");

for(let i=1;i<tr.length;i++){

let texto=tr[i].textContent;

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
```
