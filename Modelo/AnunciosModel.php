<?php
require_once("../Controlador/ConexionController.php");

class AnuncioModel
{
    public function obtenerAnuncios()
    {
        $conexionController = new ConexionController();
        $conexion = $conexionController->conectar();

        if ($conexion) {
            $consulta_anuncios = $conexion->prepare("SELECT anuncios.*, usuarios.nombre AS nombre_autor, direcciones.ciudad, direcciones.codigo_postal 
                                                     FROM anuncios 
                                                     INNER JOIN usuarios ON anuncios.id_usuario = usuarios.id 
                                                     INNER JOIN direcciones ON usuarios.id = direcciones.id_usuario");
            $consulta_anuncios->execute();
            return $consulta_anuncios->fetchAll();
        } else {
            echo ('Error en la conexión');
            return false;
        }
    }
    public function obtenerAnunciosUsuarioConRespuestas($id_usuario)
    {
        $conexionController = new ConexionController();
        $conexion = $conexionController->conectar();

        if ($conexion) {
            // Consulta para obtener los anuncios del usuario y sus respuestas
            $consulta_anuncios = $conexion->prepare("
                SELECT a.*, r.cuerpo AS respuesta_cuerpo, r.fecha_publicacion AS respuesta_fecha, u.correo AS respuesta_correo
                FROM anuncios a
                LEFT JOIN respuestas r ON a.id = r.id_anuncio
                LEFT JOIN usuarios u ON r.id_usuario = u.id
                WHERE a.id_usuario = ?
                ORDER BY a.fecha_publicacion DESC, r.fecha_publicacion ASC
            ");
            $consulta_anuncios->execute([$id_usuario]);
            $resultados = $consulta_anuncios->fetchAll(PDO::FETCH_ASSOC);

            // Agrupar respuestas por anuncio
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
        } else {
            echo ('Error en la conexión');
            return false;
        }
    }
}
