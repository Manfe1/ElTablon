<?php
// Importar el controlador de inicio de sesión
require_once("../Controlador/LoginController.php");

// Instanciar el controlador de inicio de sesión
$loginController = new LoginController();

// Procesar el inicio de sesión
$loginController->iniciarSesion();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <h1>Iniciar sesión</h1>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="correo">Correo electrónico:</label>
        <input type="email" id="correo" name="correo" required>
        <br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="contrasena" required>
        <br>
        <input type="submit" value="Iniciar sesión" style="cursor: pointer">
    </form>
    <p>¿No tienes una cuenta? <a href="registro.php">Regístrate aquí</a>.</p>
</body>

</html>