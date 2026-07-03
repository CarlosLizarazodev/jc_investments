```php
<?php
session_start();

if(isset($_SESSION['idUsu'])){

    if($_SESSION['codRol']=="ADMIN"){
        header("Location: ../admin/dashboard_admin.php");
    }else{
        header("Location: ../cliente/dashboard_cliente.php");
    }
    exit();
}

$error = "";

if(isset($_GET['error'])){

    if($_GET['error']==1){
        $error = "Contraseña incorrecta";
    }

    if($_GET['error']==2){
        $error = "Usuario no encontrado";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Iniciar sesión - JC Investments</title>

<script src="https://cdn.tailwindcss.com"></script>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>

body{
font-family:'Inter',sans-serif;
}

.font-display{
font-family:'Playfair Display',serif;
}

.nav-link{
transition:color .2s ease;
}

.nav-link:hover{
color:#ffffff;
}

.btn-primary{
transition:background-color .2s ease,transform .15s ease;
}

.btn-primary:hover{
background-color:#2f6fe0;
transform:translateY(-1px);
}

.btn-secondary{
transition:background-color .2s ease,transform .15s ease;
}

.btn-secondary:hover{
background-color:rgba(255,255,255,0.08);
transform:translateY(-1px);
}

.input-field{
transition:border-color .2s ease,box-shadow .2s ease;
}

.input-field:focus{
outline:none;
border-color:#3b82f6;
box-shadow:0 0 0 3px rgba(59,130,246,0.15);
}

</style>

</head>

<body class="bg-white text-slate-800">

<header class="w-full bg-[#0a1730] border-b border-white/5">

<div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">

<a href="../index.php" class="flex items-center gap-3">

<div class="w-9 h-9 rounded-lg bg-[#3b82f6] flex items-center justify-center">

<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">

<path d="M3 21h18"/>
<path d="M5 21V7l7-4 7 4v14"/>

</svg>

</div>

<span class="font-bold text-lg tracking-tight text-white">

JC Investments

</span>

</a>

<div class="hidden md:flex items-center gap-3">

<a href="login.php"
class="btn-secondary border border-white/15 text-white text-sm font-semibold px-4 py-2 rounded-lg">

Iniciar sesión

</a>

<a href="../registro/registro.php"
class="btn-primary bg-[#3b82f6] text-white text-sm font-semibold px-4 py-2 rounded-lg">

Registrarse

</a>

</div>

</div>

</header>

<div class="grid lg:grid-cols-2 min-h-[calc(100vh-65px)]">

<div class="bg-gradient-to-br from-[#10254a] to-[#0c1f3f] text-white px-10 py-16 flex flex-col">

<h1 class="font-display font-black text-5xl mb-4">

Bienvenido de vuelta

</h1>

<p class="text-slate-300 max-w-sm">

Accede a tu cuenta para consultar solicitudes,
préstamos, cuotas y pagos.

</p>

</div>

<div class="flex items-center justify-center px-6 py-12">

<div class="w-full max-w-md">

<a href="../index.php"
class="inline-flex items-center gap-1 text-sm text-slate-400 mb-8">

← Volver al inicio

</a>

<h2 class="font-display font-black text-3xl mb-2 text-[#0c1f3f]">

Iniciar sesión

</h2>

<p class="text-slate-500 mb-6">

Ingresa tus credenciales para acceder a tu cuenta

</p>

<?php if($error!=""){ ?>

<div class="bg-red-50 border border-red-200 rounded-lg px-4 py-3 mb-6">

<p class="text-red-700 font-semibold">

<?php echo $error; ?>

</p>

</div>

<?php } ?>

<form
action="validar_login.php"
method="POST"
class="space-y-5">

<div>

<label class="block text-sm font-semibold text-slate-700 mb-1">

Correo electrónico

</label>

<input
type="email"
name="emailUsu"
required
class="input-field w-full border border-slate-300 rounded-lg px-4 py-3 text-sm">

</div>

<div>

<label class="block text-sm font-semibold text-slate-700 mb-1">

Contraseña

</label>

<input
type="password"
name="passUsu"
required
class="input-field w-full border border-slate-300 rounded-lg px-4 py-3 text-sm">

</div>

<button
type="submit"
class="btn-primary w-full bg-[#0c1f3f] text-white font-semibold rounded-lg py-3">

Ingresar

</button>

</form>

<div class="text-center mt-6">

<a href="../registro/registro.php"
class="text-[#3b82f6] font-semibold hover:underline">

Crear cuenta gratis

</a>

</div>

</div>

</div>

</div>

</body>
</html>
```
