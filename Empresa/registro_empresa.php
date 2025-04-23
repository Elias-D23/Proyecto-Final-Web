<?php
session_start();
require_once("../Libreria/conexion.php");

// Verificar si el usuario es una empresa
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'empresa') {
    header("Location: ../login.php");
    exit();
}

// Si ya ha registrado la empresa, lo redirigimos a su dashboard
$yaRegistrada = conexion::consulta("SELECT * FROM empresas WHERE usuario_id = ?", [$_SESSION['usuario_id']]);
if ($yaRegistrada) {
    header("Location: dashboard_empresa.php");
    exit();
}

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $contacto = $_POST['contacto'];
    $usuario_id = $_SESSION['usuario_id'];

    $sql = "INSERT INTO empresas (usuario_id, nombre_empresa, direccion, telefono) VALUES (?, ?, ?, ?)";
    $resultado = conexion::insertar($sql, [$usuario_id, $nombre, $direccion, $contacto]);

    if ($resultado) {
        header("Location: dashboard_empresa.php");
        exit();
    } else {
        $mensaje = "Error al guardar los datos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro Empresa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow p-4">
            <h3 class="mb-4">Completa tu perfil de empresa</h3>
            <?php if ($mensaje): ?>
                <div class="alert alert-danger"><?= $mensaje ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Nombre de la Empresa</label>
                    <input type="text" class="form-control" name="nombre" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Dirección</label>
                    <input type="text" class="form-control" name="direccion" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Teléfono / Contacto</label>
                    <input type="text" class="form-control" name="contacto" required>
                </div>
                <button type="submit" class="btn btn-primary">Guardar Empresa</button>
            </form>
        </div>
    </div>
</body>
</html>
