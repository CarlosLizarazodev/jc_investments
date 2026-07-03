<?php

include("../admin/seguridad_admin.php");
include("../config/conexion.php");

$sql = "SELECT u.*, r.nomRol

FROM usuario u

INNER JOIN rol r
ON u.idRol = r.idRol

ORDER BY u.idUsu DESC";

$resultado = mysqli_query($conn,$sql);


/* ESTADISTICAS */

$total = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM usuario
"));

$activos = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM usuario
WHERE estadoUsu='ACTIVO'
"));

$clientes = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM usuario
WHERE idRol=2
"));

$admins = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM usuario
WHERE idRol=1
"));

?>

<!DOCTYPE html>

<html lang="es">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title>Usuarios</title>

<style>

*{
box-sizing:border-box;
margin:0;
padding:0;
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
flex-shrink:0;
}

.logo{
padding:20px;
border-bottom:1px solid #1a2d45;
}

.logo h2{
font-size:20px;
}

.nav-item{

padding:16px 20px;

text-decoration:none;

color:#6b8aab;

transition:.3s;

}

.nav-item:hover{

background:#122033;

color:white;

}

.nav-item.active{

background:#7c3aed22;

border-left:4px solid #7c3aed;

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

padding:25px;

display:flex;

justify-content:space-between;

align-items:center;

border-bottom:1px solid #1a2d45;

}

.content{

padding:25px;

}

/* CARDS */

.stats{

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

.card h3{

font-size:14px;

color:#6b8aab;

}

.card h1{

margin-top:10px;

}

.green{

color:#22c55e;

}

.blue{

color:#60a5fa;

}

.purple{

color:#a78bfa;

}

.yellow{

color:#fbbf24;

}

/* FILTROS */

.filters{

display:flex;

gap:10px;

flex-wrap:wrap;

margin-bottom:20px;

}

input{

padding:10px;

border:none;

border-radius:8px;

background:#122033;

color:white;

}

.btn{

padding:10px 20px;

border:none;

border-radius:8px;

cursor:pointer;

font-weight:600;

}

.btn-primary{

background:#7c3aed;

color:white;

}

.btn-primary:hover{

background:#6d28d9;

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

th{

background:#09121f;

padding:15px;

}

td{

padding:15px;

border-bottom:1px solid #1a2d45;

}

tr:hover{

background:#162232;

}

/* PILLS */

.pill{

padding:5px 12px;

border-radius:20px;

font-size:12px;

font-weight:600;

}

.activo{

background:#22c55e22;

color:#22c55e;

}

.inactivo{

background:#ef444422;

color:#ef4444;

}

.admin{

background:#7c3aed22;

color:#a78bfa;

}

.cliente{

background:#60a5fa22;

color:#60a5fa;

}

/* BOTONES */

.actions{

display:flex;

gap:8px;

}

.icon{

padding:8px 12px;

border-radius:6px;

text-decoration:none;

color:white;

}

.editar{

background:#2563eb;

}

.eliminar{

background:#dc2626;

}

/* RESPONSIVE */

@media(max-width:900px){

.stats{

grid-template-columns:1fr 1fr;

}

}

@media(max-width:700px){

.stats{

grid-template-columns:1fr;

}

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


<a href="../solicitud/solicitud_listar.php"

class="nav-item">

Solicitudes

</a>


<a href="../Usuario/usuario_listar.php"

class="nav-item active">

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

<div>

<h1>Gestión de Usuarios</h1>

<p>Administra todos los usuarios</p>

</div>

</div>


<div class="content">


<div class="stats">

<div class="card">

<h3>Total usuarios</h3>

<h1 class="blue">

<?= $total['total'] ?>

</h1>

</div>


<div class="card">

<h3>Usuarios activos</h3>

<h1 class="green">

<?= $activos['total'] ?>

</h1>

</div>


<div class="card">

<h3>Clientes</h3>

<h1 class="purple">

<?= $clientes['total'] ?>

</h1>

</div>


<div class="card">

<h3>Administradores</h3>

<h1 class="yellow">

<?= $admins['total'] ?>

</h1>

</div>

</div>


<div class="filters">

<input

type="text"

id="buscar"

placeholder="Buscar usuario..."

onkeyup="buscarUsuario()"

>

<a href="usuario_guardar.php">

<button class="btn btn-primary">

+ Nuevo usuario

</button>

</a>

</div>


<div class="table-wrap">

<table id="tabla">

<tr>

<th>ID</th>

<th>Nombre</th>

<th>Documento</th>

<th>Correo</th>

<th>Estado</th>

<th>Rol</th>

<th>Acciones</th>

</tr>


<?php while($fila=mysqli_fetch_assoc($resultado)){ ?>

<tr>

<td>

<?= $fila['idUsu'] ?>

</td>

<td>

<?= $fila['nomUsu1'] ?>

<?= $fila['nomUsu2'] ?>

<?= $fila['apeUsu1'] ?>

<?= $fila['apeUsu2'] ?>

</td>

<td>

<?= $fila['docUsu'] ?>

</td>

<td>

<?= $fila['emailUsu'] ?>

</td>

<td>

<span class="pill <?= strtolower($fila['estadoUsu']) ?>">

<?= $fila['estadoUsu'] ?>

</span>

</td>

<td>

<span class="pill <?= $fila['idRol']==1 ? 'admin':'cliente' ?>">

<?= $fila['nomRol'] ?>

</span>

</td>

<td>

<div class="actions">

<a

class="icon editar"

href="usuario_editar.php?id=<?= $fila['idUsu'] ?>">

Editar

</a>


<a

class="icon eliminar"

onclick="return confirm('¿Eliminar usuario?')"

href="usuario_eliminar.php?id=<?= $fila['idUsu'] ?>">

Eliminar

</a>

</div>

</td>

</tr>

<?php } ?>

</table>

</div>

</div>

</div>

</div>


<script>

function buscarUsuario(){

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