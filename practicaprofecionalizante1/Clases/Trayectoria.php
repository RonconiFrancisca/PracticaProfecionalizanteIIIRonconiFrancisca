<?php

class Trayectoria {

    public static function obtenerTrayectoria($bd, $id_alumno){

      $sql = "SELECT 
            alumnos.id_alumno,
            alumnos.nombre AS alumno,
            materias.nombre AS materia,
            materias.curso,
            examenes.nota,
            examenes.fecha

        FROM alumnos 

        JOIN materias 
            ON alumnos.id_carrera = materias.id_carrera

        LEFT JOIN examenes 
            ON examenes.id_alumno = alumnos.id_alumno
            AND examenes.id_materia = materias.id_materia

        WHERE alumnos.id_alumno = :id_alumno

        ORDER BY materias.nombre ASC";

        $stmt = $bd->prepare($sql);

        $stmt->bindParam(':id_alumno', $id_alumno, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>