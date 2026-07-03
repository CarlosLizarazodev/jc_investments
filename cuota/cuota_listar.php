<?php

include("../admin/seguridad_admin.php");

include("../config/conexion.php");


$totalCuotas = mysqli_num_rows(
mysqli_query($conn,"
SELECT *
FROM cuota
")
);


$pagadas = mysqli_num_rows(
mysqli_query($conn,"
SELECT *
FROM cuota
WHERE estadoCuo='PAGADA'
")
);


$pendientes = mysqli_num_rows(
mysqli_query($conn,"
SELECT *
FROM cuota
WHERE estadoCuo='PENDIENTE'
")
);


$mora = mysqli_num_rows(
mysqli_query($conn,"
SELECT *
FROM cuota
WHERE estadoCuo='MORA'
")
);


$sql="

SELECT

c.*,

pr.idPres,

u.idUsu,

CONCAT(
u.nomUsu1,' ',
IFNULL(u.nomUsu2,''),' ',
u.apeUsu1,' ',
IFNULL(u.apeUsu2,'')
) AS cliente

FROM cuota c

INNER JOIN prestamo pr
ON c.idPres=pr.idPres

INNER JOIN usuario u
ON pr.idUsu=u.idUsu

ORDER BY c.fechaVencCuo ASC

";

$resultado=mysqli_query($conn,$sql);

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>JC Investments - Cuotas</title>

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

.sidebar{
width:220px;
background:#0a1525;
display:flex;
flex-direction:column;
flex-shrink:0;
}

.logo{
padding:18px 20px;
border-bottom:1px solid #1a2d45;
display:flex;
align-items:center;
}

.logo-badge{
background:#7c3aed;
color:#fff;
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
cursor:pointer;
color:#6b8aab;
font-size:14px;
transition:.2s;
text-decoration:none;
}

.nav-item:hover{
color:#c5d5e8;
background:#0f1f35;
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
}

.page-title{
font-size:22px;
font-weight:700;
}

.page-sub{
font-size:13px;
color:#5a7a9a;
margin-top:2px;
}

.badge-admin{
background:#7c3aed;
color:#fff;
font-size:12px;
padding:5px 12px;
border-radius:5px;
font-weight:600;
}

.content{
flex:1;
padding:24px 28px;
background:#0f1e30;
overflow-y:auto;
}

.stats-row{
display:grid;
grid-template-columns:repeat(4,1fr);
gap:16px;
margin-bottom:24px;
}

.stat-card{
background:#122033;
border:1px solid #1a2d45;
border-radius:10px;
padding:18px;
}

.stat-label{
font-size:13px;
color:#5a7a9a;
margin-bottom:8px;
}

.stat-val{
font-size:28px;
font-weight:700;
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
text-transform:uppercase;
}

td{
padding:14px 16px;
border-bottom:1px solid #162232;
}

tbody tr:hover td{
background:#0f1e30;
}

.pill{
display:inline-block;
padding:4px 12px;
border-radius:20px;
font-size:12px;
font-weight:600;
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
text-decoration:none;
}

.icon-btn:hover{
background:#1e3a55;
color:#fff;
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

<a href="../admin/dashboard_admin.php" class="nav-item">

<div class="nav-dot"></div>

Dashboard

</a>

<a href="../solicitud/solicitud_listar.php" class="nav-item">

<div class="nav-dot"></div>

Solicitudes

</a>

<a href="../usuario/usuario_listar.php" class="nav-item">

<div class="nav-dot"></div>

Usuarios

</a>

<a href="../prestamo/prestamo_listar.php" class="nav-item">

<div class="nav-dot"></div>

Préstamos

</a>

<a href="cuota_listar.php" class="nav-item active">

<div class="nav-dot"></div>

Cuotas

</a>

<a href="../pago/pago_listar.php" class="nav-item">

<div class="nav-dot"></div>

Pagos

</a>

<a href="../login/logout.php" class="nav-item logout">

<div class="nav-dot"></div>

Cerrar sesión

</a>

</div>

<div class="main">

<div class="topbar">

<div>

<div class="page-title">

Gestión de Cuotas

</div>

<div class="page-sub">

Control de cuotas de los préstamos

</div>

</div>

<div>

<span class="badge-admin">

Admin General

</span>

</div>

</div>

<div class="content">

<div class="stats-row">

<div class="stat-card">

<div class="stat-label">

Total cuotas

</div>

<div class="stat-val blue">

<?= $totalCuotas ?>

</div>

</div>

<div class="stat-card">

<div class="stat-label">

Pagadas

</div>

<div class="stat-val green">

<?= $pagadas ?>

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

<div class="table-wrap">

<table>

<thead>

<tr>

<th>ID</th>

<th>Cliente</th>

<th>Préstamo</th>

<th>Cuota</th>

<th>Fecha</th>

<th>Valor</th>

<th>Saldo</th>

<th>Estado</th>

<th>Acciones</th>

</tr>

</thead>

<tbody>

<?php

while($fila=mysqli_fetch_assoc($resultado)){

if($fila['estadoCuo']=="PAGADA"){

$clase="pill-green";

}

elseif($fila['estadoCuo']=="MORA"){

$clase="pill-red";

}

else{

$clase="pill-yellow";

}

?>

<tr>

<td>

#<?= $fila['idCuo'] ?>

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

<?= $fila['fechaVencCuo'] ?>

</td>

<td>

$ <?= number_format($fila['valorCuo'],0) ?>

</td>

<td>

$ <?= number_format($fila['saldoCuo'],0) ?>

</td>

<td>

<span class="pill <?= $clase ?>">

<?= $fila['estadoCuo'] ?>

</span>

</td>

<td>

<div class="actions">

<a

class="icon-btn"

href="../pago/pago_listar.php">

💰

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