<?php
require_once("../Controlador/ConexionController.php");

class LoginController
{
    public function iniciarSesion()
    {
        // Verificar si se han enviado datos por el formulario
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Verificar si se han enviado datos de correo y contraseña
            if (isset($_POST["correo"]) && isset($_POST["contrasena"])) {
                // Obtener los datos del formulario
                $correo = $_POST["correo"];
                $contrasena = $_POST["contrasena"];

                // Instanciar el controlador de conexión
                $conexionController = new ConexionController();
                $conexion = $conexionController->conectar();

                // Verificar si la conexión fue exitosa
                if ($conexion) {
                    // Preparar la consulta para obtener los datos del usuario
                    $consulta = $conexion->prepare("SELECT * FROM usuarios WHERE correo = ?");
                    $consulta->execute([$correo]);
                    $usuario = $consulta->fetch();

                    // Verificar si se encontró un usuario con el correo proporcionado
                    if ($usuario) {
                        // Verificar si la contraseña proporcionada coincide con la contraseña almacenada en la base de datos
                        if (password_verify($contrasena, $usuario['contrasena'])) {
                            // Iniciar sesión y obtener el id_usuario del usuario autenticado
                            $id_usuario = $usuario['id'];
                            session_start();
                            $_SESSION["id_usuario"] = $id_usuario;


                            // Redirección a la página de usuario
                            header("Location: usuario.php");
                            exit();
                        } else {
                            // Si la contraseña es incorrecta
                            echo "Contraseña incorrecta.";
                        }
                    } else {
                        // Si no se encontró ningún usuario con el correo proporcionado
                        echo "Correo electrónico no encontrado.";
                    }
                } else {
                    // Si no se pudo conectar a la base de datos
                    echo "Error al conectar a la base de datos.";
                }
            }
        }
    }
}
