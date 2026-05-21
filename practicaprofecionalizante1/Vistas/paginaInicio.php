<?php
session_start();
if (!isset($_SESSION["Usuarios"])) {
    header("Location: ../index.php");
    exit;
}
$usuario = $_SESSION["Usuarios"];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicio</title>
    <link rel="stylesheet" href="../css/inicio.css">

</head>
<body>
    <div class="contenedor-general">
        <nav class="barra-lateral">
            <h2>Menú</h2>
            <ul>
                <li><a href="../Vistas/paginaInicio.php">Inicio</a></li>
                <li><a href="../Vistas/vistaUsuario.php">Usuarios</a></li>
                <li><a href="../Vistas/vistaExamen.php">Exámenes</a></li>
                <li><a href="../Vistas/vistaCarrera.php">Carreras</a></li>
                <li><a href="../Vistas/vistaMateria.php">Materias</a></li>
                <li><a href="../Vistas/vistaProfesor.php">Profesores</a></li>
                <li><a href="../Vistas/vistaAlumno.php">Alumnos</a></li>
                <li><a href="../Vistas/vistaTrayectoria.php">Trayectoria Académica</a></li>
            </ul>
            <a href="../index.php" class="cerrar-btn">Cerrar sesión</a>
        </nav>
        <div class="contenido-principal">
            <h1>Bienvenido, <?= htmlspecialchars($usuario["nombre"] ?? '') ?>!</h1>
            <div id="contenido">
                <div class="contenedor-imagen">
                    <img class="imagen" src="../CSS/imagenes/en-stock.png" alt="">
                    <p>Aún no has seleccionado ningún elemento para ver</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>