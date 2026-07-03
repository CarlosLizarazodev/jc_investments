<?php
include("../config/conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Crear cuenta - JC Investments</title>

<script src="https://cdn.tailwindcss.com"></script>

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>

body{
font-family:'Inter',sans-serif;
}

.font-display{
font-family:'Playfair Display',serif;
}

.input-field{
transition:.2s;
}

.input-field:focus{
outline:none;
border-color:#3b82f6;
box-shadow:0 0 0 3px rgba(59,130,246,.15);
}

.btn-primary{
transition:.2s;
}

.btn-primary:hover{
background:#2f6fe0;
}

</style>

</head>

<body class="bg-white">

<div class="grid lg:grid-cols-2 min-h-screen">

<!-- PANEL IZQUIERDO -->

<div class="bg-gradient-to-br from-[#10254a] to-[#0c1f3f] text-white p-10 flex flex-col justify-center">

<h1 class="font-display text-5xl font-black mb-4">
Empieza a construir tu futuro hoy
</h1>

<p class="text-slate-300 text-lg mb-10">
Crea tu cuenta gratis y accede a préstamos rápidos con las mejores tasas.
</p>

<div class="space-y-4">

<div>
✅ Sin largas filas ni papeleo físico
</div>

<div>
🔒 Tus datos 100% seguros
</div>

<div>
📈 Seguimiento en tiempo real de tu solicitud
</div>

</div>

</div>

<!-- PANEL DERECHO -->

<div class="p-8 lg:p-16 flex items-center justify-center">

<div class="w-full max-w-xl">

<h2 class="font-display text-4xl font-black text-[#0c1f3f] mb-2">
Crear cuenta
</h2>

<p class="text-slate-500 mb-8">
Completa tus datos para comenzar.
</p>

<form action="guardar_registro.php" method="POST" class="space-y-5">

<div class="grid md:grid-cols-2 gap-4">

<div>
<label class="block mb-1 font-semibold">
Primer Nombre
</label>

<input
type="text"
name="nomUsu1"
required
class="input-field w-full border rounded-lg p-3">
</div>

<div>
<label class="block mb-1 font-semibold">
Segundo Nombre
</label>

<input
type="text"
name="nomUsu2"
class="input-field w-full border rounded-lg p-3">
</div>

</div>

<div class="grid md:grid-cols-2 gap-4">

<div>
<label class="block mb-1 font-semibold">
Primer Apellido
</label>

<input
type="text"
name="apeUsu1"
required
class="input-field w-full border rounded-lg p-3">
</div>

<div>
<label class="block mb-1 font-semibold">
Segundo Apellido
</label>

<input
type="text"
name="apeUsu2"
class="input-field w-full border rounded-lg p-3">
</div>

</div>

<div>

<label class="block mb-1 font-semibold">
Documento
</label>

<input
type="text"
name="docUsu"
required
class="input-field w-full border rounded-lg p-3">

</div>

<div>

<label class="block mb-1 font-semibold">
Teléfono
</label>

<input
type="text"
name="telUsu"
class="input-field w-full border rounded-lg p-3">

</div>

<div>

<label class="block mb-1 font-semibold">
Correo Electrónico
</label>

<input
type="email"
name="emailUsu"
required
class="input-field w-full border rounded-lg p-3">

</div>

<div>

<label class="block mb-1 font-semibold">
Contraseña
</label>

<input
type="password"
name="passUsu"
required
class="input-field w-full border rounded-lg p-3">

</div>

<button
type="submit"
class="btn-primary w-full bg-[#0c1f3f] text-white py-3 rounded-lg font-semibold">

Crear mi cuenta

</button>

</form>

<div class="text-center mt-6">

¿Ya tienes cuenta?

<a
href="../login/login.php"
class="text-blue-600 font-semibold">

Iniciar sesión

</a>

</div>

</div>

</div>

</div>

</body>
</html>