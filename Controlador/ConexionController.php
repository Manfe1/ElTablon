<?php
include_once("../Modelo/ConexionModel.php");

class ConexionController
{
    public function conectar()
    {
        $conexionModel = new ConexionModel();
        return $conexionModel->conectar();
    }
}
