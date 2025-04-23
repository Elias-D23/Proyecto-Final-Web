<?php
session_start();
require_once("../Libreria/conexion.php");

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'candidato') {
    header("Location: ../login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$msg = "";

// Verificamos si el currículum ya existe
$candidato = conexion::consulta("SELECT * FROM candidatos WHERE usuario_id = ?", [$usuario_id]);
$candidato = $candidato ? $candidato[0] : null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $formacion = $_POST['formacion'];
    $experiencia = $_POST['experiencia'];
    $habilidades = $_POST['habilidades'];
    $idiomas = $_POST['idiomas'];
    $objetivo = $_POST['objetivo'];
    $logros = $_POST['logros'];
    $disponibilidad = $_POST['disponibilidad'];
    $redes = $_POST['redes'];
    $referencias = $_POST['referencias'];

    // Subidas de archivos
    $foto = $_FILES['foto']['name'] ? uniqid() . "_" . $_FILES['foto']['name'] : ($candidato->foto ?? null);
    $cv_pdf = $_FILES['cv_pdf']['name'] ? uniqid() . "_" . $_FILES['cv_pdf']['name'] : ($candidato->cv_pdf ?? null);

    if ($_FILES['foto']['tmp_name']) move_uploaded_file($_FILES['foto']['tmp_name'], "../uploads/" . $foto);
    if ($_FILES['cv_pdf']['tmp_name']) move_uploaded_file($_FILES['cv_pdf']['tmp_name'], "../uploads/" . $cv_pdf);

    if ($candidato) {
        // Actualizamos si ya existe
        conexion::exec("UPDATE candidatos SET
            nombre = ?, apellido = ?, telefono = ?, direccion = ?, ciudad_provincia = ?, formacion_academica = ?,
            experiencia_laboral = ?, habilidades_clave = ?, idiomas = ?, objetivo_profesional = ?, logros_proyectos = ?,
            disponibilidad = ?, redes_profesionales = ?, referencias = ?, foto = ?, cv_pdf = ?
            WHERE usuario_id = ?", [
            $nombre, $apellido, $telefono, $direccion, $ciudad, $formacion, $experiencia,
            $habilidades, $idiomas, $objetivo, $logros, $disponibilidad, $redes, $referencias, $foto, $cv_pdf, $usuario_id
        ]);
    } else {
        // Insertamos si no existe
        conexion::insertar("INSERT INTO candidatos (
            usuario_id, nombre, apellido, telefono, direccion, ciudad_provincia, formacion_academica,
            experiencia_laboral, habilidades_clave, idiomas, objetivo_profesional, logros_proyectos,
            disponibilidad, redes_profesionales, referencias, foto, cv_pdf
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
            $usuario_id, $nombre, $apellido, $telefono, $direccion, $ciudad, $formacion, $experiencia,
            $habilidades, $idiomas, $objetivo, $logros, $disponibilidad, $redes, $referencias, $foto, $cv_pdf
        ]);
    }

    header("Location: dashboard_candidato.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= $candidato ? 'Actualizar' : 'Registrar' ?> CV - TuPlataformaDeEmpleos</title>
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

        .form-container {
            max-width: 900px;
            margin: 30px auto;
            padding: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        h2 {
            color: #222;
            margin-bottom: 30px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-weight: bold;
        }

        .form-control {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 1em;
            width: 100%;
            box-sizing: border-box;
        }

        textarea.form-control {
            min-height: 100px;
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            padding: 15px 30px;
            font-weight: bold;
            color: white;
            transition: background-color 0.3s ease;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .text-end {
            text-align: right;
        }

        .img-fluid {
            max-width: 100%;
            height: auto;
        }

        .rounded {
            border-radius: 5px;
        }

        .mb-2 {
            margin-bottom: 10px;
        }

        .mt-2 {
            margin-top: 10px;
        }

        .text-danger {
            color: #dc3545 !important;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">~ Workly ~</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <!-- <li class="nav-item"><a class="nav-link active" href="dashboard_candidato.php">Mi Panel</a></li> -->

                    <li class="nav-item"><a class="nav-link text-danger" href="../logout.php">Cerrar Sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="form-container">
            <h2 class="mb-4 text-center"><?= $candidato ? 'Actualizar mi Currículum' : 'Completa tu Currículum' ?></h2>
            <form method="post" enctype="multipart/form-data">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="<?= htmlspecialchars($candidato->nombre ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="apellido">Apellido</label>
                        <input type="text" name="apellido" id="apellido" class="form-control" value="<?= htmlspecialchars($candidato->apellido ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="telefono">Teléfono</label>
                        <input type="text" name="telefono" id="telefono" class="form-control" value="<?= htmlspecialchars($candidato->telefono ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="ciudad">Ciudad / Provincia</label>
                        <input type="text" name="ciudad" id="ciudad" class="form-control" value="<?= htmlspecialchars($candidato->ciudad_provincia ?? '') ?>">
                    </div>
                    <div class="col-12">
                        <label for="direccion">Dirección</label>
                        <textarea name="direccion" id="direccion" class="form-control"><?= htmlspecialchars($candidato->direccion ?? '') ?></textarea>
                    </div>
                    <div class="col-12">
                        <label for="formacion">Formación Académica</label>
                        <textarea name="formacion" id="formacion" class="form-control"><?= htmlspecialchars($candidato->formacion_academica ?? '') ?></textarea>
                    </div>
                    <div class="col-12">
                        <label for="experiencia">Experiencia Laboral</label>
                        <textarea name="experiencia" id="experiencia" class="form-control"><?= htmlspecialchars($candidato->experiencia_laboral ?? '') ?></textarea>
                    </div>
                    <div class="col-12">
                        <label for="habilidades">Habilidades Clave</label>
                        <textarea name="habilidades" id="habilidades" class="form-control"><?= htmlspecialchars($candidato->habilidades_clave ?? '') ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="idiomas">Idiomas</label>
                        <input type="text" name="idiomas" id="idiomas" class="form-control" value="<?= htmlspecialchars($candidato->idiomas ?? '') ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="disponibilidad">Disponibilidad</label>
                        <input type="text" name="disponibilidad" id="disponibilidad" class="form-control" value="<?= htmlspecialchars($candidato->disponibilidad ?? '') ?>">
                    </div>
                    <div class="col-12">
                        <label for="objetivo">Objetivo Profesional</label>
                        <textarea name="objetivo" id="objetivo" class="form-control"><?= htmlspecialchars($candidato->objetivo_profesional ?? '') ?></textarea>
                    </div>
                    <div class="col-12">
                        <label for="logros">Logros o Proyectos</label>
                        <textarea name="logros" id="logros" class="form-control"><?= htmlspecialchars($candidato->logros_proyectos ?? '') ?></textarea>
                    </div>
                    <div class="col-12">
                        <label for="redes">Redes Profesionales (LinkedIn, etc.)</label>
                        <input type="text" name="redes" id="redes" class="form-control" value="<?= htmlspecialchars($candidato->redes_profesionales ?? '') ?>">
                    </div>
                    <div class="col-12">
                        <label for="referencias">Referencias (Opcional)</label>
                        <textarea name="referencias" id="referencias" class="form-control"><?= htmlspecialchars($candidato->referencias ?? '') ?></textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="foto">Foto de Perfil</label>
                        <?php if (!empty($candidato->foto)): ?>
                            <img src="../uploads/<?= $candidato->foto ?>" alt="Foto actual" class="img-fluid rounded mb-2" style="max-height:100px;" id="previewActualFoto">
                        <?php endif; ?>
                        <input type="file" name="foto" id="foto" accept="image/*" class="form-control">
                        <img id="previewFoto" class="img-fluid rounded mt-2" style="max-height:100px; display:none;">
                    </div>

                    <div class="col-md-6">
                        <label for="cv_pdf">Currículum en PDF</label>
                        <?php if (!empty($candidato->cv_pdf)): ?>
                            <a href="../uploads/<?= $candidato->cv_pdf ?>" target="_blank">Ver CV actual</a>
                        <?php endif; ?>
                        <input type="file" name="cv_pdf" id="cv_pdf" accept="application/pdf" class="form-control">
                        <iframe id="previewPdf" class="mt-2" style="width:100%; height:200px; display:none;" frameborder="0"></iframe>
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Guardar Currículum</button>
                </div>
            </form>
        </div>
    </div>

    <footer class="bg-light py-3 mt-5 text-center text-muted">
        <p>&copy; 2025 TuPlataformaDeEmpleos</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('foto').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('previewFoto');
            const actual = document.getElementById('previewActualFoto');
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    if (actual) actual.style.display = 'none';
                }
                reader.readAsDataURL(file);
            }
        });

        document.getElementById('cv_pdf').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('previewPdf');
            if (file && file.type === 'application/pdf') {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });
    </script>

