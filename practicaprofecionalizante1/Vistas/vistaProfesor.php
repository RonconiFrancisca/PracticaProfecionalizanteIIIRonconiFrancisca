<?php 
include_once __DIR__.'/../DataBase.php';
include_once __DIR__.'/../Clases/Profesor.php';

$profesor = Profesor::obtenerProfesor($bd);

if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(isset($_POST['eliminar'])){
        $id_profesor = $_POST['eliminar'];
        Profesor::eliminarProfesor($bd, $id_profesor);
    }

    if(isset($_POST['editar_guardar'])){
        $id_profesor = $_POST['id_profesor'];
        $nombre_nuevo = $_POST['nombre_nuevo'];
        $email_nuevo = $_POST['email_nuevo'];
        
        Profesor::editarProfesor($bd, $id_profesor, $nombre_nuevo, $email_nuevo);
    }

    if(isset($_POST['crear_guardar'])){
        $nuevo_nombre = $_POST['nuevo_nombre'];
        $nuevo_email = $_POST['nuevo_email'];

        Profesor::subirProfesor($bd, $nuevo_nombre, $nuevo_email);
    }
    header("Location: vistaProfesor.php");
    exit;
}

?> 

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profesores</title>
    <link rel="stylesheet" href="../CSS/profesor.css">
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

        <h1>Profesores</h1>

        <div id="contenido">

            <div class="contenedor-acciones">
                <div class="acciones">
                    <div class="accion-box">
                        <button type="button" class="crear" onclick="abrirVentanaCrear()">Agregar Profesor</button>
                    </div>
                </div>
            </div>

            <table>
                <tr>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    
                    <th colspan="2">Acciones</th>
                </tr>

                <?php 
                if ($profesor) {
                    foreach($profesor as $p) {
                        echo '<tr>';
                        echo '<td>' . $p["id_profesor"] . '</td>';
                        echo '<td>' . $p["nombre"] . '</td>';
                        echo '<td>' . $p["email"] . '</td>';
                        

                        echo '<td>
                                <form method="post" action="vistaProfesor.php" style="display:inline;">
                                    <button name="eliminar" type="submit" value="' . $p["id_profesor"] . '" class="eliminar">
                                        Eliminar
                                    </button>
                                </form>
                              </td>';

                        echo '<td>
                                <button type="button"
                                    data-id="' . $p["id_profesor"] . '"
                                    data-nombre="' . $p["nombre"] . '"
                                    data-email="' . $p["email"] . '"
                                    class="editar"
                                    onclick="abrirVentana(this)">
                                    Editar
                                </button>
                              </td>';

                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="7"><p>No hay profesores registrados</p></td></tr>';
                }
                ?>
            </table>
        </div>
    </div>

    <div id="ventanaEditar" class="ventana">
        <div class="ventana_contenido">
            <h2>Editar Profesor</h2>
            <form method="post" action="vistaProfesor.php">
                <input type="hidden" name="id_profesor" id="id_profesor">
                <input type="text" name="nombre_nuevo" id="nombre_nuevo" placeholder="Nombre" required>
                <input type="text" name="email_nuevo" id="email_nuevo" placeholder="Email" required>
                
                <button type="submit" name="editar_guardar">Guardar</button>
                <button type="button" onclick="cerrarVentana()">Cancelar</button>
            </form>
        </div>
    </div>

    <div id="ventanaCrear" class="ventana">
        <div class="ventana_contenido">
            <h2>Crear Profesor</h2>
            <form method="post" action="vistaProfesor.php">
                <input type="text" name="nuevo_nombre" placeholder="Nombre" required>
                <input type="text" name="nuevo_email" placeholder="Email" required>
            

                <button type="submit" name="crear_guardar">Guardar</button>
                <button type="button" onclick="cerrarVentanaCrear()">Cancelar</button>
            </form>
        </div>
    </div>

</div>

<script src="../JS/editarProfesor.js"></script>
</body>
</html>
