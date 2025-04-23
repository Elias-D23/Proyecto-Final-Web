<?php
session_start();
require_once("../Libreria/conexion.php");

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'empresa') {
    header("Location: ../login.php");
    exit();
}

// Obtener empresa_id
$empresa = conexion::consulta("SELECT id FROM empresas WHERE usuario_id = ?", [$_SESSION['usuario_id']]);
$empresa_id = $empresa ? $empresa[0]->id : null;

// Consultar ofertas de la empresa con cantidad de candidatos
$ofertas = conexion::consulta("
    SELECT o.id, o.titulo_puesto, COUNT(a.id_candidato) AS total_postulantes
    FROM ofertas o
    LEFT JOIN aplicaciones a ON o.id = a.id_oferta
    WHERE o.id_empresa = ?
    GROUP BY o.id
", [$empresa_id]);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Candidatos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<?php include("navbar_empresa.php"); ?>

<div class="container mt-5">
    <h2 class="mb-4">Candidatos por Oferta</h2>

    <?php if ($ofertas): ?>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Título de la Oferta</th>
                        <th>Postulantes</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ofertas as $oferta): ?>
                        <tr>
                            <td><?= htmlspecialchars($oferta->titulo_puesto) ?></td>
                            <td><span class="badge bg-primary"><?= $oferta->total_postulantes ?></span></td>
                            <td>
                                <a href="ver_postulantes.php?oferta_id=<?= $oferta->id ?>" class="btn btn-outline-info btn-sm">
                                    Ver Candidatos
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info">No hay ofertas publicadas aún.</div>
    <?php endif; ?>
</div>

</body>
</html>
