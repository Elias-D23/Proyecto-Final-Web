<?php
session_start();
require_once("../Libreria/conexion.php");

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'candidato') {
    header("Location: ../login.php");
    exit();
}

// Traer usuario y candidato como objetos
$usuarioArr = conexion::consulta("SELECT correo FROM usuarios WHERE id = ?", [$_SESSION['usuario_id']]);
$usuario = $usuarioArr[0] ?? null;

$candidatoArr = conexion::consulta("SELECT * FROM candidatos WHERE usuario_id = ?", [$_SESSION['usuario_id']]);
$candidato = $candidatoArr[0] ?? null;

// Si no hay perfil aún, forzar a crear CV
if (!$candidato) {
    header("Location: registro_cv.php");
    exit();
}

// Datos para mostrar
$nombreCompleto  = trim("{$candidato->nombre} {$candidato->apellido}");
$correo          = $usuario->correo;
$foto            = $candidato->foto;
$telefono        = $candidato->telefono;
$direccion       = $candidato->direccion;
$ciudad          = $candidato->ciudad_provincia;
$redes           = $candidato->redes_profesionales;
$referencias     = $candidato->referencias;
$formacion       = $candidato->formacion_academica;
$experiencia     = $candidato->experiencia_laboral;
$habilidades     = $candidato->habilidades_clave;
$idiomas         = $candidato->idiomas;
$objetivo        = $candidato->objetivo_profesional;
$logros          = $candidato->logros_proyectos;
$disponibilidad  = $candidato->disponibilidad;
$cv_pdf          = $candidato->cv_pdf;
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Perfil de Candidato</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .profile-header { text-align: center; margin: 40px 0; }
    .profile-header img { width:120px; height:120px; object-fit:cover; border-radius:50%; margin-bottom:20px; }
    .section-title { margin:30px 0 15px; font-weight:bold; color:#333; }
    .btn-group-sm > .btn { padding:.25rem .5rem; font-size:.875rem; }
  </style>
</head>
<body>

<?php include("navbar_candidato.php"); ?>

<div class="container">
  <div class="profile-header">
    <?php if ($foto): ?>
      <img src="../uploads/<?= htmlspecialchars($foto) ?>" alt="Foto de perfil">
    <?php else: ?>
      <img src="https://via.placeholder.com/120" alt="Sin foto">
    <?php endif; ?>

    <h2><?= htmlspecialchars($nombreCompleto) ?></h2>
    <p><strong>Correo:</strong> <?= htmlspecialchars($correo) ?></p>

    <div class="btn-group btn-group-sm" role="group">
      <a href="registro_cv.php" class="btn btn-outline-primary">Editar CV</a>
      <a href="cambiar_contrasena.php" class="btn btn-outline-secondary">Cambiar Contraseña</a>
    </div>
  </div>

  <hr>

  <h4 class="section-title">Datos de Contacto</h4>
  <p><strong>Teléfono:</strong> <?= htmlspecialchars($telefono) ?></p>
  <p><strong>Dirección:</strong><br><?= nl2br(htmlspecialchars($direccion)) ?></p>
  <p><strong>Ciudad / Provincia:</strong> <?= htmlspecialchars($ciudad) ?></p>
  <p><strong>Redes Profesionales:</strong> <?= htmlspecialchars($redes) ?></p>
  <p><strong>Referencias:</strong><br><?= nl2br(htmlspecialchars($referencias)) ?></p>

  <h4 class="section-title">Formación Académica</h4>
  <p><?= nl2br(htmlspecialchars($formacion)) ?></p>

  <h4 class="section-title">Experiencia Laboral</h4>
  <p><?= nl2br(htmlspecialchars($experiencia)) ?></p>

  <h4 class="section-title">Habilidades e Idiomas</h4>
  <p><strong>Habilidades:</strong><br><?= nl2br(htmlspecialchars($habilidades)) ?></p>
  <p><strong>Idiomas:</strong> <?= htmlspecialchars($idiomas) ?></p>

  <h4 class="section-title">Objetivo Profesional</h4>
  <p><?= nl2br(htmlspecialchars($objetivo)) ?></p>

  <h4 class="section-title">Logros o Proyectos</h4>
  <p><?= nl2br(htmlspecialchars($logros)) ?></p>

  <h4 class="section-title">Disponibilidad</h4>
  <p><?= htmlspecialchars($disponibilidad) ?></p>

  <h4 class="section-title">Currículum en PDF</h4>
  <?php if ($cv_pdf): ?>
    <a href="../uploads/<?= htmlspecialchars($cv_pdf) ?>" class="btn btn-outline-primary btn-sm" target="_blank">Ver CV PDF</a>
  <?php else: ?>
    <p class="text-muted">No has subido tu CV en PDF aún.</p>
  <?php endif; ?>

</div>

<footer class="bg-light py-3 mt-5 text-center text-muted">
  &copy; 2025 TuPlataformaDeEmpleos
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
