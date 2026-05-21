<?php

class Examen{
    public int $nota ;
    public DateTime $fecha ;
    public int $id_alumno;
    public int $id_materia;

    public function __construct ($nota, $fecha, $id_alumno, $id_materia){
        $this->nota = $nota;
        $this->fecha = $fecha;
        $this->id_alumno = $id_alumno;
        $this->id_materia = $id_materia;
    }

    public static function subirExamen($bd,$nuevo_nota, $nuevo_fecha,$nuevo_id_alumno, $nuevo_id_materia) {
        $sql= "INSERT INTO Examenes (nota, fecha, id_alumno, id_materia) VALUES (:nota, :fecha, :id_alumno, :id_materia)";
        $stmt=$bd->prepare($sql);
        $stmt->bindParam(":nota", $nuevo_nota, PDO::PARAM_INT);
        $stmt->bindParam(":fecha", $nuevo_fecha, PDO::PARAM_STR);
        $stmt->bindParam(":id_alumno", $nuevo_id_alumno, PDO::PARAM_INT);
        $stmt->bindParam(":id_materia", $nuevo_id_materia, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function buscarExamen($bd,$id_examen){
        $sql = "SELECT * FROM Examenes WHERE id_examen = :id_examen";
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':id_examen', $id_examen);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function obtenerExamenes($bd){
        $sql = "SELECT 
                Examenes.id_examen,
                Examenes.nota,
                Examenes.fecha,
                Examenes.id_alumno,
                Examenes.id_materia,
                Alumnos.nombre AS nombre_alumno,
                Materias.nombre AS nombre_materia
        FROM Examenes 
        LEFT JOIN Alumnos ON Examenes.id_alumno = Alumnos.id_alumno
        LEFT JOIN Materias ON Examenes.id_materia = Materias.id_materia";
        $stmt = $bd->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function editarExamen($bd,$id_examen,$nota_nueva, $fecha_nueva, $id_alumno_nuevo, 
                                        $id_materia_nueva) {
        $sql = "UPDATE Examenes SET nota = :nota, fecha = :fecha, id_alumno = :id_alumno, 
                                            id_materia = :id_materia WHERE id_examen = :id_examen";
        
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':nota', $nota_nueva);
        $stmt->bindParam(':fecha', $fecha_nueva);
        $stmt->bindParam(':id_alumno', $id_alumno_nuevo);
        $stmt->bindParam(':id_materia', $id_materia_nueva);
        $stmt->bindParam(':id_examen', $id_examen);
        
        $stmt->execute();
    }

    public static function eliminarExamen($bd, $id_examen){
        $sql = "DELETE FROM Examenes WHERE  id_examen = :id_examen";
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':id_examen', $id_examen);
        $stmt->execute();

    }

}
?>
