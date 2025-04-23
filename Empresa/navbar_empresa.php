
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="dashboard_empresa.php">Plataforma Empleos</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarEmpresa">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarEmpresa">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="dashboard_empresa.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link active" href="publicar_oferta.php">Publicar Oferta</a></li>
                <li class="nav-item"><a class="nav-link" href="ver_candidatos.php">Ver Candidatos</a></li>
            </ul>
            <form method="POST" action="../logout.php">
                <button class="btn btn-outline-light" type="submit">Cerrar Sesión</button>
            </form>
        </div>
    </div>
</nav>
