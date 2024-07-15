<?php
require_once("../Controlador/AnunciosController.php");

// Crear una instancia del controlador de anuncios
$anunciosController = new AnunciosController();

// Llamar al método para mostrar los anuncios
$anuncios = $anunciosController->mostrarAnuncios();

// Verificar si se obtuvieron los anuncios
if ($anuncios) {
?>
    <?php include 'header.php'; ?>
    <h1>Tablón de Anuncios</h1>

    <?php foreach ($anuncios as $anuncio) : ?>
        <div>
            <h2><?php echo $anuncio['titulo']; ?></h2>
            <p><strong>Autor:</strong> <?php echo $anuncio['nombre_autor']; ?></p>
            <p><strong>Ciudad:</strong> <?php echo $anuncio['ciudad']; ?></p>
            <p><strong>Código Postal:</strong> <?php echo $anuncio['codigo_postal']; ?></p>
            <p><strong>Fecha de Creación:</strong> <?php echo $anuncio['fecha_publicacion']; ?></p>
            <p><?php echo $anuncio['cuerpo']; ?></p>
            <button onclick="mostrarRespuesta(<?php echo $anuncio['id']; ?>)">Responder</button>
            <div id="respuesta_<?php echo $anuncio['id']; ?>" style="display: none;">
                <form id='formularioRespuesta' action="../Acciones/responder.php" method="POST">
                    <textarea name="cuerpo" rows="4" cols="50"></textarea>
                    <input type="hidden" name="id_anuncio" value="<?php echo $anuncio['id']; ?>">
                    <input type="submit" value="Enviar respuesta">
                    <button type="button" onclick="ocultarRespuesta()">Cancelar</button>
                </form>
            </div>
        </div>
        <hr>
    <?php endforeach; ?>
    <script>
        function mostrarRespuesta(id_anuncio) {
            var respuestaDiv = document.getElementById('respuesta_' + id_anuncio);
            respuestaDiv.style.display = 'block';}
        function ocultarRespuesta() {
            document.getElementById('formularioRespuesta').style.display = 'none';
        }
    </script>

    </body>

    </html>
<?php
} else {
    echo "No se encontraron anuncios.";
}
?>
<?php include 'footer.php'; ?>