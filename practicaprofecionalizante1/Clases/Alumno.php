<?php

class Alumno {
    public string $nombre;
    public string $email;
    protected int $dni;
    public DateTime $fecha_nacimiento;     
    public int $id_carrera;
   

    public function __construct($nombre, $email, $dni, $fecha_nacimiento, $id_carrera) {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->dni = $dni;
        $this->fecha_nacimiento = $fecha_nacimiento;
        $this->id_carrera = $id_carrera; 
    }

    public static function subirAlumno($bd, $nuevo_nombre, $nuevo_email, $nuevo_dni, $nuevo_fecha_nacimiento, $nuevo_id_carrera) {
        $sql = "INSERT INTO Alumnos (nombre, email, dni, fecha_nacimiento, id_carrera)
                VALUES (:nombre, :email, :dni, :fecha_nacimiento, :id_carrera)";

        $stmt = $bd->prepare($sql);
        $stmt->bindParam(":nombre", $nuevo_nombre, PDO::PARAM_STR);
        $stmt->bindParam(":email", $nuevo_email, PDO::PARAM_STR);
        $stmt->bindParam(":dni", $nuevo_dni, PDO::PARAM_INT);
        $stmt->bindParam(":fecha_nacimiento", $nuevo_fecha_nacimiento, PDO::PARAM_STR);
        $stmt->bindParam(":id_carrera", $nuevo_id_carrera, PDO::PARAM_INT);
        return $stmt->execute(); 
    }

    public function buscarAlumno($bd, $id_alumno) {
        $sql = "SELECT * FROM Alumnos WHERE id_alumno = :id_alumno";
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':id_alumno', $id_alumno);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function obtenerAlumno($bd) {
        $sql = "SELECT * FROM Alumnos";
        $stmt = $bd->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function editarAlumno($bd, $id_alumno, $nombre_nuevo, $email_nuevo, $fecha_nacimiento_nueva, $id_carrera_nueva) {
        $sql = "UPDATE Alumnos 
                SET nombre = :nombre,
                    email = :email,
                    fecha_nacimiento = :fecha_nacimiento,
                    id_carrera = :id_carrera
                WHERE id_alumno = :id_ alumno";

        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':nombre', $nombre_nuevo);
        $stmt->bindParam(':email', $email_nuevo);
        $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento_nueva);
        $stmt->bindParam(':id_carrera', $id_carrera_nueva);
        $stmt->bindParam(':id_alumno', $id_alumno);
        return $stmt->execute();
    }

    public static function eliminarAlumno($bd, $id_alumno) {
        $sql = "DELETE FROM Alumnos WHERE id_alumno = :id_alumno ";
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':id_alumno', $id_alumno);
        return $stmt->execute();
    }

    public function verificarAlumno($bd) {
        $sql = "SELECT * FROM Alumnos WHERE dni = :dni";
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':dni', $this->dni);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
?>
