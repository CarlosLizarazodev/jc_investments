<?php
session_start();

if(!isset($_SESSION['idUsu'])){
    header("Location: ../login/login.php");
    exit();
}

if($_SESSION['codRol'] != 'ADMIN'){
    die("ACCESO DENEGADO");
}

include("../config/conexion.php");

$totalUsuarios = mysqli_num_rows(
    mysqli_query($conn,"SELECT * FROM usuario")
);

$totalSolicitudes = mysqli_num_rows(
    mysqli_query($conn,"SELECT * FROM solicitud")
);

$totalPrestamos = mysqli_num_rows(
    mysqli_query($conn,"SELECT * FROM prestamo")
);

$totalPagos = mysqli_num_rows(
    mysqli_query($conn,"SELECT * FROM pago")
);

$pendientes = mysqli_num_rows(
    mysqli_query($conn,"
    SELECT *
    FROM solicitud
    WHERE estadoSol='PENDIENTE'
    ")
);

$consultaMonto = mysqli_query($conn,"
SELECT SUM(montoPres) totalPrestado
FROM prestamo
");

$datosMonto = mysqli_fetch_assoc($consultaMonto);

$totalPrestado = $datosMonto['totalPrestado'];

if($totalPrestado==""){
    $totalPrestado=0;
}

$solicitudes = mysqli_query($conn,"
SELECT
s.*,
u.nomUsu1,
u.apeUsu1,
t.nomTipPres
FROM solicitud s
INNER JOIN usuario u ON s.idUsu=u.idUsu
INNER JOIN tipoprestamo t ON s.idTipPres=t.idTipPres
ORDER BY s.idSol DESC
LIMIT 10
");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Administrador</title>

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
}

.app{
display:flex;
min-height:100vh;
}

/* SIDEBAR */

.sidebar{
width:240px;
background:#0a1525;
display:flex;
flex-direction:column;
}

.logo{
padding:20px;
border-bottom:1px solid #1a2d45;
}

.logo h2{
color:white;
}

.nav-item{
display:block;
padding:14px 20px;
text-decoration:none;
color:#9fb3cc;
transition:.3s;
}

.nav-item:hover{
background:#122033;
color:white;
}

.nav-item.active{
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
padding:20px 30px;
border-bottom:1px solid #1a2d45;
display:flex;
justify-content:flex-end;
}

.content{
padding:30px;
}

.page-title{
font-size:28px;
font-weight:bold;
margin-bottom:5px;
}

.page-sub{
color:#8ea6c1;
margin-bottom:25px;
}

/* CARDS */

.stats-row{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
gap:15px;
margin-bottom:30px;
}

.stat-card{
background:#122033;
padding:20px;
border-radius:10px;
border:1px solid #1a2d45;
}

.stat-label{
color:#9fb3cc;
margin-bottom:10px;
}

.stat-val{
font-size:28px;
font-weight:bold;
}

.green{
color:#22c55e;
}

.orange{
color:#fb923c;
}

.red{
color:#f87171;
}

/* TABLA */

.table-wrap{
background:#122033;
border-radius:10px;
overflow:hidden;
border:1px solid #1a2d45;
}

.table-title{
font-size:18px;
margin-bottom:15px;
font-weight:bold;
}

table{
width:100%;
border-collapse:collapse;
}

thead{
background:#0d1b2e;
}

th{
padding:12px;
text-align:left;
color:#7e96af;
}

td{
padding:12px;
border-top:1px solid #1a2d45;
}

.estado{
font-weight:bold;
}

.pendiente{
color:#fb923c;
}

.aprobada{
color:#22c55e;
}

.rechazada{
color:#ef4444;
}

.btn{
padding:6px 12px;
border:none;
border-radius:6px;
color:white;
cursor:pointer;
font-size:12px;
}

.btn-detalle{
background:#2563eb;
}

.btn-detalle:hover{
background:#1d4ed8;
}

</style>

</head>
<body>

<div class="app">

<div class="sidebar">

<div class="logo">
<h2>JC Investments</h2>
</div>

<a class="nav-item active" href="dashboard_admin.php">
Dashboard
</a>

<a class="nav-item" href="../usuario/usuario_listar.php">
Usuarios
</a>

<a class="nav-item" href="../rol/rol_listar.php">
Roles
</a>

<a class="nav-item" href="../solicitud/solicitud_listar.php">
Solicitudes
</a>

<a class="nav-item" href="../prestamo/prestamo_listar.php">
Préstamos
</a>

<a class="nav-item" href="../cuota/cuota_listar.php">
Cuotas
</a>

<a class="nav-item" href="../pago/pago_listar.php">
Pagos
</a>

<a class="nav-item logout" href="../login/logout.php">
Cerrar sesión
</a>

</div>

<div class="main">

<div class="topbar">
Administrador:
&nbsp;
<strong>
<?php echo $_SESSION['nombre']; ?>
</strong>
</div>

<div class="content">

<div class="page-title">
Panel de Administración
</div>

<div class="page-sub">
Resumen general del sistema
</div>

<div class="stats-row">

<div class="stat-card">
<div class="stat-label">Usuarios</div>
<div class="stat-val">
<?php echo $totalUsuarios; ?>
</div>
</div>

<div class="stat-card">
<div class="stat-label">Solicitudes</div>
<div class="stat-val">
<?php echo $totalSolicitudes; ?>
</div>
</div>

<div class="stat-card">
<div class="stat-label">Préstamos</div>
<div class="stat-val green">
<?php echo $totalPrestamos; ?>
</div>
</div>

<div class="stat-card">
<div class="stat-label">Pagos</div>
<div class="stat-val">
<?php echo $totalPagos; ?>
</div>
</div>

<div class="stat-card">
<div class="stat-label">Pendientes</div>
<div class="stat-val orange">
<?php echo $pendientes; ?>
</div>
</div>

<div class="stat-card">
<div class="stat-label">Total Prestado</div>
<div class="stat-val green">
$<?php echo number_format($totalPrestado,0); ?>
</div>
</div>

</div>

<div class="table-title">
Últimas Solicitudes
</div>

<div class="table-wrap">

<table>

<thead>
<tr>
<th>Cliente</th>
<th>Tipo</th>
<th>Monto</th>
<th>Plazo</th>
<th>Estado</th>
<th>Acción</th>
</tr>
</thead>

<tbody>

<?php
while($row=mysqli_fetch_assoc($solicitudes)){
?>

<tr>

<td>
<?php echo $row['nomUsu1']." ".$row['apeUsu1']; ?>
</td>

<td>
<?php echo $row['nomTipPres']; ?>
</td>

<td>
$<?php echo number_format($row['montoSol'],0); ?>
</td>

<td>
<?php echo $row['plazoSol']; ?> meses
</td>

<td>

<?php
$estado = strtoupper($row['estadoSol']);

if($estado=="PENDIENTE"){
echo "<span class='estado pendiente'>PENDIENTE</span>";
}
elseif($estado=="APROBADA"){
echo "<span class='estado aprobada'>APROBADA</span>";
}
else{
echo "<span class='estado rechazada'>RECHAZADA</span>";
}
?>

</td>

<td>
<button class="btn btn-detalle">
Ver
</button>
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