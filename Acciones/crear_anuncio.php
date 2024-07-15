<?php
// Iniciar la sesión
session_start();

// Verificar si se han enviado datos por el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se han enviado datos
    if (isset($_POST["titulo"]) && isset($_POST["cuerpo"])) {
        // Obtener los datos del formulario
        $titulo = $_POST["titulo"];
        $cuerpo = $_POST["cuerpo"];

        // Obtener el id_usuario desde la sesión
        if (isset($_SESSION["id_usuario"])) {
            $id_usuario = $_SESSION["id_usuario"];

            // Incluir el archivo de conexión a la base de datos
            require_once("../Controlador/ConexionController.php");

            // Instanciar el controlador de conexión
            $conexionController = new ConexionController();
            $conexion = $conexionController->conectar();

            // Verificar si la conexión fue exitosa
            if ($conexion) {
                try {
                    // Preparar la consulta
                    $consulta = $conexion->prepare("INSERT INTO anuncios (titulo, cuerpo, id_usuario) VALUES (?, ?, ?)");
                    $consulta->bindParam(1, $titulo);
                    $consulta->bindParam(2, $cuerpo);
                    $consulta->bindParam(3, $id_usuario);

                    // Ejecutar la consulta
                    $consulta->execute();

                    // Mostrar mensaje de éxito y redirigir al usuario
                    echo '<script>alert("Anuncio creado."); window.location.href = "../Vista/usuario.php";</script>';
                } catch (PDOException $e) {
                    // Si falla la consulta
                    echo "Error al crear el anuncio: " . $e->getMessage();
                }
            } else {
                // Si falla la conexión a la base de datos
                echo "Error al conectar a la base de datos.";
            }
        } else {
            // Si no se hayan enviado todos los datos necesarios
            echo "Por favor, complete todos los campos del formulario.";
        }
    } else {
        // Si no se haya enviado el formulario
        echo "Acceso no autorizado.";
    }
}
