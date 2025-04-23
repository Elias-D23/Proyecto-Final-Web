<?php
session_start();
require_once("../Libreria/conexion.php");

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'candidato') {
    header("Location: ../login.php");
    exit();
}

// Obtener nombre y ID del candidato
$usuario_id = $_SESSION['usuario_id'];
$candidato = conexion::consulta("SELECT id, nombre, foto FROM candidatos WHERE usuario_id = ?", [$usuario_id]);
$nombre = $candidato ? $candidato[0]->nombre : "Candidato";
$candidato_id = $candidato[0]->id ?? null;
$foto = $candidato[0]->foto ?? "default.jpg"; // Imagen por defecto si no tiene

// Obtener aplicaciones del candidato
$aplicaciones = conexion::consulta("
    SELECT o.id, o.titulo_puesto, o.descripcion, o.requisitos, o.fecha_publicacion, p.fecha_aplicacion
    FROM aplicaciones p
    INNER JOIN ofertas o ON p.id_oferta = o.id
    WHERE p.id_candidato = ?
    ORDER BY p.fecha_aplicacion DESC
", [$candidato_id]);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Panel - TuPlataformaDeEmpleos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f7f5;
            color: #333;
        }

        nav {
            background-color: white;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav .navbar-brand {
            font-size: 1.5em;
            font-weight: bold;
            color: #222;
        }

        nav .navbar-nav .nav-link {
            color: #555;
            font-weight: bold;
            transition: color 0.3s ease;
            margin-left: 20px;
        }

        nav .navbar-nav .nav-link:hover {
            color: #007bff;
        }

        .bienvenida {
            margin-top: 60px;
            padding: 40px 20px;
            text-align: center;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
            border-radius: 8px;
        }

        .bienvenida h1 {
            color: #222;
            margin-bottom: 20px;
            font-size: 2.2em;
        }

        .bienvenida .lead {
            color: #555;
            font-size: 1.1em;
            margin-bottom: 30px;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            background-color: white;
        }

        .card-body {
            padding: 20px;
        }

        .card-title {
            font-size: 1.5em;
            color: #333;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .card-subtitle {
            color: #777;
            font-size: 0.9em;
            margin-bottom: 15px;
        }

        .card-text {
            color: #555;
            font-size: 1em;
            margin-bottom: 10px;
        }

        .btn-outline-primary {
            color: #007bff;
            border-color: #007bff;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn-outline-primary:hover {
            background-color: #007bff;
            color: white;
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin-top: 30px;
        }

        .alert-info a {
            color: #007bff;
            font-weight: bold;
            text-decoration: none;
        }

        .alert-info a:hover {
            text-decoration: underline;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 50px;
        }

        .profile-img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
            cursor: pointer;
        }
        .dropdown-menu-end {
            right: 0;
            left: auto;
        }
    </style>
</head>
<body>

    <?php include("navbar_candidato.php"); ?>


    <div class="container bienvenida mt-5">
        <h1>¡Hola, <?= htmlspecialchars($nombre); ?>! 👋</h1>
        <p class="lead">Bienvenido a tu panel de control. Aquí puedes revisar tus postulaciones recientes y mantener tu currículum actualizado.</p>
    </div>

    <div class="container mt-5">
        <h3 class="mb-4">💼 Tus Postulaciones Recientes</h3>

        <?php if (count($aplicaciones) > 0): ?>
            <div class="grid-container">
                <?php foreach ($aplicaciones as $oferta): ?>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($oferta->titulo_puesto) ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Publicado el <?= date("d/m/Y", strtotime($oferta->fecha_publicacion)) ?></h6>
                            <p class="card-text"><strong>Fecha de Postulación:</strong> <?= date("d/m/Y H:i", strtotime($oferta->fecha_aplicacion)) ?></p>
                            <p class="card-text"><strong class="text-primary">Descripción:</strong><br><?= nl2br(htmlspecialchars(substr($oferta->descripcion, 0, 150) . '...')) ?></p>
                            <p class="card-text"><strong class="text-info">Requisitos:</strong><br><?= nl2br(htmlspecialchars(substr($oferta->requisitos, 0, 100) . '...')) ?></p>
                            <a href="ver_ofertas.php" class="btn btn-outline-primary btn-sm mt-2">Ver Detalles</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info">Aún no has aplicado a ninguna oferta. ¡Explora las <a href="ver_ofertas.php">vacantes disponibles</a>!</div>
        <?php endif; ?>
    </div>

    <footer class="bg-light py-3 mt-5 text-center text-muted">
        <p>&copy; 2025 TuPlataformaDeEmpleos</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>