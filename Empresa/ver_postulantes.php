<?php
session_start();
require_once("../Libreria/conexion.php");

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'empresa') {
    header("Location: ../login.php");
    exit();
}

$oferta_id = $_GET['oferta_id'] ?? null;

if (!$oferta_id) {
    header("Location: ver_candidatos.php");
    exit();
}

// Verificamos que la oferta pertenezca a esta empresa
$empresa = conexion::consulta("SELECT id FROM empresas WHERE usuario_id = ?", [$_SESSION['usuario_id']]);
$empresa_id = $empresa ? $empresa[0]->id : null;

$oferta = conexion::consulta("SELECT * FROM ofertas WHERE id = ? AND id_empresa = ?", [$oferta_id, $empresa_id]);

if (!$oferta) {
    echo "<div class='alert alert-danger m-5'>Acceso no autorizado.</div>";
    exit();
}

// Obtenemos los candidatos aplicantes
// Obtenemos los candidatos aplicantes con su correo desde usuarios
$candidatos = conexion::consulta("
    SELECT c.*, u.correo, a.fecha_aplicacion
    FROM aplicaciones a
    JOIN candidatos c ON c.id = a.id_candidato
    JOIN usuarios u ON u.id = c.usuario_id
    WHERE a.id_oferta = ?
", [$oferta_id]);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Postulantes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-candidato {
            border-radius: 1rem;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .foto-candidato {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
        }
    </style>
</head>
<body>

<?php include("navbar_empresa.php"); ?>

<div class="container mt-5">
    <h2 class="mb-4">Postulantes a: <strong><?= htmlspecialchars($oferta[0]->titulo_puesto) ?></strong></h2>

    <?php if ($candidatos): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            
            <?php foreach ($candidatos as $c): ?>
            <div class="col">
                <div class="card card-candidato h-100 p-3 text-center">
                    <h5 class="card-title mb-2"><?= htmlspecialchars($c->nombre . " " . $c->apellido) ?></h5>

                    <center>
                        <?php if ($c->foto): ?>
                            <img src="../uploads/<?= htmlspecialchars($c->foto) ?>" class="img-fluid rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover; border: 5px solid gainsboro;" alt="Foto de <?= htmlspecialchars($c->nombre) ?>">
                        <?php else: ?>
                            <img src="https://media.istockphoto.com/id/1142192548/es/vector/perfil-de-avatar-hombre-silueta-de-cara-masculina-o-icono-aislado-sobre-fondo-blanco.jpg?s=612x612&w=0&k=20&c=O6KtgzjlrIvoGi2Cb1ZyppWKlqGL_5IXVHLUdLN33Ag=" class="img-fluid rounded-circle mb-3" alt="Foto por defecto">
                        <?php endif; ?>
                    </center>

                    <div class="card-body text-start">
                        <p><strong>Correo:</strong> <?= htmlspecialchars($c->correo) ?></p>
                        <p><strong>Ciudad:</strong> <?= htmlspecialchars($c->ciudad_provincia) ?></p>
                        <p><strong>Teléfono:</strong> <?= htmlspecialchars($c->telefono) ?></p>
                        <p><strong>Objetivo:</strong><br><?= nl2br(htmlspecialchars($c->objetivo_profesional)) ?></p>
                        <p><strong>Habilidades:</strong><br><?= nl2br(htmlspecialchars($c->habilidades_clave)) ?></p>
                        <p><strong>Idiomas:</strong><br><?= nl2br(htmlspecialchars($c->idiomas)) ?></p>

                        <div class="d-flex flex-wrap gap-2 mt-2">
                            <?php if ($c->cv_pdf): ?>
                                <a href="../uploads/<?= htmlspecialchars($c->cv_pdf) ?>" class="btn btn-outline-primary btn-sm" target="_blank">Ver CV PDF</a>
                            <?php endif; ?>
                            <a href="mailto:<?= htmlspecialchars($c->correo) ?>" class="btn btn-outline-secondary btn-sm">Enviar correo</a>
                        </div>
                    </div>

                    <div class="card-footer text-muted text-end">
                        Aplicó el <?= date("d/m/Y H:i", strtotime($c->fecha_aplicacion)) ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">Ningún candidato se ha postulado aún a esta oferta.</div>
    <?php endif; ?>
</div>


</body>
</html>
