<?php
// Verificar si se han enviado datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir el archivo de conexión a la base de datos
    require_once("../Controlador/ConexionController.php");

    // Obtener el ID del anuncio a borrar
    $id_anuncio = $_POST['id_anuncio'];

    // Conectar a la base de datos
    $conexionController = new ConexionController();
    $conexion = $conexionController->conectar();

    // Verificar si la conexión fue exitosa
    if ($conexion) {
        // Iniciar una transacción pora asegurar que se borre todo o nada
        $conexion->beginTransaction();

        try {
            // Preparar y ejecutar la consulta para borrar las respuestas del anuncio
            $consulta_respuestas = $conexion->prepare("DELETE FROM respuestas WHERE id_anuncio = ?");
            $consulta_respuestas->execute([$id_anuncio]);

            // Preparar y ejecutar la consulta para borrar el anuncio
            $consulta_anuncio = $conexion->prepare("DELETE FROM anuncios WHERE id = ?");
            $consulta_anuncio->execute([$id_anuncio]);

            // Confirmar la transacción
            $conexion->commit();

            // Redirigir de vuelta a la página de usuario con un mensaje de éxito
            echo '<script>alert("Anuncio y sus respuestas borrados correctamente."); window.location.href = "../Vista/usuario.php";</script>';
        } catch (Exception $e) {
            // Revertir la transacción en caso de error
            $conexion->rollBack();
            echo '<script>alert("Error al borrar el anuncio y sus respuestas."); window.location.href = "../Vista/usuario.php";</script>';
        }
    } else {
        // Si hay error de conexión a la base de datos
        echo "Error al conectar a la base de datos.";
    }
} else {
    // Si no se envían datos del formulario
    echo "No se han recibido datos del formulario.";
}
