<?php

class Materia{
    public string $nombre ;
    public string $curso ;
    public int $id_carrera;
    public int $id_profesor;
    public float $nota_aprobacion;

    public function __construct ($nombre, $curso, $id_carrera, $id_profesor, $nota_aprobacion){
        $this->nombre = $nombre;
        $this->curso = $curso;
        $this->id_carrera = $id_carrera;
        $this->id_profesor = $id_profesor;
        $this->nota_aprobacion = $nota_aprobacion;
    }

    public function subirMateria($bd,$nuevo_nombre, $nuevo_curso,$nuevo_id_carrera, $nuevo_id_profesor, $nuevo_nota_aprobacion) {
        $sql= "INSERT INTO Materias (nombre, curso, id_carrera, id_profesor, nota_aprobacion) VALUES (:nombre, :curso, :id_carrera, :id_profesor, :nota_aprobacion)";
        $stmt=$bd->prepare($sql);
        $stmt->bindParam(":nombre", $nuevo_nombre, PDO::PARAM_STR);
        $stmt->bindParam(":curso", $nuevo_curso, PDO::PARAM_STR);
        $stmt->bindParam(":id_carrera", $nuevo_id_carrera, PDO::PARAM_INT);
        $stmt->bindParam(":id_profesor", $nuevo_id_profesor, PDO::PARAM_INT);
        $stmt->bindParam(":nota_aprobacion", $nuevo_nota_aprobacion, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function buscarMateria($bd,$id_materia){
        $sql = "SELECT * FROM Materias WHERE id_materia = :id_materia";
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':id_materia', $id_materia);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

public static function obtenerMateria($bd){

    $sql = "SELECT 
                Materias.id_materia,
                Materias.nombre,
                Materias.curso,
                Materias.nota_aprobacion,
                Materias.id_carrera,
                Materias.id_profesor,
                Carreras.nombre AS nombre_carrera,
                Profesores.nombre AS nombre_profesor

            FROM Materias

            INNER JOIN Carreras 
                ON Materias.id_carrera = Carreras.id_carrera

            INNER JOIN Profesores 
                ON Materias.id_profesor = Profesores.id_profesor";

    $stmt = $bd->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

    public static function editarMateria($bd,$id_materia,$nombre_nuevo, $curso_nuevo, $id_carrera_nuevo, 
                                            $id_profesor_nuevo, $nota_aprobacion_nuevo) {
        $sql = "UPDATE Materias SET nombre = :nombre, curso = :curso, id_carrera = :id_carrera, 
        id_profesor = :id_profesor, nota_aprobacion = :nota_aprobacion WHERE id_materia = :id_materia";
        
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':nombre', $nombre_nuevo);
        $stmt->bindParam(':curso', $curso_nuevo);
        $stmt->bindParam(':id_carrera', $id_carrera_nuevo);
        $stmt->bindParam(':id_profesor', $id_profesor_nuevo);
        $stmt->bindParam(':nota_aprobacion', $nota_aprobacion_nuevo);
        $stmt->bindParam(':id_materia', $id_materia);
        
        $stmt->execute();
    }

    public static function eliminarMateria($bd, $id_materia){
        $sql = "DELETE FROM Materias WHERE  id_materia = :id_materia";
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':id_materia', $id_materia);
        $stmt->execute();   

    }

    public function verificarMateria($bd){
        $sql = "SELECT * FROM Materias WHERE nombre = :nombre";
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
