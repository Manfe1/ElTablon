<?php
// Verificar si se han enviado datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir el archivo de conexión a la base de datos
    require_once("../Controlador/ConexionController.php");

    // Obtener los datos del formulario
    $id_anuncio = $_POST['id_anuncio'];
    $titulo = $_POST['titulo'];
    $cuerpo = $_POST['cuerpo'];

    // Conectar a la base de datos
    $conexionController = new ConexionController();
    $conexion = $conexionController->conectar();

    // Verificar si la conexión fue exitosa
    if ($conexion) {
        // Preparar la consulta
        $consulta = $conexion->prepare("UPDATE anuncios SET titulo = ?, cuerpo = ? WHERE id = ?");

        // Ejecutar la consulta
        $consulta->execute([$titulo, $cuerpo, $id_anuncio]);

        if ($consulta->rowCount() > 0) {
            // Redirigir de vuelta a la página de usuario después de actualizar el anuncio
            echo '<script>alert("Anuncio actualizado correctamente."); window.location.href = "../Vista/usuario.php";</script>';
        } else {
            // Si no se actualizó ninguna fila
            echo '<script>alert("Error al actualizar el anuncio."); window.location.href = "../Vista/usuario.php";</script>';
        }
    } else {
        // Si falla la conexión a la base de datos
        echo '<script>alert("Error al conectar con la base de datos."); window.location.href = "../Vista/usuario.php";</script>';
    }
} else {
    // Redirigir si se accede al script sin enviar el formulario
    header("Location: ../Vista/usuario.php");
    exit();
}
