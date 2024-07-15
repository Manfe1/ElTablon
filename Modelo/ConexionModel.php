<?php
class ConexionModel
{
    public function conectar()
    {
        global $host, $pass, $user, $basedatos;
        $host = 'localhost';
        $pass = 'DEsarroll0';
        $user = 'root';
        $basedatos = 'eltablon';
        try {
            $hostPDO = "mysql:host=$host;dbname=$basedatos";
            $cone = new PDO($hostPDO, $user, $pass);
            $cone->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'error de conexión';
            echo 'Linea del error' . $e->getLine();
            return null;
        }
        return $cone;
    }
}
