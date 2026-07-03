<?php

include("../admin/seguridad_admin.php");

include("../config/conexion.php");


$totalPagos=mysqli_num_rows(

mysqli_query($conn,"

SELECT *

FROM pago

")

);


$registrados=mysqli_num_rows(

mysqli_query($conn,"

SELECT *

FROM pago

WHERE estadoPag='REGISTRADO'

")

);


$pendientes=mysqli_num_rows(

mysqli_query($conn,"

SELECT *

FROM pago

WHERE estadoPag='PENDIENTE'

")

);


$mora=mysqli_num_rows(

mysqli_query($conn,"

SELECT *

FROM pago

WHERE estadoPag='MORA'

")

);


$totalRecaudado=mysqli_fetch_assoc(

mysqli_query($conn,"

SELECT

IFNULL(SUM(valorPag),0) total

FROM pago

")

);


$sql="

SELECT

p.*,

c.numCuo,

pr.idPres,

CONCAT(

u.nomUsu1,' ',

IFNULL(u.nomUsu2,''),' ',

u.apeUsu1,' ',

IFNULL(u.apeUsu2,'')

) cliente

FROM pago p

INNER JOIN cuota c

ON p.idCuo=c.idCuo

INNER JOIN prestamo pr

ON c.idPres=pr.idPres

INNER JOIN usuario u

ON p.idUsu=u.idUsu

ORDER BY p.idPag DESC

";


$pagos=mysqli_query($conn,$sql);

?>


<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport"

content="width=device-width, initial-scale=1.0">

<title>

JC Investments - Pagos

</title>

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

display:flex;

align-items:center;

}


.logo-badge{

background:#7c3aed;

color:white;

font-size:12px;

font-weight:700;

padding:3px 8px;

border-radius:5px;

margin-right:10px;

}


.logo-text{

font-size:14px;

font-weight:600;

color:#c5d5e8;

}


.nav-item{

display:flex;

align-items:center;

gap:10px;

padding:13px 20px;

text-decoration:none;

color:#6b8aab;

}


.nav-item:hover{

background:#0f1f35;

color:#c5d5e8;

}


.nav-item.active{

background:#7c3aed22;

color:#a78bfa;

border-left:3px solid #7c3aed;

}


.nav-dot{

width:8px;

height:8px;

background:currentColor;

border-radius:2px;

}


.logout{

margin-top:auto;

color:#f87171 !important;

}


/* MAIN */


.main{

flex:1;

display:flex;

flex-direction:column;

}


.topbar{

background:#0d1b2e;

border-bottom:1px solid #1a2d45;

padding:16px 28px;

display:flex;

justify-content:space-between;

align-items:center;

}


.page-title{

font-size:22px;

font-weight:700;

}


.page-sub{

font-size:13px;

color:#5a7a9a;

}


.badge-admin{

background:#7c3aed;

padding:5px 12px;

border-radius:5px;

font-size:12px;

}


.content{

padding:24px 28px;

background:#0f1e30;

flex:1;

}


/* CARDS */


.stats-row{

display:grid;

grid-template-columns:repeat(4,1fr);

gap:16px;

margin-bottom:24px;

}


.stat-card{

background:#122033;

border:1px solid #1a2d45;

padding:18px;

border-radius:10px;

}


.stat-label{

font-size:13px;

color:#5a7a9a;

}


.stat-val{

font-size:28px;

font-weight:bold;

margin-top:10px;

}


.green{

color:#10b981;

}


.blue{

color:#60a5fa;

}


.yellow{

color:#fbbf24;

}


.red{

color:#f87171;

}

</style>

</head>

<body>

<div class="app">

<div class="sidebar">

<div class="logo">

<span class="logo-badge">

ADM

</span>

<span class="logo-text">

JC Investments

</span>

</div>

<a href="../admin/dashboard_admin.php"

class="nav-item">

<div class="nav-dot"></div>

Dashboard

</a>

<a href="../solicitud/solicitud_listar.php"

class="nav-item">

<div class="nav-dot"></div>

Solicitudes

</a>

<a href="../usuario/usuario_listar.php"

class="nav-item">

<div class="nav-dot"></div>

Usuarios

</a>

<a href="../prestamo/prestamo_listar.php"

class="nav-item">

<div class="nav-dot"></div>

Préstamos

</a>

<a href="../cuota/cuota_listar.php"

class="nav-item">

<div class="nav-dot"></div>

Cuotas

</a>

<a href="pago_listar.php"

class="nav-item active">

<div class="nav-dot"></div>

Pagos

</a>

<a href="../login/logout.php"

class="nav-item logout">

<div class="nav-dot"></div>

Cerrar sesión

</a>

</div>

<div class="main">

<div class="topbar">

<div>

<div class="page-title">

Gestión de Pagos

</div>

<div class="page-sub">

Historial y control de cuotas pagadas

</div>

</div>

<div class="badge-admin">

Administrador

</div>

</div>

<div class="content">

<div class="stats-row">

<div class="stat-card">

<div class="stat-label">

Recaudado

</div>

<div class="stat-val green">

$ <?= number_format($totalRecaudado['total'],0) ?>

</div>

</div>

<div class="stat-card">

<div class="stat-label">

Registrados

</div>

<div class="stat-val blue">

<?= $registrados ?>

</div>

</div>

<div class="stat-card">

<div class="stat-label">

Pendientes

</div>

<div class="stat-val yellow">

<?= $pendientes ?>

</div>

</div>

<div class="stat-card">

<div class="stat-label">

En mora

</div>

<div class="stat-val red">

<?= $mora ?>

</div>

</div>

</div>
<style>

.filters-row{

display:flex;

align-items:center;

gap:10px;

margin-bottom:18px;

flex-wrap:wrap;

}

.search-box{

background:#122033;

border:1px solid #1a2d45;

border-radius:8px;

padding:10px 14px;

color:#c5d5e8;

font-size:13px;

width:260px;

}

.btn-outline{

background:transparent;

color:#60a5fa;

border:1px solid #1e4070;

border-radius:8px;

padding:10px 20px;

cursor:pointer;

}

.btn-primary{

background:#7c3aed;

color:white;

border:none;

border-radius:8px;

padding:10px 20px;

cursor:pointer;

}

.table-wrap{

background:#122033;

border:1px solid #1a2d45;

border-radius:10px;

overflow:hidden;

}

table{

width:100%;

border-collapse:collapse;

}

thead tr{

background:#0d1b2e;

}

th{

padding:14px 16px;

text-align:left;

font-size:12px;

color:#5a7a9a;

border-bottom:1px solid #1a2d45;

}

td{

padding:14px 16px;

border-bottom:1px solid #162232;

font-size:13px;

}

tbody tr:hover td{

background:#0f1e30;

}

.pill{

display:inline-block;

padding:4px 12px;

border-radius:20px;

font-size:12px;

font-weight:bold;

}

.pill-green{

background:#10b98120;

color:#34d399;

}

.pill-yellow{

background:#fbbf2420;

color:#fbbf24;

}

.pill-red{

background:#f8717120;

color:#f87171;

}

.actions{

display:flex;

gap:6px;

}

.icon-btn{

background:#1a2d45;

border:none;

border-radius:5px;

padding:6px 10px;

cursor:pointer;

color:#6b8aab;

}

</style>


<div class="filters-row">

<input

class="search-box"

placeholder="Buscar pago...">

<button class="btn-outline">

Exportar

</button>

<button class="btn-primary">

Registrar pago

</button>

</div>


<div class="table-wrap">

<table>

<thead>

<tr>

<th>ID</th>

<th>Cliente</th>

<th>Préstamo</th>

<th>Cuota</th>

<th>Monto</th>

<th>Método</th>

<th>Fecha</th>

<th>Estado</th>

<th>Acciones</th>

</tr>

</thead>

<tbody>

<?php

while($fila=mysqli_fetch_assoc($pagos)){

if($fila['estadoPag']=="REGISTRADO"){

$clase="pill-green";

}

elseif($fila['estadoPag']=="MORA"){

$clase="pill-red";

}

else{

$clase="pill-yellow";

}

?>

<tr>

<td>

#PG-<?= $fila['idPag'] ?>

</td>

<td>

<?= $fila['cliente'] ?>

</td>

<td>

#<?= $fila['idPres'] ?>

</td>

<td>

<?= $fila['numCuo'] ?>

</td>

<td>

$ <?= number_format($fila['valorPag'],0) ?>

</td>

<td>

<?= $fila['metodoPag'] ?>

</td>

<td>

<?= $fila['fechaPag'] ?>

</td>

<td>

<span class="pill <?= $clase ?>">

<?= $fila['estadoPag'] ?>

</span>

</td>

<td>

<div class="actions">

<a

class="icon-btn"

href="#">

👁

</a>

<a

class="icon-btn"

href="#">

🧾

</a>

</div>

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

</div>

</div>

</div>

</body>

</html>