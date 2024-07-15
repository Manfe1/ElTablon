<?php
include_once("../Controlador/RegistroController.php");

$registroController = new RegistroController();
$registroController->registroUsuario();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../css/estilos.css">
</head>

<body>
    <h1>FORMULARIO DE REGISTRO</h1>
    <p>Rellene todos los campos y pulse el botón para registrarse como usuario de ElTablón.</p>
    <br><br>
    <form name="registro" method="POST" action="#">
        <label>Nombre: </label> <input name="nombre" type="text" required>
        <br><br>
        <label>Correo Electrónico: </label> <input name="correo" type="email" required>
        <br><br>
        <label>Contraseña: </label><input name="pass" type="password" required>
        <br><br>
        <label>Confirmar contraseña: </label><input name="pass2" type="password" required>
        <br><br>
        <input type="submit" name="REGISTRO" value="REGISTRARSE" style="cursor: pointer">
    </form>
    <br><br>
    <a href="loginView.php">Ya estoy registrado. Volver a Login</a>
</body>

</html>