<?php
session_start();
include_once "DataBase.php";     
include_once "Clases/Usuario.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = $_POST["correo"];
    $contrasenia = $_POST["contrasenia"];
    $contrasenia2 = $_POST["contrasenia2"];
    $nombre = $_POST["nombre"];
   

    $usuario = new Usuario($correo,$nombre, $contrasenia );
    
    if ($usuario->buscarUsuario($bd,$correo)) {
        $error='Ya hay un usuario registrado con este correo, intente con otro.';
    } else if ($contrasenia<>$contrasenia2){
         $error='Las contraseñas no coinciden, intentelo nuevamente.';
    } else {
        $usuario->subirUsuario($bd, $correo, $nombre, $contrasenia);
       header("Location: Vistas/paginaInicio.php"); 
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar sesión</title>
  <link rel="stylesheet" href="CSS/registrarse.css">
</head>
<body>

  <div class="form-wrapper">
      <form method="POST" class="form-login">
            <a href="index.php">Volver</a>
            <h1 class="titulo">Ingresa los datos de tu cuenta</h1>
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="email" name="correo" placeholder="Correo electrónico" required>
            <input type="password" name="contrasenia" placeholder="Contraseña" required>
            <input type="password" name="contrasenia2" placeholder="Verificar contraseña" required>
            
            <button type="submit">Ingresar</button>
                <?php 
                    if (isset($error)){
                        echo'<p style="color:red;">'.$error.'</p>';
                    }
                ?>
      </form>
      
  </div>


</body>
</html>
