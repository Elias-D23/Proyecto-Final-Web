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

// Crear oferta
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['publicar'])) {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $requisitos = $_POST['requisitos'];

    if ($empresa_id) {
        conexion::insertar("INSERT INTO ofertas (id_empresa, titulo_puesto, descripcion, requisitos, fecha_publicacion) VALUES (?, ?, ?, ?, NOW())", [
            $empresa_id, $titulo, $descripcion, $requisitos
        ]);
        header("Location: publicar_oferta.php");
        exit();
    }
}

// Editar oferta
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['actualizar'])) {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $requisitos = $_POST['requisitos'];

    conexion::exec("UPDATE ofertas SET titulo_puesto = ?, descripcion = ?, requisitos = ? WHERE id = ? AND id_empresa = ?", [
        $titulo, $descripcion, $requisitos, $id, $empresa_id
    ]);
    header("Location: publicar_oferta.php");
    exit();
}

// Eliminar oferta
if (isset($_GET['eliminar'])) {
    conexion::exec("DELETE FROM ofertas WHERE id = ? AND id_empresa = ?", [$_GET['eliminar'], $empresa_id]);
    header("Location: publicar_oferta.php");
    exit();
}

// Oferta a editar
$ofertaEditar = null;
if (isset($_GET['editar'])) {
    $ofertaEditar = conexion::consulta("SELECT * FROM ofertas WHERE id = ? AND id_empresa = ?", [$_GET['editar'], $empresa_id])[0] ?? null;
}

// Obtener todas las ofertas
$ofertas = conexion::consulta("SELECT * FROM ofertas WHERE id_empresa = ?", [$empresa_id]);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Publicar Oferta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1rem;
        }
    </style>
</head>
<body>

<?php include("navbar_empresa.php"); ?>

<div class="container mt-5">
    <h2 class="mb-4">Gestión de Ofertas</h2>

    <!-- Botón para mostrar formulario -->
    <button class="btn btn-primary mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#formOferta">
        <?= $ofertaEditar ? "Editar Oferta" : "Crear Oferta" ?>
    </button>

    <!-- Formulario: Crear o Editar -->
    <div class="collapse" id="formOferta">
        <div class="card card-body">
            <form method="POST">
                <input type="hidden" name="id" value="<?= $ofertaEditar->id ?? '' ?>">
                <div class="mb-3">
                    <label class="form-label">Título del Puesto</label>
                    <input type="text" name="titulo" class="form-control" required value="<?= $ofertaEditar->titulo_puesto ?? '' ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="3" required><?= $ofertaEditar->descripcion ?? '' ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Requisitos</label>
                    <textarea name="requisitos" class="form-control" rows="2" required><?= $ofertaEditar->requisitos ?? '' ?></textarea>
                </div>
                <button type="submit" name="<?= $ofertaEditar ? 'actualizar' : 'publicar' ?>" class="btn btn-success">
                    <?= $ofertaEditar ? 'Actualizar Oferta' : 'Publicar Oferta' ?>
                </button>
                <?php if ($ofertaEditar): ?>
                    <a href="publicar_oferta.php" class="btn btn-secondary">Cancelar</a>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <hr class="my-5">

    <h3>Ofertas Publicadas</h3>
    <div class="grid-container mt-4">
        <?php foreach ($ofertas as $oferta): ?>
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($oferta->titulo_puesto) ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted">Publicado: <?= date("d/m/Y", strtotime($oferta->fecha_publicacion)) ?></h6>
                    <p class="card-text"><strong>Descripción:</strong><br><?= nl2br(htmlspecialchars($oferta->descripcion)) ?></p>
                    <p class="card-text"><strong>Requisitos:</strong><br><?= nl2br(htmlspecialchars($oferta->requisitos)) ?></p>
                    <a href="publicar_oferta.php?editar=<?= $oferta->id ?>" class="btn btn-warning btn-sm">Editar</a>
                    <a href="publicar_oferta.php?eliminar=<?= $oferta->id ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar esta oferta?')">Eliminar</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Simular clic en el botón de colapso si estamos editando
    <?php if ($ofertaEditar): ?>
        document.addEventListener('DOMContentLoaded', function() {
            let collapseButton = document.querySelector('button[data-bs-target="#formOferta"]');
            if (collapseButton) {
                collapseButton.click();
            }
        });
    <?php endif; ?>
</script>

</body>
</html>
