<?php
session_start();
require_once("../Libreria/conexion.php");

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'candidato') {
    header("Location: ../login.php");
    exit();
}

// Obtener id del candidato desde su usuario
$candidato = conexion::consulta("SELECT id FROM candidatos WHERE usuario_id = ?", [$_SESSION['usuario_id']]);
$candidato_id = $candidato ? $candidato[0]->id : null;

// Procesar postulación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['postular'])) {
        $id_oferta = $_POST['id_oferta'];
        conexion::insertar("INSERT IGNORE INTO aplicaciones (id_candidato, id_oferta) VALUES (?, ?)", [
            $candidato_id, $id_oferta
        ]);
    } elseif (isset($_POST['cancelar'])) {
        $id_oferta = $_POST['id_oferta'];
        conexion::exec("DELETE FROM aplicaciones WHERE id_candidato = ? AND id_oferta = ?", [
            $candidato_id, $id_oferta
        ]);
    }
}

// Obtener todas las ofertas
$ofertas = conexion::consulta("SELECT * FROM ofertas ORDER BY fecha_publicacion DESC");

// Obtener las ofertas a las que el candidato ya se ha postulado
$postuladas = conexion::consulta("SELECT id_oferta FROM aplicaciones WHERE id_candidato = ?", [$candidato_id]);
$ids_postulados = array_map(fn($p) => $p->id_oferta, $postuladas);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ofertas de Empleo - TuPlataformaDeEmpleos</title>
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

        .container {
            margin-top: 30px;
        }

        h2 {
            color: #222;
            margin-bottom: 30px;
            text-align: center;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
            margin-top: 20px;
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
            margin-bottom: 15px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-weight: bold;
            color: white;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-weight: bold;
            color: white;
            transition: background-color 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            text-align: center;
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
            border-radius: 5px;
            padding: 15px;
            text-align: center;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 50px;
        }
    </style>
</head>
<body>

    <?php include("navbar_candidato.php"); ?>


    <div class="container mt-5">
        <h2 class="text-center mb-4">Explora las Oportunidades de Empleo</h2>

        <div class="grid-container">
            <?php if (count($ofertas) > 0): ?>
                <?php foreach ($ofertas as $oferta): ?>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($oferta->titulo_puesto) ?></h5>
                            <h6 class="card-subtitle mb-2 text-muted">Publicado el <?= date("d/m/Y", strtotime($oferta->fecha_publicacion)) ?></h6>
                            <p class="card-text"><strong class="text-primary">Descripción:</strong><br><?= nl2br(htmlspecialchars(substr($oferta->descripcion, 0, 150) . '...')) ?></p>
                            <p class="card-text"><strong class="text-info">Requisitos:</strong><br><?= nl2br(htmlspecialchars(substr($oferta->requisitos, 0, 100) . '...')) ?></p>

                            <form method="POST" class="mt-3">
                                <input type="hidden" name="id_oferta" value="<?= $oferta->id ?>">
                                <?php if (in_array($oferta->id, $ids_postulados)): ?>
                                    <div class="alert alert-success p-2 mb-2">
                                        ✅ Ya aplicaste a esta oferta.
                                    </div>
                                    <button type="submit" name="cancelar" class="btn btn-danger btn-sm w-100">Dejar de Postular</button>
                                <?php else: ?>
                                    <button type="submit" name="postular" class="btn btn-primary btn-sm w-100">Postular Ahora</button>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-info">No hay ofertas de empleo disponibles en este momento. Por favor, vuelve a consultar más tarde.</div>
            <?php endif; ?>
        </div>
    </div>

    <footer class="bg-light py-3 mt-5 text-center text-muted">
        <p>&copy; 2025 TuPlataformaDeEmpleos</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>