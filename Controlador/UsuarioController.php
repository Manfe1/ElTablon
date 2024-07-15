<?php
require_once("../Modelo/UsuarioModel.php");

class UsuarioController
{
    private $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }
    public function mostrarPerfilUsuario($id_usuario)
    {
        // Obtener información del usuario y la dirección
        $usuario = $this->usuarioModel->obtenerUsuarioPorId($id_usuario);
        $direccion = $this->usuarioModel->obtenerDireccionUsuarioPorId($id_usuario);
        $anuncios = $this->usuarioModel->obtenerAnunciosUsuarioConRespuestas($id_usuario);

        // Verificar si se obtuvieron los datos del usuario
        if ($usuario) {
            // Verificar si se obtuvieron los datos de la dirección
            if ($direccion) {
                // Verificar si se obtuvieron los anuncios del usuario
                if ($anuncios) {
                    return array('usuario' => $usuario, 'direccion' => $direccion, 'anuncios' => $anuncios);
                } else {
                    // SI el usuario no ha creado ningún anuncio
                    return array('usuario' => $usuario, 'direccion' => $direccion, 'anuncios' => null);
                }
            } else {
                // Si no se pueden obtener los datos de la dirección
                return array('usuario' => $usuario, 'direccion' => null, 'anuncios' => null);
            }
        } else {
            // Si no se puedan obtener los datos del usuario
            return null;
        }
    }
}
