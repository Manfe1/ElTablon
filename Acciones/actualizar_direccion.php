<?php
// Iniciar la sesión
session_start();

// Verificar si se han enviado datos por el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se han enviado datos de ciudad y código postal
    if (isset($_POST["ciudad"]) && isset($_POST["codigo_postal"])) {
        // Obtener los datos del formulario
        $ciudad = $_POST["ciudad"];
        $codigo_postal = $_POST["codigo_postal"];

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
                // Verificar si el usuario ya tiene una entrada en la tabla de direcciones
                $consulta = $conexion->prepare("SELECT * FROM direcciones WHERE id_usuario = ?");
                $consulta->execute([$id_usuario]);
                $direccion = $consulta->fetch();

                if ($direccion) {
                    // Si el usuario ya tiene una entrada en la tabla de direcciones, actualizar los datos
                    $consulta = $conexion->prepare("UPDATE direcciones SET ciudad = ?, codigo_postal = ? WHERE id_usuario = ?");
                    $consulta->execute([$ciudad, $codigo_postal, $id_usuario]);
                } else {
                    // Si el usuario no tiene una entrada en la tabla de direcciones, insertar nuevos datos
                    $consulta = $conexion->prepare("INSERT INTO direcciones (id_usuario, ciudad, codigo_postal) VALUES (?, ?, ?)");
                    $consulta->execute([$id_usuario, $ciudad, $codigo_postal]);
                }

                // Verificar si la consulta se ejecutó correctamente
                if ($consulta->rowCount() > 0) {
                    echo '<script>;alert("Datos actualizados."); window.location.href = "../Vista/usuario.php";</script>;';
                } else {
                    echo "Error al actualizar los datos.";
                }
            } else {
                echo "Error al conectar a la base de datos.";
            }
        } else {
            echo "No se pudo obtener el ID de usuario.";
        }
    } else {
        echo "Faltan datos en el formulario.";
    }
} else {
    echo "Acceso no autorizado.";
}
