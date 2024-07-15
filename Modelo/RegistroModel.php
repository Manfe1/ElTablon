<?php
include_once("../Controlador/ConexionController.php");

class RegistroModel
{
    // Método para registro de usuario
    public function registrarUsuario($nombre, $correo, $contrasena)
    {
        // Conexión con BD
        $conexionController = new ConexionController();
        $conexion = $conexionController->conectar();

        // Encriptar contraseña
        $contrasena_encriptada = password_hash($contrasena, PASSWORD_DEFAULT);

        // Preparar consulta para insertar usuario en BD
        try {
            $consulta = $conexion->prepare("INSERT INTO usuarios (nombre, correo, contrasena) VALUES (?, ?, ?)");
            $consulta->bindParam(1, $nombre);
            $consulta->bindParam(2, $correo);
            $consulta->bindParam(3, $contrasena_encriptada);
            $consulta->execute();

            $conexion = null;

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
}
