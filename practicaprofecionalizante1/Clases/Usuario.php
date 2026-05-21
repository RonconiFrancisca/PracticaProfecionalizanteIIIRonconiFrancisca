<?php

class Usuario{
    public string $correo;
    protected $contrasenia;
    public string $nombre;


    public function __construct($correo,$contrasenia, $nombre){
        $this->correo = $correo;
        $this->contrasenia = $contrasenia;
        $this->nombre = $nombre;
    }
    
    public static function subirUsuario($bd, $nuevo_correo, $nuevo_nombre, $contrasenia_nueva) {
        try {
            $hash_contrasenia = password_hash($contrasenia_nueva, PASSWORD_DEFAULT); 
            $sql = "INSERT INTO Usuarios (correo, contrasenia, nombre)
                        VALUES (:correo, :contrasenia, :nombre)";
            $stmt = $bd->prepare($sql);
            $stmt->bindParam(":correo", $nuevo_correo, PDO::PARAM_STR);
            $stmt->bindParam(":contrasenia", $hash_contrasenia, PDO::PARAM_STR);
            $stmt->bindParam(":nombre", $nuevo_nombre, PDO::PARAM_STR);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function verificarcontrasenia($bd,$correo,$contrasenia){
        $sql="SELECT * FROM Usuarios WHERE correo=:correo";
        $stmt=$bd->prepare($sql);
        $stmt->bindParam(':correo',$correo);
        $stmt->execute();
        $row=$stmt->fetch(PDO::FETCH_ASSOC);

        if($row){
            if(password_verify($contrasenia,$row['contrasenia'])) {
                return $row;
            } else{
                return false;
            }
        }
        
    }
    
    public static function editarUsuario($bd, $nuevo_correo, $nuevo_nombre, $contrasenia_nueva, $id_usuario) {
        if (empty($contrasenia_nueva)) {
            $sql = "UPDATE Usuarios SET correo = :nuevo_correo,nombre = :nuevo_nombre
                    WHERE id_usuario = :id_usuario";

            $stmt = $bd->prepare($sql);
            $stmt->bindParam(':nuevo_correo', $nuevo_correo);
            $stmt->bindParam(':nuevo_nombre', $nuevo_nombre);
            $stmt->bindParam(':id_usuario', $id_usuario);
        } else {
            $nueva_contrasenia_hasheada = password_hash($contrasenia_nueva, PASSWORD_DEFAULT);

            $sql = "UPDATE Usuarios SET correo = :nuevo_correo, nombre = :nuevo_nombre, contrasenia = :nueva_contrasenia_hasheada
                    WHERE id_usuario = :id_usuario";

            $stmt = $bd->prepare($sql);
            $stmt->bindParam(':nuevo_correo', $nuevo_correo);
            $stmt->bindParam(':nuevo_nombre', $nuevo_nombre);
            $stmt->bindParam(':nueva_contrasenia_hasheada', $nueva_contrasenia_hasheada);
            $stmt->bindParam(':id_usuario', $id_usuario);
        }
        return $stmt->execute();
    }

    public function buscarUsuario($bd,$correo){
        $sql = "SELECT * FROM Usuarios WHERE correo = :correo";
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function obtenerUsuario($bd){
        $sql = "SELECT id_usuario, correo, nombre FROM Usuarios"; 
        $stmt = $bd->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function eliminarUsuario($bd,$id_usuario){
        $sql = "DELETE FROM Usuarios WHERE id_usuario = :id_usuario";
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();


    }

    public function verificarUsuario($bd){
        $sql = "SELECT * FROM Usuarios WHERE correo = :correo";
        $stmt = $bd->prepare($sql);
        $stmt->bindParam(':correo', $this->correo);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>