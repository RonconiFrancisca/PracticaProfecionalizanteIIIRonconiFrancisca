<?php 
include_once __DIR__.'/../DataBase.php';
include_once __DIR__.'/../Clases/Examen.php';
include_once __DIR__.'/../Clases/Alumno.php';
include_once __DIR__.'/../Clases/Materia.php';

$examen = Examen::obtenerExamenes($bd);
$alumno = Alumno::obtenerAlumno($bd);
$materia = Materia::obtenerMateria($bd);

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(isset($_POST['eliminar'])){
        $id_examen = $_POST['eliminar'];
        Examen::eliminarExamen($bd, $id_examen);
    }

    if(isset($_POST['editar_guardar'])){
        $id_examen = $_POST['id_examen'];
        $nota_nuevo = $_POST['nota_nuevo'];
        $fecha_nuevo = $_POST['fecha_nuevo'];
        $id_alumno_nuevo = $_POST['id_alumno_nuevo'];
        $id_materia_nuevo = $_POST['id_materia_nuevo'];

        Examen::editarExamen(
            $bd,
            $id_examen,
            $nota_nuevo,
            $fecha_nuevo,
            $id_alumno_nuevo,
            $id_materia_nuevo
        );
    }

    if(isset($_POST['crear_guardar'])){
        $nuevo_nota = $_POST['nuevo_nota'];
        $nuevo_fecha = $_POST['nuevo_fecha'];
        $nuevo_id_alumno = $_POST['nuevo_id_alumno'];
        $nuevo_id_materia = $_POST['nuevo_id_materia'];

        Examen::subirExamen(
            $bd,
            $nuevo_nota,
            $nuevo_fecha,
            $nuevo_id_alumno,
            $nuevo_id_materia
        );
    }

    header("Location: vistaExamen.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exámenes</title>
    <link rel="stylesheet" href="../css/examen.css">
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
        <h1>Exámenes</h1>
        <div class="contenedor-acciones">
            <button type="button"
                    class="crear"
                    onclick="abrirVentanaCrear()">
                    Agregar Examen
            </button>
        </div>
        <table>
            <tr>
                <th>Id</th>
                <th>Nota</th>
                <th>Fecha</th>
                <th>Alumno</th>
                <th>Materia</th>
                <th colspan="2">Acciones</th>
            </tr>
            <?php
            if($examen){
                foreach($examen as $e){
                    echo '<tr>';
                    echo '<td>'.$e["id_examen"].'</td>';
                    echo '<td>'.$e["nota"].'</td>';
                    echo '<td>'.$e["fecha"].'</td>';
                    echo '<td>'.$e["nombre_alumno"].'</td>';
                    echo '<td>'.$e["nombre_materia"].'</td>';
                    echo '
                    <td>
                        <form method="POST" action="vistaExamen.php">

                            <button type="submit"
                                    name="eliminar"
                                    value="'.$e["id_examen"].'"
                                    class="eliminar">
                                    Eliminar
                            </button>

                        </form>
                    </td>';
                    echo '
                    <td>
                        <button type="button"
                                class="editar"
                                data-id="'.$e["id_examen"].'"
                                data-nota="'.$e["nota"].'"
                                data-fecha="'.$e["fecha"].'"
                                data-id-alumno="'.$e["id_alumno"].'"
                                data-id-materia="'.$e["id_materia"].'"
                                onclick="abrirVentana(this)">
                                Editar
                        </button>
                    </td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="7">No hay exámenes registrados</td></tr>';
            }
            ?>
        </table>
    </div>
</div>

<div id="ventanaEditar" class="ventana">
    <div class="ventana_contenido">
        <h2>Editar Examen</h2>
        <form method="POST" action="vistaExamen.php">
            <input type="hidden" name="id_examen" id="id_examen">
            <input type="number" name="nota_nuevo" id="nota_nuevo" placeholder="Nota" required>
            <input type="date" name="fecha_nuevo"  id="fecha_nuevo" required>
            <select name="id_alumno_nuevo" id="id_alumno_nuevo" required>
                <option value="">Seleccione Alumno</option>

                <?php
                foreach($alumno as $a){
                    echo '<option value="'.$a['id_alumno'].'"> '.$a['nombre'].' </option>';
                }
                ?>
            </select>
            <select name="id_materia_nuevo" id="id_materia_nuevo"  required>
                <option value="">Seleccione Materia</option>
                <?php
                foreach($materia as $m){
                    echo '<option value="'.$m['id_materia'].'">'.$m['nombre'].' </option>';
                }
                ?>

            </select>
            <div class="contenedor-botones">
                <button type="submit" name="editar_guardar" class="guardar"> Guardar</button>
                <button type="button"  class="cancelar"  onclick="cerrarVentana()">Cancelar </button>
            </div>
        </form>
    </div>
</div>

<div id="ventanaCrear" class="ventana">
    <div class="ventana_contenido">
        <h2>Crear Examen</h2>
        <form method="POST" action="vistaExamen.php">
            <input type="number"  name="nuevo_nota" placeholder="Nota" required>
            <input type="date" name="nuevo_fecha" required>
            <select name="nuevo_id_alumno" required>
                <option value="">Seleccione Alumno</option>
                <?php
                foreach($alumno as $a){
                    echo '<option value="'.$a['id_alumno'].'"> '.$a['nombre'].'  </option>';
                }
                ?>
            </select>

            <select name="nuevo_id_materia" required>
                <option value="">Seleccione Materia</option>
                <?php
                foreach($materia as $m){
                    echo '<option value="'.$m['id_materia'].'"> '.$m['nombre'].' </option>';
                }
                ?>
            </select>
            <div class="contenedor-botones">
                <button type="submit" name="crear_guardar" class="guardar"> Guardar</button>
                <button type="button" class="cancelar" onclick="cerrarVentanaCrear()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script src="../JS/editarExamen.js"></script>

</body>
</html>