<?php

namespace Controllers;

use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {
        
        $router->render('auth/login');
    }

    public static function logout() {
        echo 'Desde LogOut';
    }
    
    public static function olvide(Router $router) {
        $router->render('auth/olvidePass', [

        ]);
    }
    
    public static function recuperar() {
        echo 'Desde Recuperar';
    }
    
    public static function crear(Router $router) {       

        $router->render('auth/crearCuenta', [

        ]);
    }
}