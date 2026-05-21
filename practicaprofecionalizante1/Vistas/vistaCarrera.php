<?php
include_once __DIR__.'/../DataBase.php';
include_once __DIR__.'/../Clases/Carrera.php';

$carreras = Carrera::obtenerCarrera($bd);

if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    if(isset($_POST['eliminar'])){
        $id_carrera = $_POST['eliminar']; 
        Carrera::eliminarCarrera($bd, $id_carrera);
    }

    if(isset($_POST['editar_guardar'])){
        $id_carrera = $_POST['id_carrera'];
        $nuevo_nombre = $_POST['nuevo_nombre'];
        Carrera::editarCarrera($bd, $id_carrera, $nuevo_nombre);
    }

    if(isset($_POST['crear_guardar'])){
        $carrera = new Carrera($_POST['nueva_carrera']); 
        $carrera->subirCarrera($bd);
    }
       header("Location: vistaCarrera.php");
    exit;
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carreras</title>
    <link rel="stylesheet" href="../CSS/carrera.css">
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
            <h1>Carreras</h1>
            <div id="contenido">
                <div class="contenedor-acciones">
                    <div class="acciones">
                        <div class="accion-box">
                            <button type="button" class="crear" onclick="abrirVentanaCrear()">Agregar Carrera</button>
                        </div>
                    </div>
                </div>
        
                <table>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th colspan="2">Acciones</th>
                    </tr>
                    <?php
                        if($carreras){
                            foreach($carreras as $carrera){
                                echo '<form id="carrera" action="vistaCarrera.php" method="post">
                                        <tr>
                                            <td>'.$carrera["id_carrera"].'</td>
                                            <td>'.$carrera["nombre"].'</td>
                                            <td>
                                                <button name="eliminar" type="submit" value="'.$carrera["id_carrera"].'" class="eliminar">Eliminar</button>
                                            </td>
                                            <td>
                                                <button type="button" 
                                                    data-id="'.$carrera["id_carrera"].'" 
                                                    data-nombre="'.$carrera["nombre"].'" 
                                                    class="editar" 
                                                    onclick="abrirVentana(this)">Editar
                                                </button>
                                            </td>
                                        </tr>
                                    </form>';
                            }
                        } else {
                            echo '<tr><td colspan="4"><p>No hay carreras registradas</p></td></tr>';
                        }
                    ?>
                </table>
            </div>
        </div>
        <div id="ventanaEditar" class="ventana">
            <div class="ventana_contenido">
                <h2>Editar Carrera</h2>
                <form method="post" action="vistaCarrera.php">
                    <input type="hidden" name="id_carrera" id="id_carrera">
                    <input type="text" name="nuevo_nombre" id="nuevo_nombre" placeholder="Nuevo nombre">
                    <button type="submit" name="editar_guardar">Guardar</button>
                    <button type="button" name="cancelar"  onclick="cerrarVentana()">Cancelar</button>
                </form>
            </div>
        </div>

        <div id="ventanaCrear" class="ventana">
            <div class="ventana_contenido">
                <h2>Crear Carrera</h2>
                <form method="post" action="vistaCarrera.php">
                    <input type="text" name="nueva_carrera" id="nueva_carrera" placeholder="Nueva carrera">
                    <button type="submit" name="crear_guardar">Guardar</button>
                    <button type="button" name="cancelar"  onclick="cerrarVentanaCrear()">Cancelar</button>
                </form>
            </div>
        </div>
    </div>

    <script src="../JS/editarCarrera.js"></script>
</body>
</html>
