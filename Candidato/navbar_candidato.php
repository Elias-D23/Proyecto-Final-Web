<?php
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

?>

<style>
          .profile-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            cursor: pointer;
        }
        .dropdown-menu-end {
            right: 0;
            left: auto;
        }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard_candidato.php">~ Workly ~</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" href="dashboard_candidato.php">Mi Panel</a></li>
                    <!-- <li class="nav-item"><a class="nav-link" href="registro_cv.php">Mi CV</a></li> -->
                    <li class="nav-item"><a class="nav-link" href="ver_ofertas.php">Ver Ofertas</a></li>
                    <!-- <li class="nav-item"><a class="nav-link text-danger" href="../logout.php">Cerrar Sesión</a></li> -->
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle p-0" href="#" role="button" id="dropdownPerfil" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="../uploads/<?= htmlspecialchars($foto); ?>" alt="Perfil" class="profile-img">
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownPerfil">
                            <li><a class="dropdown-item" href="perfil_candidato.php">Mi Perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="../logout.php">Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>