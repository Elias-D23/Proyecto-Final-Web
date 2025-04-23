<?php
require_once 'Libreria/conexion.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
    $rol = $_POST['rol'];

    $existe = conexion::consulta("SELECT * FROM usuarios WHERE correo = ?", [$correo]);

    if ($existe) {
        $mensaje = "Ya existe un usuario con ese correo.";
    } else {
        conexion::insertar("INSERT INTO usuarios (correo, contrasena, rol) VALUES (?, ?, ?)", [$correo, $contrasena, $rol]);
        $mensaje = "Registro exitoso. Ya puedes iniciar sesión.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Regístrate - TuPlataformaDeEmpleos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f7f5;
            color: #333;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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
            flex-grow: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 30px;
        }

        .card {
            border: none;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            width: 100%;
            max-width: 500px;
        }

        .card-body {
            padding: 30px;
        }

        .card-title {
            font-size: 2em;
            color: #222;
            margin-bottom: 30px;
            text-align: center;
        }

        .form-label {
            color: #555;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .form-control {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 1em;
        }

        .form-select {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 1em;
            color: #555;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            padding: 15px;
            font-weight: bold;
            color: white;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .alert-info {
            background-color: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
            text-align: center;
        }

        .mt-3 {
            margin-top: 20px;
        }

        .text-center {
            text-align: center;
        }

        .mt-3 a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        .mt-3 a:hover {
            text-decoration: underline;
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
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">~ Workly ~</a>
            <div class="collapse navbar-collapse" id="navbarRegistro">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link active" href="registro.php">Registro</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card mx-auto shadow">
            <div class="card-body">
                <h4 class="card-title text-center mb-4">Crea tu Cuenta</h4>
                <?php if ($mensaje): ?>
                    <div class="alert alert-info"><?= $mensaje ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo electrónico</label>
                        <input type="email" name="correo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="contrasena" class="form-label">Contraseña</label>
                        <input type="password" name="contrasena" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="rol" class="form-label">¿Eres?</label>
                        <select name="rol" class="form-select" required>
                            <option value="candidato">Buscador de Empleo</option>
                            <option value="empresa">Empresa</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                </form>
                <p class="mt-3 text-center">¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a></p>
            </div>
        </div>
    </div>

    <footer class="mt-auto">
        <p class="text-center py-3">&copy; 2025 ~ Workly ~</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


<!--
<php 
require_once 'Libreria/conexion.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
    $rol = $_POST['rol'];

    $existe = conexion::consulta("SELECT * FROM usuarios WHERE correo = ?", [$correo]);

    if ($existe) {
        $mensaje = "Ya existe un usuario con ese correo.";
    } else {
        conexion::insertar("INSERT INTO usuarios (correo, contrasena, rol) VALUES (?, ?, ?)", [$correo, $contrasena, $rol]);
        $mensaje = "Registro exitoso. Ya puedes iniciar sesión.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Plataforma de Empleos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card mx-auto shadow" style="max-width: 500px;">
            <div class="card-body">
                <h4 class="card-title text-center mb-4">Registro de Usuario</h4>
                <?php if ($mensaje): ?>
                    <div class="alert alert-info"><?= $mensaje ?></div>
                <?php endif; ?>
                <form method="POST">
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo electrónico</label>
                        <input type="email" name="correo" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="contrasena" class="form-label">Contraseña</label>
                        <input type="password" name="contrasena" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="rol" class="form-label">Rol</label>
                        <select name="rol" class="form-select" required>
                            <option value="candidato">Candidato</option>
                            <option value="empresa">Empresa</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                </form>
                <p class="mt-3 text-center">¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a></p>
            </div>
        </div>
    </div>
</body>
</html> -->
