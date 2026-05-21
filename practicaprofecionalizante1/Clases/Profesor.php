<?php

class Profesor {
    public string $nombre;
    public string $email;

    public function __construct($nombre, $email) {
        $this->nombre = $nombre;
        $this->email = $email;
    }

    public static function subirProfesor($bd, $nuevo_nombre, $nuevo_email) {
        $sql = "INSERT INTO Profesores (nombre, email)
                VALUES (:nombre, :email)";

        $stmt = $bd->prepare($sql);
        $stmt->bindParam(":nombre", $nuevo_nombre, PDO::PARAM_STR);
        $stmt->bindParam(":email", $nuevo_email, PDO::PARAM_STR);
        return $stmt->execute(); 
    }

    public function buscarProfesor($bd, $id_profesor) {
        $sql = "SELECT * FROM Profesores WHERE id_profesor = :id_profesor";
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':id_profesor', $id_profesor);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function obtenerProfesor($bd) {
        $sql = "SELECT * FROM Profesores";
        $stmt = $bd->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function editarProfesor($bd, $id_profesor, $nombre_nuevo, $email_nuevo) {
        $sql = "UPDATE Profesores 
                SET nombre = :nombre,
                    email = :email
                WHERE id_profesor = :id_profesor";

        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':nombre', $nombre_nuevo);
        $stmt->bindParam(':email', $email_nuevo);
        $stmt->bindParam(':id_profesor', $id_profesor);
        return $stmt->execute();
    }

    public static function eliminarProfesor($bd, $id_profesor) {
        $sql = "DELETE FROM Profesores WHERE id_profesor = :id_profesor";
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':id_profesor', $id_profesor);
        return $stmt->execute();
    }

    public function verificarProfesor($bd) {
        $sql = "SELECT * FROM Profesores WHERE dni = :dni";
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':dni', $this->dni);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}
?>