</body>
</html>





<!-- <php
session_start();
require_once("../Libreria/conexion.php");

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'candidato') {
    header("Location: ../login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$msg = "";

// Verificamos si el currículum ya existe
$candidato = conexion::consulta("SELECT * FROM candidatos WHERE usuario_id = ?", [$usuario_id]);
$candidato = $candidato ? $candidato[0] : null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $formacion = $_POST['formacion'];
    $experiencia = $_POST['experiencia'];
    $habilidades = $_POST['habilidades'];
    $idiomas = $_POST['idiomas'];
    $objetivo = $_POST['objetivo'];
    $logros = $_POST['logros'];
    $disponibilidad = $_POST['disponibilidad'];
    $redes = $_POST['redes'];
    $referencias = $_POST['referencias'];

    // Subidas de archivos
    $foto = $_FILES['foto']['name'] ? uniqid() . "_" . $_FILES['foto']['name'] : ($candidato->foto ?? null);
    $cv_pdf = $_FILES['cv_pdf']['name'] ? uniqid() . "_" . $_FILES['cv_pdf']['name'] : ($candidato->cv_pdf ?? null);

    if ($_FILES['foto']['tmp_name']) move_uploaded_file($_FILES['foto']['tmp_name'], "../uploads/" . $foto);
    if ($_FILES['cv_pdf']['tmp_name']) move_uploaded_file($_FILES['cv_pdf']['tmp_name'], "../uploads/" . $cv_pdf);

    if ($candidato) {
        // Actualizamos si ya existe
        conexion::exec("UPDATE candidatos SET
            nombre = ?, apellido = ?, telefono = ?, direccion = ?, ciudad_provincia = ?, formacion_academica = ?,
            experiencia_laboral = ?, habilidades_clave = ?, idiomas = ?, objetivo_profesional = ?, logros_proyectos = ?,
            disponibilidad = ?, redes_profesionales = ?, referencias = ?, foto = ?, cv_pdf = ?
            WHERE usuario_id = ?", [
            $nombre, $apellido, $telefono, $direccion, $ciudad, $formacion, $experiencia,
            $habilidades, $idiomas, $objetivo, $logros, $disponibilidad, $redes, $referencias, $foto, $cv_pdf, $usuario_id
        ]);
    } else {
        // Insertamos si no existe
        conexion::insertar("INSERT INTO candidatos (
            usuario_id, nombre, apellido, telefono, direccion, ciudad_provincia, formacion_academica, 
            experiencia_laboral, habilidades_clave, idiomas, objetivo_profesional, logros_proyectos, 
            disponibilidad, redes_profesionales, referencias, foto, cv_pdf
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [
            $usuario_id, $nombre, $apellido, $telefono, $direccion, $ciudad, $formacion, $experiencia,
            $habilidades, $idiomas, $objetivo, $logros, $disponibilidad, $redes, $referencias, $foto, $cv_pdf
        ]);
    }

    header("Location: dashboard_candidato.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de CV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 900px;
            margin: auto;
            padding: 2rem;
            background: #f9f9f9;
            border-radius: 1rem;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-light">

<!-- Barra de Navegación -->
<!-- <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Plataforma de Empleos</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link active" href="dashboard_candidato.php">Inicio</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="../logout.php">Cerrar Sesión</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-5">
    <div class="form-container">
        <h2 class="mb-4"><?= $candidato ? 'Actualizar' : 'Registrar' ?> Currículum</h2>
        <form method="post" enctype="multipart/form-data">
            <div class="row g-3">
                <div class="col-md-6"><label>Nombre</label><input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($candidato->nombre ?? '') ?>" required></div>
                <div class="col-md-6"><label>Apellido</label><input type="text" name="apellido" class="form-control" value="<?= htmlspecialchars($candidato->apellido ?? '') ?>" required></div>
                <div class="col-md-6"><label>Teléfono</label><input type="text" name="telefono" class="form-control" value="<?= htmlspecialchars($candidato->telefono ?? '') ?>"></div>
                <div class="col-md-6"><label>Ciudad / Provincia</label><input type="text" name="ciudad" class="form-control" value="<?= htmlspecialchars($candidato->ciudad_provincia ?? '') ?>"></div>
                <div class="col-12"><label>Dirección</label><textarea name="direccion" class="form-control"><?= htmlspecialchars($candidato->direccion ?? '') ?></textarea></div>
                <div class="col-12"><label>Formación Académica</label><textarea name="formacion" class="form-control"><?= htmlspecialchars($candidato->formacion_academica ?? '') ?></textarea></div>
                <div class="col-12"><label>Experiencia Laboral</label><textarea name="experiencia" class="form-control"><?= htmlspecialchars($candidato->experiencia_laboral ?? '') ?></textarea></div>
                <div class="col-12"><label>Habilidades Clave</label><textarea name="habilidades" class="form-control"><?= htmlspecialchars($candidato->habilidades_clave ?? '') ?></textarea></div>
                <div class="col-md-6"><label>Idiomas</label><input type="text" name="idiomas" class="form-control" value="<?= htmlspecialchars($candidato->idiomas ?? '') ?>"></div>
                <div class="col-md-6"><label>Disponibilidad</label><input type="text" name="disponibilidad" class="form-control" value="<?= htmlspecialchars($candidato->disponibilidad ?? '') ?>"></div>
                <div class="col-12"><label>Objetivo Profesional</label><textarea name="objetivo" class="form-control"><?= htmlspecialchars($candidato->objetivo_profesional ?? '') ?></textarea></div>
                <div class="col-12"><label>Logros o Proyectos</label><textarea name="logros" class="form-control"><?= htmlspecialchars($candidato->logros_proyectos ?? '') ?></textarea></div>
                <div class="col-12"><label>Redes Profesionales</label><input type="text" name="redes" class="form-control" value="<?= htmlspecialchars($candidato->redes_profesionales ?? '') ?>"></div>
                <div class="col-12"><label>Referencias</label><textarea name="referencias" class="form-control"><?= htmlspecialchars($candidato->referencias ?? '') ?></textarea></div>
               

                <div class="col-md-6">
                    <label>Foto</label>
                    <?php if (!empty($candidato->foto)): ?>
                        <img src="../uploads/<?= $candidato->foto ?>" alt="Foto actual" class="img-fluid rounded mb-2" style="max-height:100px;" id="previewActualFoto"><br>
                    <?php endif; ?>
                    <input type="file" name="foto" id="foto" accept="image/*" class="form-control">
                    <img id="previewFoto" class="img-fluid rounded mt-2" style="max-height:100px; display:none;">
                </div>

                <div class="col-md-6">
                    <label>CV en PDF</label>
                    <?php if (!empty($candidato->cv_pdf)): ?>
                        <a href="../uploads/<?= $candidato->cv_pdf ?>" target="_blank">Ver CV actual</a><br>
                    <?php endif; ?>
                    <input type="file" name="cv_pdf" id="cv_pdf" accept="application/pdf" class="form-control">
                    <iframe id="previewPdf" class="mt-2" style="width:100%; height:200px; display:none;" frameborder="0"></iframe>
                </div>

            </div>
            <div class="mt-4 text-end">
                <button type="submit" class="btn btn-success">Guardar CV</button>
            </div>
        </form>
    </div>
</div>


<script>
    document.getElementById('foto').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('previewFoto');
        const actual = document.getElementById('previewActualFoto');
        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                if (actual) actual.style.display = 'none';
            }
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('cv_pdf').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('previewPdf');
        if (file && file.type === 'application/pdf') {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
</script>

</body>
</html> --> -->
