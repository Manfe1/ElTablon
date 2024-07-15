<?php
require_once("../Controlador/ConexionController.php");

class UsuarioModel
{
    private $conexion;

    public function __construct()
    {
        $conexionController = new ConexionController();
        $this->conexion = $conexionController->conectar();
    }

    public function obtenerUsuarioPorId($id_usuario)
    {
        $consulta = $this->conexion->prepare("SELECT * FROM usuarios WHERE id = ?");
        $consulta->execute([$id_usuario]);
        return $consulta->fetch();
    }

    public function obtenerDireccionUsuarioPorId($id_usuario)
    {
        $consulta = $this->conexion->prepare("SELECT * FROM direcciones WHERE id_usuario = ?");
        $consulta->execute([$id_usuario]);
        return $consulta->fetch();
    }

    public function obtenerAnunciosUsuarioConRespuestas($id_usuario)
    {
        $consulta = $this->conexion->prepare("SELECT a.*, r.cuerpo AS respuesta_cuerpo,
                     r.fecha_envio AS respuesta_fecha, u.correo AS respuesta_correo
                FROM anuncios a
                LEFT JOIN respuestas r ON a.id = r.id_anuncio
                LEFT JOIN usuarios u ON r.id_usuario = u.id
                WHERE a.id_usuario = ?
                ORDER BY a.fecha_publicacion DESC, r.fecha_envio ASC");

        $consulta->execute([$id_usuario]);
        $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

        $anuncios = [];
        foreach ($resultados as $fila) {
            $anuncio_id = $fila['id'];
            if (!isset($anuncios[$anuncio_id])) {
                $anuncios[$anuncio_id] = [
                    'id' => $fila['id'],
                    'titulo' => $fila['titulo'],
                    'cuerpo' => $fila['cuerpo'],
                    'fecha_publicacion' => $fila['fecha_publicacion'],
                    'respuestas' => []
                ];
            }
            if ($fila['respuesta_cuerpo']) {
                $anuncios[$anuncio_id]['respuestas'][] = [
                    'cuerpo' => $fila['respuesta_cuerpo'],
                    'fecha' => $fila['respuesta_fecha'],
                    'correo' => $fila['respuesta_correo']
                ];
            }
        }
        return array_values($anuncios);
    }

    public function actualizarDireccionUsuario($id_usuario, $ciudad, $codigo_postal)
    {
        $consulta = $this->conexion->prepare("SELECT * FROM direcciones WHERE id_usuario = ?");
        $consulta->execute([$id_usuario]);
        $direccion = $consulta->fetch();

        if ($direccion) {
            $consulta = $this->conexion->prepare("UPDATE direcciones SET ciudad = ?, codigo_postal = ? WHERE id_usuario = ?");
            return $consulta->execute([$ciudad, $codigo_postal, $id_usuario]);
        } else {
            $consulta = $this->conexion->prepare("INSERT INTO direcciones (id_usuario, ciudad, codigo_postal) VALUES (?, ?, ?)");
            return $consulta->execute([$id_usuario, $ciudad, $codigo_postal]);
        }
    }
}
