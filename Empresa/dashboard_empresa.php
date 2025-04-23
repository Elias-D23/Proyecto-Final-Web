<?php
session_start();
require_once("../Libreria/conexion.php");

// Verificar sesión y rol
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'empresa') {
    header("Location: ../login.php");
    exit();
}

// Obtener datos de la empresa para mostrar el nombre
$empresa = conexion::consulta("SELECT nombre_empresa FROM empresas WHERE usuario_id = ?", [$_SESSION['usuario_id']]);
$nombre_empresa = $empresa ? $empresa[0]->nombre_empresa : "Empresa";

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Empresa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Barra de Navegación -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard_empresa.php"><?= htmlspecialchars($nombre_empresa) ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarEmpresa" aria-controls="navbarEmpresa" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarEmpresa">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" href="dashboard_empresa.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="publicar_oferta.php">Publicar Oferta</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ver_candidatos.php">Ver Candidatos</a>
                </li>
            </ul>
            <form class="d-flex" method="POST" action="../logout.php">
                <button class="btn btn-outline-light" type="submit">Cerrar Sesión</button>
            </form>
        </div>
    </div>
</nav>

<!-- Contenido Principal -->
<div class="container mt-5">
    <h1 class="display-5">¡Bienvenido(a), <?= htmlspecialchars($nombre_empresa) ?>!</h1>
    <p class="lead">Aquí puedes gestionar tus ofertas de empleo y ver los candidatos interesados.</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
