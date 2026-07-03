<?php

include("seguridad_cliente.php");
include("../config/conexion.php");

$idUsu = $_SESSION['idUsu'];

$sqlPuntaje = "
    SELECT *
    FROM puntaje
    WHERE idUsu='$idUsu'
    LIMIT 1
";

$resPuntaje = mysqli_query($conn, $sqlPuntaje);
$puntaje    = mysqli_fetch_assoc($resPuntaje);

$puntos = 0;
$nivel  = 'BRONCE';

if($puntaje){
    $puntos = $puntaje['puntos'];
    $nivel  = $puntaje['nivel'];
}

// ── Conteos originales ──────────────────────────────────────────────────────

$totalSolicitudes = mysqli_num_rows(
    mysqli_query($conn, "
        SELECT * FROM solicitud WHERE idUsu='$idUsu'
    ")
);

$totalPrestamos = mysqli_num_rows(
    mysqli_query($conn, "
        SELECT * FROM prestamo WHERE idUsu='$idUsu'
    ")
);

$totalPagos = mysqli_num_rows(
    mysqli_query($conn, "
        SELECT * FROM pago WHERE idUsu='$idUsu'
    ")
);

$totalCuotas = mysqli_num_rows(
    mysqli_query($conn, "
        SELECT c.*
        FROM cuota c
        INNER JOIN prestamo p ON c.idPres = p.idPres
        WHERE p.idUsu='$idUsu'
    ")
);

// ── Nuevas consultas ────────────────────────────────────────────────────────

// Billetera del cliente
$resBilletera = mysqli_query($conn, "
    SELECT * FROM billetera WHERE idUsu='$idUsu' LIMIT 1
");
$billetera = $resBilletera ? mysqli_fetch_assoc($resBilletera) : null;
$saldoDisponible = $billetera ? (float)$billetera['saldo'] : 0;

// Préstamos activos
$totalPrestamosActivos = mysqli_num_rows(
    mysqli_query($conn, "
        SELECT * FROM prestamo
        WHERE idUsu='$idUsu' AND estadoPres='ACTIVO'
    ")
);

// Cuotas pendientes
$totalCuotasPendientes = mysqli_num_rows(
    mysqli_query($conn, "
        SELECT c.*
        FROM cuota c
        INNER JOIN prestamo p ON c.idPres = p.idPres
        WHERE p.idUsu='$idUsu' AND c.estadoCuo='PENDIENTE'
    ")
);

// Pagos realizados
$totalPagosRealizados = mysqli_num_rows(
    mysqli_query($conn, "
        SELECT * FROM pago WHERE idUsu='$idUsu' AND estadoPag='REGISTRADO'
    ")
);

// Última solicitud
$resUltimaSolicitud = mysqli_query($conn, "
    SELECT estadoSol, fechaSol
    FROM solicitud
    WHERE idUsu='$idUsu'
    ORDER BY fechaSol DESC
    LIMIT 1
");
$ultimaSolicitud = $resUltimaSolicitud ? mysqli_fetch_assoc($resUltimaSolicitud) : null;

// Mapa de estado → estilo badge
$estadoBadge = [
    'pendiente'  => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'dot' => 'bg-yellow-400', 'label' => 'Pendiente'],
    'aprobada'   => ['bg' => 'bg-green-100',  'text' => 'text-green-800',  'dot' => 'bg-green-400',  'label' => 'Aprobada'],
    'rechazada'  => ['bg' => 'bg-red-100',    'text' => 'text-red-800',    'dot' => 'bg-red-400',    'label' => 'Rechazada'],
    'en_revision'=> ['bg' => 'bg-blue-100',   'text' => 'text-blue-800',   'dot' => 'bg-blue-400',   'label' => 'En Revisión'],
];
$estadoKey   = $ultimaSolicitud ? strtolower($ultimaSolicitud['estadoSol']) : '';
$badge       = $estadoBadge[$estadoKey] ?? ['bg' => 'bg-slate-100', 'text' => 'text-slate-600', 'dot' => 'bg-slate-400', 'label' => ucfirst($estadoKey)];

?>
<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Cliente - JC Investments</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body        { font-family: 'Inter', sans-serif; }
        .font-display { font-family: 'Playfair Display', serif; }
    </style>

</head>
<body class="bg-slate-50 text-slate-800">

<!-- ── HEADER ────────────────────────────────────────────────────────────── -->
<header class="w-full bg-[#0a1730] border-b border-white/5">
    <div class="flex items-center justify-between px-6 py-4">

        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-[#3b82f6] flex items-center justify-center text-white font-bold">
                JC
            </div>
            <span class="text-white font-bold text-lg">JC Investments</span>
        </div>

        <div>
            <a href="../login/logout.php"
               class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold">
                Cerrar Sesión
            </a>
        </div>

    </div>
</header>

<div class="flex">

    <!-- ── SIDEBAR ───────────────────────────────────────────────────────── -->
    <aside class="hidden md:flex w-64 flex-col bg-[#0c1f3f] min-h-screen text-white">

        <div class="p-5">
            <p class="text-xs uppercase tracking-wider text-slate-400">Cliente</p>
            <h3 class="mt-2 font-bold"><?php echo $_SESSION['nombre']; ?></h3>
        </div>

        <nav class="px-3 space-y-2">
            <a href="dashboard_cliente.php" class="block bg-blue-600 px-4 py-3 rounded-lg">Dashboard</a>
            <a href="nueva_solicitud.php"   class="block px-4 py-3 rounded-lg hover:bg-white/10">Nueva Solicitud</a>
            <a href="mis_solicitudes.php"   class="block px-4 py-3 rounded-lg hover:bg-white/10">Mis Solicitudes</a>
            <a href="mis_prestamos.php"     class="block px-4 py-3 rounded-lg hover:bg-white/10">Mis Préstamos</a>
            <a href="mis_cuotas.php"        class="block px-4 py-3 rounded-lg hover:bg-white/10">Mis Cuotas</a>
            <a href="mis_pagos.php"         class="block px-4 py-3 rounded-lg hover:bg-white/10">Mis Pagos</a>
        </nav>

    </aside>

    <!-- ── CONTENIDO PRINCIPAL ───────────────────────────────────────────── -->
    <main class="flex-1 p-6">

        <!-- Banner de bienvenida (original) -->
        <div class="bg-gradient-to-r from-[#1d3f73] to-[#3b82f6] rounded-2xl p-6 text-white mb-6">
            <h1 class="font-display text-3xl font-bold">
                Bienvenido, <?php echo $_SESSION['nombre']; ?>
            </h1>
            <p class="mt-2 text-blue-100">
                Administra tus préstamos, cuotas y pagos desde tu panel.
            </p>

            <div class="mt-5 flex gap-4 flex-wrap">
                <div class="bg-white/20 px-4 py-2 rounded-lg">
                    ⭐ Puntos: <b><?php echo $puntos; ?></b>
                </div>
                <div class="bg-yellow-500 text-black px-4 py-2 rounded-lg font-bold">
                    🏆 Nivel: <?php echo $nivel; ?>
                </div>
            </div>
        </div>

        <!-- ── Tarjetas originales ──────────────────────────────────────── -->
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">

            <div class="bg-white rounded-xl shadow p-5">
                <p class="text-slate-500 text-sm">Solicitudes</p>
                <h2 class="text-4xl font-bold text-blue-600 mt-2"><?php echo $totalSolicitudes; ?></h2>
            </div>

            <div class="bg-white rounded-xl shadow p-5">
                <p class="text-slate-500 text-sm">Préstamos</p>
                <h2 class="text-4xl font-bold text-green-600 mt-2"><?php echo $totalPrestamos; ?></h2>
            </div>

            <div class="bg-white rounded-xl shadow p-5">
                <p class="text-slate-500 text-sm">Cuotas</p>
                <h2 class="text-4xl font-bold text-orange-600 mt-2"><?php echo $totalCuotas; ?></h2>
            </div>

            <div class="bg-white rounded-xl shadow p-5">
                <p class="text-slate-500 text-sm">Pagos</p>
                <h2 class="text-4xl font-bold text-purple-600 mt-2"><?php echo $totalPagos; ?></h2>
            </div>

        </div>

        <!-- ── NUEVAS TARJETAS: detalle operativo ──────────────────────── -->
        <div class="grid md:grid-cols-3 gap-5 mb-6">

            <!-- Préstamos activos -->
            <div class="bg-white rounded-xl shadow p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-slate-500 text-sm">Préstamos Activos</p>
                    <h2 class="text-3xl font-bold text-green-600"><?php echo $totalPrestamosActivos; ?></h2>
                </div>
            </div>

            <!-- Cuotas pendientes -->
            <div class="bg-white rounded-xl shadow p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-slate-500 text-sm">Cuotas Pendientes</p>
                    <h2 class="text-3xl font-bold text-orange-600"><?php echo $totalCuotasPendientes; ?></h2>
                </div>
            </div>

            <!-- Pagos realizados -->
            <div class="bg-white rounded-xl shadow p-5 flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-slate-500 text-sm">Pagos Realizados</p>
                    <h2 class="text-3xl font-bold text-purple-600"><?php echo $totalPagosRealizados; ?></h2>
                </div>
            </div>

        </div>

        <!-- ── Mi Perfil Financiero ─────────────────────────────────────── -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">

            <h2 class="text-2xl font-bold mb-4">Mi Perfil Financiero</h2>

            <?php
            $confiabilidad = 50;
            if($nivel == 'PLATA')    { $confiabilidad = 70;  }
            if($nivel == 'ORO')      { $confiabilidad = 85;  }
            if($nivel == 'PLATINO')  { $confiabilidad = 95;  }
            if($nivel == 'DIAMANTE') { $confiabilidad = 100; }
            ?>

            <div class="grid md:grid-cols-3 gap-5">

                <div>
                    <p class="text-slate-500">Nivel</p>
                    <h2 class="text-3xl font-bold text-blue-700"><?php echo $nivel; ?></h2>
                </div>

                <div>
                    <p class="text-slate-500">Confiabilidad</p>
                    <h2 class="text-3xl font-bold text-green-600"><?php echo $confiabilidad; ?>%</h2>
                </div>

                <div>
                    <p class="text-slate-500">Estado</p>
                    <h2 class="text-2xl font-bold text-purple-600">
                        <?php
                        if($confiabilidad < 70)      { echo "Cliente Nuevo";      }
                        elseif($confiabilidad < 90)  { echo "Buen Cliente";       }
                        else                         { echo "Excelente Cliente";  }
                        ?>
                    </h2>
                </div>

            </div>

        </div>

        <!-- ── Beneficios Disponibles ────────────────────────────────────── -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">

            <h2 class="text-2xl font-bold mb-4">Beneficios Disponibles</h2>

            <?php
            $beneficio = 'Sin beneficios';
            if($nivel == 'PLATA')    { $beneficio = '5% facilidad de aprobación';  }
            if($nivel == 'ORO')      { $beneficio = '10% facilidad de aprobación'; }
            if($nivel == 'PLATINO')  { $beneficio = '15% facilidad de aprobación'; }
            if($nivel == 'DIAMANTE') { $beneficio = '20% facilidad de aprobación'; }
            ?>

            <div class="bg-green-100 border border-green-300 rounded-xl p-5">
                <p class="text-slate-600">Beneficio actual</p>
                <h2 class="text-2xl font-bold text-green-700 mt-2"><?php echo $beneficio; ?></h2>
            </div>

        </div>

        <!-- ── Fila inferior: Billetera + Última solicitud ──────────────── -->
        <div class="grid md:grid-cols-2 gap-6 mb-6">

            <!-- SECCIÓN "Mi dinero disponible" -->
            <div class="bg-white rounded-xl shadow p-6">

                <h2 class="text-xl font-bold mb-1">Mi dinero disponible</h2>
                <p class="text-slate-500 text-sm mb-5">Saldo actual en tu billetera JC Investments</p>

                <div class="bg-gradient-to-br from-[#1d3f73] to-[#3b82f6] rounded-xl p-5 text-white mb-5">
                    <p class="text-blue-200 text-sm uppercase tracking-wider mb-1">Saldo disponible</p>
                    <p class="text-4xl font-bold font-display">
                        $<?php echo number_format($saldoDisponible, 2, ',', '.'); ?>
                    </p>
                    <?php if (!$billetera): ?>
                        <p class="text-blue-200 text-xs mt-2">No tienes billetera registrada aún.</p>
                    <?php else: ?>
                        <p class="text-blue-200 text-xs mt-2">
                            Billetera #<?php echo htmlspecialchars($billetera['idBil']); ?>
                        </p>
                    <?php endif; ?>
                </div>

                <div class="flex gap-3">
                    <a href="retirar_banco.php"
                       class="flex-1 bg-[#1d3f73] hover:bg-[#162e55] text-white text-center py-3 rounded-lg font-semibold transition-colors">
                        Retirar a banco
                    </a>
                    <a href="ver_movimientos.php"
                       class="flex-1 border border-slate-300 hover:bg-slate-50 text-slate-700 text-center py-3 rounded-lg font-semibold transition-colors">
                        Ver movimientos
                    </a>
                </div>

            </div>

            <!-- Estado de la última solicitud -->
            <div class="bg-white rounded-xl shadow p-6">

                <h2 class="text-xl font-bold mb-1">Última Solicitud</h2>
                <p class="text-slate-500 text-sm mb-5">Estado actual de tu solicitud más reciente</p>

                <?php if ($ultimaSolicitud): ?>

                    <div class="flex items-center gap-3 mb-4">
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-semibold
                                     <?php echo $badge['bg'] . ' ' . $badge['text']; ?>">
                            <span class="w-2 h-2 rounded-full <?php echo $badge['dot']; ?>"></span>
                            <?php echo $badge['label']; ?>
                        </span>
                    </div>

                    <p class="text-slate-500 text-sm">
                        Fecha de solicitud:
                        <span class="text-slate-700 font-medium">
                            <?php echo date('d/m/Y', strtotime($ultimaSolicitud['fechaSol'])); ?>
                        </span>
                    </p>

                    <a href="mis_solicitudes.php"
                       class="mt-5 inline-block text-blue-600 hover:underline text-sm font-medium">
                        Ver todas mis solicitudes →
                    </a>

                <?php else: ?>

                    <div class="flex flex-col items-center justify-center py-8 text-slate-400">
                        <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2 2 0 002-2V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V19.5a2 2 0 002 2h9a2 2 0 002-2V6.108"/>
                        </svg>
                        <p class="text-sm">No tienes solicitudes aún.</p>
                        <a href="nueva_solicitud.php"
                           class="mt-3 text-blue-600 hover:underline text-sm font-medium">
                            Crear primera solicitud →
                        </a>
                    </div>

                <?php endif; ?>

            </div>

        </div>

        <!-- ── Accesos rápidos (original) ──────────────────────────────── -->
        <div class="bg-white rounded-xl shadow p-6">

            <h2 class="text-xl font-bold mb-4">Accesos Rápidos</h2>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">

                <a href="nueva_solicitud.php"
                   class="bg-blue-600 text-white text-center py-4 rounded-lg font-semibold">
                    Nueva Solicitud
                </a>

                <a href="mis_solicitudes.php"
                   class="bg-emerald-600 text-white text-center py-4 rounded-lg font-semibold">
                    Mis Solicitudes
                </a>

                <a href="mis_prestamos.php"
                   class="bg-amber-500 text-white text-center py-4 rounded-lg font-semibold">
                    Mis Préstamos
                </a>

                <a href="mis_cuotas.php"
                   class="bg-red-500 text-white text-center py-4 rounded-lg font-semibold">
                    Mis Cuotas
                </a>

                <a href="mis_pagos.php"
                   class="bg-cyan-600 text-white text-center py-4 rounded-lg font-semibold">
                    Mis Pagos
                </a>

            </div>

        </div>

    </main>

</div>

</body>
</html>