</main>

<footer>
    <p>&copy; <?php echo date("Y"); ?> ElTablón. Todos los derechos reservados.</p>
</footer>
<script>
    function mostrarFormularioEdicionAnuncio(id_anuncio, titulo, cuerpo) {
        document.getElementById('formulario_edicion_anuncio_' + id_anuncio).style.display = 'block';
        document.getElementById('id_anuncio_editar_' + id_anuncio).value = id_anuncio;
        document.getElementById('titulo_editar_' + id_anuncio).value = titulo;
        document.getElementById('cuerpo_editar_' + id_anuncio).value = cuerpo;
    }

    function ocultarFormularioEdicionAnuncio(id_anuncio) {
        document.getElementById('formulario_edicion_anuncio_' + id_anuncio).style.display = 'none';
    }

    function mostrarFormularioEdicionUsuario() {
        document.getElementById('formulario_edicion_usuario').style.display = 'block';
    }

    function ocultarFormularioEdicionUsuario() {
        document.getElementById('formulario_edicion_usuario').style.display = 'none';
    }

    function mostrarFormularioCreacionAnuncio() {
        document.getElementById('formulario_crear_anuncio').style.display = 'block';
    }

    function ocultarFormularioCreacionAnuncio() {
        document.getElementById('formulario_crear_anuncio').style.display = 'none';
    }
</script>
</body>

</html>