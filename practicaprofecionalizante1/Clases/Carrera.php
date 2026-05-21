<?php

class Carrera{
    public string $nombre ;

    public function __construct($nombre){
        $this->nombre = $nombre;
    }

    public function subirCarrera($bd) {
        $sql= "INSERT INTO Carreras (nombre) VALUES (:nombre)";
        $stmt=$bd->prepare($sql);
        $stmt->bindParam(":nombre", $this->nombre, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function buscarCarrera($bd,$id_carrera){
        $sql = "SELECT * FROM Carreras WHERE id_carrera = :id_carrera";
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':id_carrera', $id_carrera);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function obtenerCarrera($bd){
        $sql = "SELECT * FROM Carreras";
        $stmt = $bd->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function editarCarrera($bd,$id_carrera,$nombre_nuevo) {
        $sql = "UPDATE Carreras SET nombre = :nombre WHERE id_carrera = :id_carrera";
        
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':nombre', $nombre_nuevo);
        $stmt->bindParam(':id_carrera', $id_carrera);
        
        $stmt->execute();
    }

    public static function eliminarCarrera($bd, $id_carrera){
        $sql = "DELETE FROM Carreras WHERE  id_carrera = :id_carrera";
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':id_carrera', $id_carrera);
        $stmt->execute();   

    }

    public function verificarCarrera($bd){
        $sql = "SELECT * FROM Carreras WHERE nombre = :nombre";
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
