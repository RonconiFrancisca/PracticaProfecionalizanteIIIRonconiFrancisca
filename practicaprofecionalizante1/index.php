<?php
session_start();
include_once "DataBase.php";     
include_once "Clases/Usuario.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $correo = $_POST["correo"];
    $contrasenia = $_POST["contrasenia"];

    $usuarioObj = new Usuario($correo, $contrasenia, '');
    $usuarioValido = $usuarioObj->verificarcontrasenia($bd, $correo, $contrasenia);

    if ($usuarioValido) {
        $_SESSION["Usuarios"] = [
            "id" => $usuarioValido["id_usuario"],
            "correo" => $usuarioValido["correo"],
            "nombre" => $usuarioValido["nombre"]
        ];

        header("Location:Vistas/paginaInicio.php"); 
        exit;
    } else {
        $error = "Correo o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar sesión</title>
  <link rel="stylesheet" href="CSS/index.css">
</head>
<body>

  <div class="form-wrapper">
      <form method="POST" class="form-login">
          <h1 class="titulo">Iniciar sesión</h1>
          <input type="email" name="correo" placeholder="Correo electrónico" required>
          <input type="password" name="contrasenia" placeholder="Contraseña" required>
          <button type="submit">Ingresar</button>
            <?php if (isset($error)){
                    echo '<p style="color:red;">'.$error.'</p>';
                    } 
            ?>
             <p>¿No tenes una cuenta creada? <a href="registrarse.php">Registrate acá</a></p>
      </form>
  </div>

</body>
</html>
