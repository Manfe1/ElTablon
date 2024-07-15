<?php
// Iniciar la sesión
session_start();

// Verificar si el usuario ha iniciado sesión y obtener su ID de usuario
if (isset($_SESSION["id_usuario"])) {
    $id_usuario = $_SESSION["id_usuario"];

    // Incluir el controlador de usuario
    require_once("../Controlador/UsuarioController.php");

    // Crear una instancia del controlador de usuario
    $usuarioController = new UsuarioController();

    // Llamar al método para mostrar el perfil del usuario
    $perfilUsuario = $usuarioController->mostrarPerfilUsuario($id_usuario);

    // Verificar si se obtuvieron los datos del perfil del usuario
    if ($perfilUsuario) {
        $nombre = isset($perfilUsuario['usuario']['nombre']) ? $perfilUsuario['usuario']['nombre'] : "-";
        $correo = isset($perfilUsuario['usuario']['correo']) ? $perfilUsuario['usuario']['correo'] : "-";
        $ciudad = isset($perfilUsuario['direccion']['ciudad']) ? $perfilUsuario['direccion']['ciudad'] : "-";
        $codigo_postal = isset($perfilUsuario['direccion']['codigo_postal']) ? $perfilUsuario['direccion']['codigo_postal'] : "-";
    } else {
        // Si no se pudieron obtener los datos del perfil del usuario
        $nombre = "-";
        $correo = "-";
        $ciudad = "-";
        $codigo_postal = "-";
    }
} else {
    // Redirigir al usuario al formulario de inicio de sesión si no ha iniciado sesión
    header("Location: loginView.php");
    exit(); // Detener la ejecución del script después de redirigir
}
?>

<?php include 'header.php'; ?>

<h1>Bienvenido a tu perfil de usuario</h1>
<hr class="divider">
<!-- Seccion de datos del usuario -->
<div style="display: flex; align-items: center;">
    <h2 style="margin-right: 20px;">Datos del Usuario</h2>
    <button onclick="mostrarFormularioEdicionUsuario()">Editar Datos del Usuario</button>
</div>

<div style="display: flex;">
    <div>
        <p><strong>Nombre:</strong> <?php echo $nombre; ?></p>
        <p><strong>Correo:</strong> <?php echo $correo; ?></p>
        <p><strong>Ciudad:</strong> <?php echo $ciudad; ?></p>
        <p><strong>Código Postal:</strong> <?php echo $codigo_postal; ?></p>
    </div>
    <div id="formulario_edicion_usuario" style="display:none; margin-left: 20px;">
        <h3>Editar Datos del Usuario</h3>
        <form action="../Acciones/actualizar_direccion.php" method="POST">
            <label for="ciudad">Ciudad:</label>
            <input type="text" id="ciudad" name="ciudad" required placeholder="<?php echo htmlspecialchars($ciudad); ?>">
            <br>
            <label for="codigo_postal">Código Postal:</label>
            <input type="text" minlength="5" maxlength="5" pattern="\d{5}" id="codigo_postal" name="codigo_postal" required placeholder="<?php echo htmlspecialchars($codigo_postal); ?>">
            <br>
            <button type="submit">Actualizar Datos</button>
            <button type="button" onclick="ocultarFormularioEdicionUsuario()">Cancelar</button>
        </form>
    </div>
</div>
<hr class="divider">


<!-- Seccion de anuncios del ususario -->
<div style="display: flex; align-items: center;">
    <h2 style="margin-right: 20px;">Anuncios Creados</h2>

    <!--Crear nuevo anuncio-->
    <?php if ($ciudad !== '-' && $codigo_postal !== '-') : ?>
        <button onclick="mostrarFormularioCreacionAnuncio()">Crear nuevo anuncio</button>
    <?php else : ?>
        <p>Para poder crear un nuevo anuncio, necesitas completar tu información de ciudad y código postal en tu perfil.</p>
    <?php endif; ?>

</div>
<div id="formulario_crear_anuncio" style="display:none;">
    <h2>Crear Nuevo Anuncio</h2>
    <form action="../Acciones/crear_anuncio.php" method="POST">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required>
        <label for="cuerpo">Cuerpo del Anuncio:</label>
        <textarea id="cuerpo" name="cuerpo" required></textarea>
        <button type="submit">Crear Anuncio</button>
        <button type="button" onclick="ocultarFormularioCreacionAnuncio()">Cancelar</button>
    </form>
</div>
<!-- Mostrar anuncios creados y sus respuestas -->
<?php if ($perfilUsuario && !empty($perfilUsuario['anuncios'])) { ?>
    <?php foreach ($perfilUsuario['anuncios'] as $anuncio) { ?>
        <div>
            <div style="display: flex; align-items: center;">
                <h4 style="margin-right: 20px;"><?php echo $anuncio['titulo']; ?></h4>
                <form class="form-borrar-anuncio" action="../Acciones/borrar_anuncio.php" method="POST" style="display:inline;">
                    <input type="hidden" name="id_anuncio" value="<?php echo $anuncio['id']; ?>">
                    <button type="submit" onclick="return confirm('¿Estás seguro de que deseas borrar este anuncio?');">Borrar Anuncio</button>
                </form>
                <hr>
                <button onclick="mostrarFormularioEdicionAnuncio('<?php echo $anuncio['id']; ?>', '<?php echo addslashes($anuncio['titulo']); ?>', '<?php echo addslashes($anuncio['cuerpo']); ?>')" style="margin-left: 10px;">Editar Anuncio</button>
            </div>
            <p><?php echo $anuncio['cuerpo']; ?></p>
            <p><strong>Fecha de Creación:</strong> <?php echo $anuncio['fecha_publicacion']; ?></p>
            <div id="formulario_edicion_anuncio_<?php echo $anuncio['id']; ?>" style="display:none; margin-top: 20px;">
                <h4>Editar Anuncio</h4>
                <form action="../Acciones/editar_anuncio.php" method="POST">
                    <input type="hidden" id="id_anuncio_editar_<?php echo $anuncio['id']; ?>" name="id_anuncio" value="<?php echo $anuncio['id']; ?>">
                    <label for="titulo_editar_<?php echo $anuncio['id']; ?>">Título:</label>
                    <input type="text" id="titulo_editar_<?php echo $anuncio['id']; ?>" name="titulo" required>
                    <label for="cuerpo_editar_<?php echo $anuncio['id']; ?>">Cuerpo del Anuncio:</label>
                    <textarea id="cuerpo_editar_<?php echo $anuncio['id']; ?>" name="cuerpo" required></textarea>
                    <button type="submit">Guardar Cambios</button>
                    <button type="button" onclick="ocultarFormularioEdicionAnuncio('<?php echo $anuncio['id']; ?>')">Cancelar</button>
                </form>
            </div>
            <hr>
            <h5>Respuestas:</h5>
            <hr>
            <?php if (!empty($anuncio['respuestas'])) { ?>
                <?php foreach ($anuncio['respuestas'] as $respuesta) { ?>
                    <div>
                        <p><strong>Correo del autor:</strong> <?php echo $respuesta['correo']; ?></p>
                        <p><?php echo $respuesta['cuerpo']; ?></p>
                        <p><strong>Fecha:</strong> <?php echo $respuesta['fecha']; ?></p>
                    </div>
                    <hr class="peque">
                <?php } ?>
            <?php } else { ?>
                <p>No hay respuestas para este anuncio.</p>
            <?php } ?>
        </div>
        <hr>
    <?php } ?>
<?php } else { ?>
    <p>No has creado ningún anuncio.</p>
<?php } ?>

<?php include 'footer.php'; ?>