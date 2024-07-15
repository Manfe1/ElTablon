<?php
include_once("../Modelo/RegistroModel.php");

class RegistroController
{
    // Método para manejar el registro de usuarios
    public function registroUsuario()
    {
        if (isset($_POST['REGISTRO'])) {
            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];
            $contrasena = $_POST['pass'];
            $contrasena_confirmada = $_POST['pass2'];

            if ($contrasena == $contrasena_confirmada) {
                // LLamo a la función del modelo para registrar usuarios
                $registroModel = new RegistroModel();
                $resultado = $registroModel->registrarUsuario($nombre, $correo, $contrasena);

                if ($resultado) {
                    // Mostrar alerta con botón de redirección
                    echo '<script>alert("Usuario registrado exitosamente."); window.location.href = "loginView.php";</script>';
                } else {
                    echo 'Error al registrar usuario';
                }
            } else {
                echo 'Las contraseñas no coinciden<br><br>';
            }
        }
    }
}
