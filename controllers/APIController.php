<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController {
    public static function index() {
        $servicios = Servicio::all();

        // echo json_encode($servicios);
        echo json_encode($servicios, JSON_UNESCAPED_UNICODE);
    }
    
    public static function guardar() {
        
        // Almacena la cita y devuelve el id
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();

        $id = $resultado['id'];

        // Almacena los servicios con el id de la cita
        $idServicios = explode (',', $_POST['servicios']);

        foreach ($idServicios as $idServicio) {
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];

            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }

        // echo json_encode(['resultado' => $resultado]);
        echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
        
    }
}