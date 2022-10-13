<?php

namespace Controllers;

use MVC\Router;

class CitaController {

    public static function index(Router $router) {

        if (!isset($_SESSION)) {
            session_start();
        };

        // debuguear($_SESSION);

        $router -> render('cita/index', [
            'nombre' => $_SESSION['nombre']

        ]);

    }
}