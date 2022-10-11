<?php
namespace Controllers;

use Classes\Email;
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

        $usuario = new Usuario;
        $alertas = [];
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario -> sincronizar($_POST);
            $alertas = $usuario ->validarNuevaCuenta();

            // Revisar que alertas este vacio 
            if(empty($alertas)) {
                // Verificar que el usuario no este ya registrado por medio del email 
                $resultado = $usuario -> validarUsuario();

                if($resultado->num_rows) {

                    $alertas = Usuario::getAlertas();

                } else {
                    // Hashear Password
                    $usuario -> hashPassword();

                    // Crear Token Unico
                    $usuario -> crearToken();

                    // Enviar email de confirmación de cuenta por token
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token); 

                    $email -> enviarConfirmacion();
                    
                    // Crear el Usuario
                    $resultado = $usuario -> guardar();
                    if($resultado) {
                        header('Location: /mensaje');
                    }                    
                }
            }
            
        }

        $router->render('auth/crearCuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router){
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router){

        $alertas = [];

        $token = s($_GET['token']);

        $usuario = Usuario::where('token', $token);

        debuguear($token);

        // if(empty($usuario)) {

        //     echo 'no valido';

        // } else {

        //     echo 'valido';

        // }

        // Renderizar la Vista
        // $alertas = Usuario::getAlertas();

        // Obtener Alertas
        $router->render('auth/confirmarCuenta', [
            'alertas' => $alertas 
        ]);
    }
}