
<?php
session_start();
require_once 'Libreria/conexion.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    $usuario = conexion::consulta("SELECT * FROM usuarios WHERE correo = ?", [$correo]);

    if ($usuario && password_verify($contrasena, $usuario[0]->contrasena)) {
        $_SESSION['usuario_id'] = $usuario[0]->id;
        $_SESSION['rol'] = $usuario[0]->rol;
        $_SESSION['correo'] = $usuario[0]->correo;

        if ($usuario[0]->rol == 'empresa') {
            header("Location: empresa/registro_empresa.php"); // Redirección para empresas
        } else {
            // Verificar si el candidato ya tiene su CV registrado
            $candidato = conexion::consulta("SELECT id FROM candidatos WHERE usuario_id = ?", [$usuario[0]->id]);

            if ($candidato) {
                header("Location: candidato/dashboard_candidato.php");
            } else {
                header("Location: candidato/registro_cv.php");
            }
        }
        exit;
    } else {
        $mensaje = "Correo o contraseña incorrectos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión - TuPlataformaDeEmpleos</title>
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

        .btn-success {
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            padding: 15px;
            font-weight: bold;
            color: white;
            transition: background-color 0.3s ease;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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
            <div class="collapse navbar-collapse" id="navbarLogin">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link active" href="login.php">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card mx-auto shadow">
            <div class="card-body">
                <h4 class="card-title text-center mb-4">Accede a tu Cuenta</h4>
                <?php if ($mensaje): ?>
                    <div class="alert alert-danger"><?= $mensaje ?></div>
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
                    <button type="submit" class="btn btn-success w-100">Iniciar sesión</button>
                </form>
                <p class="mt-3 text-center">¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
            </div>
        </div>
    </div>

    <footer class="mt-auto">
        <p class="text-center py-3">&copy; 2025 ~ Workly ~</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

















<?php
/*
session_start();
require_once 'Libreria/conexion.php';

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    $usuario = conexion::consulta("SELECT * FROM usuarios WHERE correo = ?", [$correo]);

    if ($usuario && password_verify($contrasena, $usuario[0]->contrasena)) {
        $_SESSION['usuario_id'] = $usuario[0]->id;
        $_SESSION['rol'] = $usuario[0]->rol;
        $_SESSION['correo'] = $usuario[0]->correo;

        if ($usuario[0]->rol == 'empresa') {
            header("Location: empresa/registro_empresa.php"); // Redirección para empresas
        } else {
            // Verificar si el candidato ya tiene su CV registrado
            $candidato = conexion::consulta("SELECT id FROM candidatos WHERE usuario_id = ?", [$usuario[0]->id]);

            if ($candidato) {
                header("Location: candidato/dashboard_candidato.php");
            } else {
                header("Location: candidato/registro_cv.php");
            }
        }
        exit;
    } else {
        $mensaje = "Correo o contraseña incorrectos.";
    }
}
     */
?>

 
<!-- <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Plataforma de Empleos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Plataforma Empleos</a>
            <div class="collapse navbar-collapse" id="navbarEmpresa">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link active" href="login.php">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="card mx-auto shadow" style="max-width: 500px;">
            <div class="card-body">
                <h4 class="card-title text-center mb-4">Iniciar Sesión</h4>
                <?php if ($mensaje): ?>
                    <div class="alert alert-danger"><?= $mensaje ?></div>
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
                    <button type="submit" class="btn btn-success w-100">Iniciar sesión</button>
                </form>
                <p class="mt-3 text-center">¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
            </div>
        </div>
    </div>
</body>
</html> -->
