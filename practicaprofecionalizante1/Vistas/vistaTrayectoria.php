<?php

include_once __DIR__.'/../DataBase.php';
include_once __DIR__.'/../Clases/Trayectoria.php';

$trayectoria = [];

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $id_alumno = $_POST['id_alumno'];

    $trayectoria = Trayectoria::obtenerTrayectoria($bd, $id_alumno);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trayectoria Académica</title>

    <link rel="stylesheet" href="../CSS/trayectoria.css">
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

    <h1>Trayectoria Académica</h1>

    <form method="POST" class="formulario-busqueda">

        <input 
            type="number" 
            name="id_alumno" 
            placeholder="Ingrese ID del alumno"
            required
        >

        <button type="submit">Buscar</button>

    </form>

    <table>

        <tr>
            <th>ID</th>
            <th>Alumno</th>
            <th>Materia</th>
            <th>Curso</th>
            <th>Nota</th>
            <th>Fecha</th>
        </tr>

        <?php

        if($trayectoria){

            foreach($trayectoria as $t){

                echo "<tr>";

                echo "<td>".$t['id_alumno']."</td>";
                echo "<td>".$t['alumno']."</td>";
                echo "<td>".$t['materia']."</td>";
                echo "<td>".$t['curso']."</td>";

                echo "<td>".($t['nota'] ?? '-')."</td>";

                echo "<td>".($t['fecha'] ?? '-')."</td>";

                echo "</tr>";
            }

        } else {

            echo "<tr>
                    <td colspan='6'>
                        No hay datos
                    </td>
                  </tr>";
        }

        ?>

    </table>

</div>

</body>
</html>