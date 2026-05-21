<?php 
include_once __DIR__.'/../DataBase.php';
include_once __DIR__.'/../Clases/Profesor.php';
include_once __DIR__.'/../Clases/Carrera.php';
include_once __DIR__.'/../Clases/Materia.php';

$materia = Materia::obtenerMateria($bd);
$profesor = Profesor::obtenerProfesor($bd);
$carrera = Carrera::obtenerCarrera($bd);

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(isset($_POST['eliminar'])){
        $id_materia = $_POST['eliminar'];
        Materia::eliminarMateria($bd, $id_materia);
    }

    if(isset($_POST['editar_guardar'])){
        $id_materia = $_POST['id_materia'];
        $nombre_nuevo = $_POST['nombre_nuevo'];
        $curso_nuevo = $_POST['curso_nuevo'];
        $id_carrera_nuevo = $_POST['id_carrera_nuevo'];
        $id_profesor_nuevo = $_POST['id_profesor_nuevo'];
        $nota_aprobacion_nuevo = $_POST['nota_aprobacion_nuevo'];
       

        Materia::editarMateria($bd, $id_materia, $nombre_nuevo, $curso_nuevo, $id_carrera_nuevo, $id_profesor_nuevo, $nota_aprobacion_nuevo);
    }

    if(isset($_POST['crear_guardar'])){
        $nuevo_nombre = $_POST['nuevo_nombre'];
        $nuevo_curso = $_POST['nuevo_curso'];
        $nuevo_id_carrera = $_POST['nuevo_id_carrera'];
        $nuevo_id_profesor = $_POST['nuevo_id_profesor'];
        $nuevo_nota_aprobacion = $_POST['nuevo_nota_aprobacion'];
        

        Materia::subirMateria($bd, $nuevo_nombre, $nuevo_curso,$nuevo_id_carrera, $nuevo_id_profesor,  $nuevo_nota_aprobacion);
    }
    header("Location: vistaMateria.php");
    exit;
}

?> 

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materias</title>
    <link rel="stylesheet" href="../CSS/materia.css">
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

        <h1>Materias</h1>

        <div id="contenido">

            <div class="contenedor-acciones">
                <div class="acciones">
                    <div class="accion-box">
                        <button type="button" class="crear" onclick="abrirVentanaCrear()">Agregar Materia</button>
                    </div>
                </div>
            </div>

            <table>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Curso</th>
                    <th>Carrera</th>
                    <th>Profesor</th>
                    <th>Nota de Aprobación</th>
                    <th colspan="2">Acciones</th>
                </tr>

                <?php 
                if ($materia) {
                    foreach($materia as $m) {
                        echo '<tr>';
                        echo '<td>' . $m["id_materia"] . '</td>';
                        echo '<td>' . $m["nombre"] . '</td>';
                        echo '<td>' . $m["curso"] . '</td>';
                        echo '<td>' . $m["nombre_carrera"] . '</td>';
                        echo '<td>' . $m["nombre_profesor"] . '</td>';
                        echo '<td>' . $m["nota_aprobacion"] . '</td>';

                        echo '<td>
                                <form method="post" action="vistaMateria.php" style="display:inline;">
                                    <button name="eliminar" type="submit" value="' . $m["id_materia"] . '" class="eliminar">
                                        Eliminar
                                    </button>
                                </form>
                              </td>';

                        echo '<td>
                                <button type="button"
                                    data-id="' . $m["id_materia"] . '"
                                    data-nombre="' . $m["nombre"] . '"
                                    data-curso="' . $m["curso"] . '"
                                    data-id-carrera="' . $m["id_carrera"] . '"
                                    data-id-profesor="' . $m["id_profesor"] . '"
                                    data-nota-aprobacion="' . $m["nota_aprobacion"] . '"
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
            <h2>Editar Materia</h2>
            <form method="post" action="vistaMateria.php">
                <input type="hidden" name="id_materia" id="id_materia">
                <input type="text" name="nombre_nuevo" id="nombre_nuevo" placeholder="Nombre" required>
                <input type="text" name="curso_nuevo" id="curso_nuevo" placeholder="Curso" required>
                <input type="number" step="0.01" name="nota_aprobacion_nueva" id="nota_aprobacion_nueva" placeholder="Nota de Aprobación" required>
                
                <select name="carrera_nueva" id="carrera_nueva" required>
                    <option value="">Seleccione Carrera</option>
                    <?php foreach($carrera as $c){ echo '<option value="'.$c['id_carrera'].'">'.$c['nombre'].'</option>'; } ?>
                </select>
                <select name="profesor_nuevo" id="profesor_nuevo" required>
                    <option value="">Seleccione Profesor</option>
                    <?php foreach($profesor as $p){ echo '<option value="'.$p['id_profesor'].'">'.$p['nombre'].'</option>'; } ?>
                </select>
                <input type="number" step="0.01" name="nota_aprobacion_nueva" id="nota_aprobacion_nueva" placeholder="Nota de Aprobación" required>

                <button type="submit" name="editar_guardar">Guardar</button>
                <button type="button" onclick="cerrarVentana()">Cancelar</button>
            </form>
        </div>
    </div>

    <div id="ventanaCrear" class="ventana">
        <div class="ventana_contenido">
            <h2>Crear Materia</h2>
            <form method="post" action="vistaMateria.php">
                <input type="text" name="nuevo_nombre" placeholder="Nombre" required>
                <input type="text" name="nuevo_curso" placeholder="Curso" required>
                
                <select name="carrera_nueva" id="carrera_nueva" required>
                    <option value="">Seleccione Carrera</option>
                    <?php foreach($carrera as $c){ echo '<option value="'.$c['id_carrera'].'">'.$c['nombre'].'</option>'; } ?>
                </select>
                <select name="profesor_nuevo" id="profesor_nuevo" required>
                    <option value="">Seleccione Profesor</option>
                    <?php foreach($profesor as $p){ echo '<option value="'.$p['id_profesor'].'">'.$p['nombre'].'</option>'; } ?>
                </select>
                <input type="number" step="0.01" name="nota_aprobacion_nueva" id="nota_aprobacion_nueva" placeholder="Nota de Aprobación" required>
                
                <button type="submit" name="crear_guardar">Guardar</button>
                <button type="button" onclick="cerrarVentanaCrear()">Cancelar</button>
            </form>
        </div>
    </div>

</div>

<script src="../JS/editarMateria.js"></script>
</body>
</html>
