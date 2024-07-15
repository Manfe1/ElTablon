<?php
// Verificar si se han enviado datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir el archivo de conexión a la base de datos
    require_once("../Controlador/ConexionController.php");

    // Obtener los datos del formulario
    $id_anuncio = $_POST['id_anuncio'];
    $cuerpo = $_POST['cuerpo'];

    // Obtener el ID de usuario de la sesión
    session_start();
    $id_usuario = $_SESSION["id_usuario"];

    // Conectar a la base de datos
    $conexionController = new ConexionController();
    $conexion = $conexionController->conectar();

    // Verificar si la conexión fue exitosa
    if ($conexion) {
        // Preparar la consulta
        $consulta = $conexion->prepare("INSERT INTO respuestas (id_anuncio, id_usuario, cuerpo) VALUES (?, ?, ?)");

        // Ejecutar la consulta
        $consulta->execute([$id_anuncio, $id_usuario, $cuerpo]);

        // Verificar si la consulta se ejecutó correctamente
        if ($consulta) {
            // Mostrar alerta de éxito
            echo '<script>alert("Respuesta enviada correctamente."); window.location.href = "../Vista/tablon.php";</script>';
        } else {
            // Mostrar alerta de error
            echo '<script>alert("Error al enviar la respuesta."); window.location.href = "../Vista/tablon.php";</script>';
        }
    } else {
        // Si falla la conexión
        echo "Error al conectar a la base de datos.";
    }
} else {
    // Si no se envían datos del formulario
    echo "No se han recibido datos del formulario.";
}
