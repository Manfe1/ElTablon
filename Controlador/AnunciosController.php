<?php
require_once("../Modelo/AnunciosModel.php");

class AnunciosController
{
    private $anunciosModel;

    public function __construct()
    {
        $this->anunciosModel = new AnuncioModel();
    }

    public function mostrarAnuncios()
    {
        return $this->anunciosModel->obtenerAnuncios();
    }
}
