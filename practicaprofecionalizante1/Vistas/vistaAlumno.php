<?php 
include_once __DIR__.'/../DataBase.php';
include_once __DIR__.'/../Clases/Alumno.php';
include_once __DIR__.'/../Clases/Carrera.php';

$alumno = Alumno::obtenerAlumno($bd);
$carrera = Carrera::obtenerCarrera($bd);

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(isset($_POST['eliminar'])){
        $id_alumno = $_POST['eliminar'];
        Alumno::eliminarAlumno($bd, $id_alumno);
    }

    if(isset($_POST['editar_guardar'])){
        $id_alumno = $_POST['id_alumno'];
        $nombre_nuevo = $_POST['nombre_nuevo'];
        $email_nuevo = $_POST['email_nuevo'];
        $fecha_nacimiento_nuevo = $_POST['fecha_nacimiento_nuevo'];
        $id_carrera_nuevo = $_POST['id_carrera_nuevo'];

        Alumno::editarAlumno($bd, $id_alumno, $nombre_nuevo, $email_nuevo, $fecha_nacimiento_nuevo, $id_carrera_nuevo);
    }

    if(isset($_POST['crear_guardar'])){
        $nuevo_nombre = $_POST['nuevo_nombre'];
        $nuevo_email = $_POST['nuevo_email'];
        $nuevo_dni = $_POST['nuevo_dni'];
        $nueva_fecha_nacimiento = $_POST['nueva_fecha_nacimiento'];
        $nuevo_id_carrera = $_POST['nuevo_id_carrera'];

        Alumno::subirAlumno($bd, $nuevo_nombre, $nuevo_email, $nuevo_dni, $nueva_fecha_nacimiento, $nuevo_id_carrera);
    }
    header("Location: vistaAlumno.php");
    exit;
}

?> 

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos</title>
    <link rel="stylesheet" href="../CSS/alumno.css">
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

        <h1>Alumnos</h1>

        <div id="contenido">

            <div class="contenedor-acciones">
                <div class="acciones">
                    <div class="accion-box">
                        <button type="button" class="crear" onclick="abrirVentanaCrear()">Agregar Alumno</button>
                    </div>
                </div>
            </div>

            <table>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>DNI</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Carrera</th>
                    <th colspan="2">Acciones</th>
                </tr>

                <?php 
                if ($alumno) {
                    foreach($alumno as $a) {
                        echo '<tr>';
                        echo '<td>' . $a["id_alumno"] . '</td>';
                        echo '<td>' . $a["nombre"] . '</td>';
                        echo '<td>' . $a["email"] . '</td>';
                        echo '<td>' . $a["dni"] . '</td>';
                        echo '<td>' . $a["fecha_nacimiento"] . '</td>';
                        echo '<td>' . $a["id_carrera"] . '</td>';

                        echo '<td>
                                <form method="post" action="vistaAlumno.php" style="display:inline;">
                                    <button name="eliminar" type="submit" value="' . $a["id_alumno"] . '" class="eliminar">
                                        Eliminar
                                    </button>
                                </form>
                              </td>';

                        echo '<td>
                                <button type="button"
                                    data-id="' . $a["id_alumno"] . '"
                                    data-nombre="' . $a["nombre"] . '"
                                    data-email="' . $a["email"] . '"
                                    data-fecha-nacimiento="' . $a["fecha_nacimiento"] . '"
                                    data-id-carrera="' . $a["id_carrera"] . '""
                                    class="editar"
                                    onclick="abrirVentana(this)">
                                    Editar
                                </button>
                              </td>';

                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="7"><p>No hay alumnos registrados</p></td></tr>';
                }
                ?>
            </table>
        </div>
    </div>

    <div id="ventanaEditar" class="ventana">
        <div class="ventana_contenido">
            <h2>Editar Alumno</h2>
            <form method="post" action="vistaAlumno.php">
                <input type="hidden" name="id_alumno" id="id_alumno">
                <input type="text" name="nombre_nuevo" id="nombre_nuevo" placeholder="Nombre" required>
                <input type="text" name="email_nuevo" id="email_nuevo" placeholder="Email" required>
                <input type="date" name="fecha_nacimiento_nueva" id="fecha_nacimiento_nueva" placeholder="Fecha de Nacimiento" required>
                
                <select name="carrera_nueva" id="carrera_nueva" required>
                    <option value="">Seleccione Carrera</option>
                    <?php foreach($carrera as $c){ echo '<option value="'.$c['id_carrera'].'">'.$c['nombre'].'</option>'; } ?>
                </select>

                <button type="submit" name="editar_guardar">Guardar</button>
                <button type="button" onclick="cerrarVentana()">Cancelar</button>
            </form>
        </div>
    </div>

    <div id="ventanaCrear" class="ventana">
        <div class="ventana_contenido">
            <h2>Crear Alumno</h2>
            <form method="post" action="vistaAlumno.php">
                <input type="text" name="nuevo_nombre" placeholder="Nombre" required>
                <input type="text" name="nuevo_email" placeholder="Email" required>
                <input type="number" name="nuevo_dni" placeholder="DNI" required>
                <input type="date" name="nueva_fecha_nacimiento" placeholder="Fecha de Nacimiento" required>
            
                <select name="carrera_nueva" id="carrera_nueva" required>
                    <option value="">Seleccione Carrera</option>
                    <?php foreach($carrera as $c){ echo '<option value="'.$c['id_carrera'].'">'.$c['nombre'].'</option>'; } ?>
                </select>


                <button type="submit" name="crear_guardar">Guardar</button>
                <button type="button" onclick="cerrarVentanaCrear()">Cancelar</button>
            </form>
        </div>
    </div>

</div>

<script src="../JS/editarAlumno.js"></script>
</body>
</html>
