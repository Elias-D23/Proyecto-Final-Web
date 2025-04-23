<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuentra Tu Próximo Empleo | TuPlataformaDeEmpleos</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f7f5; /* Fondo beige claro */
            color: #333;
            line-height: 1.7;
        }

        .hero {
            background-color: #f8f7f5;
            padding: 80px 20px;
            text-align: left;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .hero-left {
            flex: 1;
            padding-right: 40px;
        }

        .hero-title {
            font-size: 2.8em;
            color: #222;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .hero-description {
            font-size: 1.1em;
            color: #555;
            margin-bottom: 30px;
        }

        .hero-button {
            display: inline-block;
            background-color: #222; /* Botón oscuro */
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .hero-button:hover {
            background-color: #555;
        }

        .hero-right {
            flex: 1;
            text-align: right;
        }

        .hero-image {
            max-width: 80%;
            height: auto;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0.5, 0.4, 0.4, 0.5);
            margin-right: 30px;
        }

        .features {
            padding: 60px 20px;
            background-color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .features-title {
            font-size: 2em;
            color: #222;
            margin-bottom: 40px;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            padding: 0 20px;
        }

        .feature-card {
            padding: 30px;
            border-radius: 8px;
            background-color: #f8f7f5;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
        }

        .feature-icon {
            font-size: 2.5em;
            color: #007bff; /* Un azul de énfasis */
            margin-bottom: 15px;
        }

        .feature-title {
            font-size: 1.3em;
            color: #333;
            margin-bottom: 10px;
        }

        .feature-description {
            color: #666;
        }

        .call-to-action {
            background-color: #f8f7f5;
            padding: 80px 20px;
            text-align: center;
        }

        .cta-title {
            font-size: 2.4em;
            color: #222;
            margin-bottom: 30px;
        }

        .cta-button {
            display: inline-block;
            background-color: #007bff; /* Azul de acción */
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .cta-button:hover {
            background-color: #0056b3;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 30px;
            margin-top: 60px;
        }

        /* Estilos adicionales para la navegación (si la incluyes) */
        nav {
            background-color: white;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav .logo {
            font-size: 1.5em;
            font-weight: bold;
            color: #222;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }

        nav ul li {
            margin-left: 20px;
        }

        nav ul li a {
            text-decoration: none;
            color: #555;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        nav ul li a:hover {
            color: #007bff;
        }

        /* Media queries para hacerlo más adaptable */
        @media (max-width: 768px) {
            .hero {
                flex-direction: column;
                text-align: center;
            }

            .hero-left {
                padding-right: 0;
                margin-bottom: 40px;
            }

            .hero-right {
                text-align: center;
            }

            .feature-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

    <nav>
        <div class="logo">~ Workly ~</div>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href=""></a></li>
            <li><a href=""></a></li>
        </ul>
    </nav>

    <div class="hero">
        <div class="hero-left" style="margin-left: 50px;">
            <h1 class="hero-title">Encuentra el Trabajo que Impulsa tu Futuro</h1>
            <p class="hero-description">Descubre un mundo de oportunidades laborales diseñadas para tu talento. En TuPlataformaDeEmpleos, conectamos a profesionales ambiciosos con las mejores empresas de República Dominicana y más allá. Explora ofertas personalizadas, carga tu currículum y da el siguiente gran paso en tu carrera.</p>
            <a href="registro.php" class="hero-button">Regisrate y Comienza tu Búsqueda Ahora</a>
        </div>
        <div class="hero-right">
            <img src="uploads/Logo.jpeg" alt="Imagen de Empleo" class="hero-image">
        </div>
    </div>

    <div class="features">
        <h2 class="features-title">¿Por qué elegir Workly?</h2>
        <div class="feature-grid">
            <div class="feature-card">
                <i class="fas fa-search feature-icon"></i>
                <h3 class="feature-title">Búsqueda Inteligente y Filtrada</h3>
                <p class="feature-description">Nuestra avanzada herramienta de búsqueda te permite filtrar empleos por ubicación, industria, salario, tipo de contrato y más, asegurando que encuentres las opciones más relevantes para ti.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-briefcase feature-icon"></i>
                <h3 class="feature-title">Miles de Oportunidades Actualizadas</h3>
                <p class="feature-description">Accede a una base de datos en constante crecimiento con ofertas de empleo de empresas líderes en diversos sectores. Nuevas oportunidades se publican diariamente.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-user-tie feature-icon"></i>
                <h3 class="feature-title">Perfil Profesional Destacado</h3>
                <p class="feature-description">Crea un perfil profesional completo y atractivo que destaque tus habilidades y experiencia, permitiendo que las empresas adecuadas te encuentren fácilmente.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-bell feature-icon"></i>
                <h3 class="feature-title">Alertas de Empleo Personalizadas</h3>
                <p class="feature-description">Configura alertas por correo electrónico para recibir notificaciones instantáneas sobre los nuevos empleos que coinciden con tus criterios de búsqueda.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-building feature-icon"></i>
                <h3 class="feature-title">Información Detallada de Empresas</h3>
                <p class="feature-description">Conoce más sobre las empresas que te interesan, su cultura, valores y oportunidades de crecimiento antes de postularte.</p>
            </div>
            <div class="feature-card">
                <i class="fas fa-chart-line feature-icon"></i>
                <h3 class="feature-title">Herramientas para el Desarrollo de Carrera</h3>
                <p class="feature-description">Accede a recursos y consejos para mejorar tu currículum, prepararte para entrevistas y avanzar en tu trayectoria profesional.</p>
            </div>
        </div>
    </div>

    <div class="call-to-action">
        <h2 class="cta-title">¿Listo para Encontrar tu Próximo Gran Empleo?</h2>
        <p class="cta-description">Únete a nuestra comunidad de profesionales y empresas líderes. ¡Tu futuro te espera!</p>
        <a href="registro.php" class="cta-button">Regístrate Gratis</a>
    </div>

    <footer>
        <p>&copy; 2025 Workly - Encontrando Talento en República Dominicana y más allá.</p>
    </footer>

</body>
</html>
