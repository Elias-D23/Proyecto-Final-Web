# Plataforma de Empleos - Proyecto Final

## Descripción
“TuPlataformaDeEmpleos” es una aplicación web desarrollada en PHP y MySQL que conecta **candidatos** con **empresas**.  
- **Candidatos** pueden registrarse, crear y editar un CV digital (con foto y PDF), explorar ofertas y postularse.  
- **Empresas** pueden registrarse, completar su perfil, publicar, editar y eliminar ofertas, y revisar postulantes.

## Contenido
- `/Libreria/conexion.php` — Clase `conexion` con métodos estáticos para CRUD en base de datos.  
- `/Candidato/`  
  - `registro_cv.php` — Crear/editar CV digital.  
  - `dashboard_candidato.php` — Panel con saludo y postulaciones recientes.  
  - `ver_ofertas.php` — Listado de ofertas y botones de postulación/cancelación.  
  - `perfil_candidato.php` — Vista de perfil completo y enlaces a editar.  
- `/Empresa/`  
  - `registro_empresa.php` — Completar perfil de empresa.  
  - `dashboard_empresa.php` — Panel con navegación y bienvenida.  
  - `publicar_oferta.php` — Crear, editar, eliminar ofertas con tarjetas.  
  - `ver_candidatos.php` — Listado de ofertas con contador de postulantes.  
  - `ver_postulados.php` — Tarjetas con datos de cada candidato postulante.  
- `/uploads/` — Carpeta pública para almacenar fotos y PDFs.  
- `login.php`, `registro.php`, `logout.php` — Autenticación y gestión de sesiones.

## Cómo funciona
1. **Registro**  
   - Usuarios eligen rol: “candidato” o “empresa”.  
2. **Login**  
   - Redirige empresas a completar perfil y candidatos a crear CV si aún no lo tienen.  
3. **Candidato**  
   - Rellena CV con 15+ campos, foto y PDF.  
   - Explora ofertas y postula/cancela postulación.  
   - Dashboard muestra postulaciones recientes y perfil editable.  
4. **Empresa**  
   - Completa perfil de empresa.  
   - Publica ofertas, las administra en tarjetas con collapse.  
   - Ve detalle de candidatos, su correo, foto, CV y envía mailto:.

## Tecnologías
- **Backend:** PHP 7+ con PDO  
- **Base de datos:** MySQL 5+  
- **Frontend:** HTML5, CSS3, [Bootstrap 5](https://getbootstrap.com)  
- **Repositorio:** Git / GitHub  

## Instalación y puesta en marcha

1. Clonar repositorio:
   ```bash
   git clone https://github.com/<tu-usuario>/tu-plataforma-empleos.git
   cd tu-plataforma-empleos
