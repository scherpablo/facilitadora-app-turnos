<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController
{
    public static function login(Router $router)
    {

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $auth = new Usuario($_POST);

            $alertas = $auth->validarLogin();

            if (empty($alertas)) {
                // Comrpobar que el usuario exista por medio del mail
                $usuario = Usuario::where('email', $auth->email);

                if ($usuario) {

                    if ($usuario->comprobarYVerificarPassword($auth->password)) {

                        // Autenticar el usuario
                        // session_start();
                        if (!isset($_SESSION)) {
                            session_start();
                        };

                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;


                        // Redireccionar segun admin o cliente

                        if ($usuario->admin === "1") {

                            $_SESSION['admin'] = $usuario->admin ?? null;

                            header('Location: /admin');
                        } else {

                            header('Location: /cita');
                        }
                    }
                } else {

                    Usuario::setAlerta('error', 'Usuario no encontrado');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'alertas' => $alertas
        ]);
    }

    public static function logout()
    {
        // session_start();
        if (!isset($_SESSION)) {
            session_start();
        };       
        
        $_SESSION = [];

        header('Location: /');
    }

    public static function olvide(Router $router)
    {

        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $auth = new Usuario($_POST);
            $alertas = $auth->validarEmail();

            if (empty($alertas)) {
                $usuario = Usuario::where('email', $auth->email);

                if ($usuario && $usuario->confirmado === '1') {

                    // Generar Token
                    $usuario->crearToken();
                    $usuario->guardar();

                    // Enviar Email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarInstrucciones();

                    // Mostrar mensaje de exito
                    Usuario::setAlerta('exito', 'Revisa tu  Email');
                } else {

                    //Mostrar mensaje de error
                    Usuario::setAlerta('error', 'Usuario no existe o no esta confirmado');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/olvidePass', [

            'alertas' => $alertas

        ]);
    }

    public static function recuperar(Router $router)
    {

        $alertas = [];
        $error = false;

        // Sanitizar la entrada al HTML
        $token = s($_GET['token']);        

        // Buscar Usuario por su token
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {

            //mostrar mensaje de error
            Usuario::setAlerta('error', 'Token no válido');
            $error = true;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Leer el nuevo password y guardarlo
            $password = new Usuario($_POST);
            $alertas = $password -> validarPassword();  
            
            // debuguear($password);

            if(empty($alertas)) {                

                // Eliminar password actual del objeto
                $usuario->password = null;

                // debuguear($password);

                // Asignamos el nuevo password al usuario
                $usuario->password = $password->password;                

                // Hashear Password
                $usuario -> hashPassword();                

                // Eliminamos el token
                $usuario -> token = null;                

                // Guardamos el usuario
                $resultado = $usuario -> guardar();

                if($resultado) {
                    header('Location: /');
                }                
            }               
        }

        // Renderizar la Vista
        $alertas = Usuario::getAlertas();

        // Obtener Alertas
        $router->render('auth/recuperarPassword', [

            'alertas' => $alertas,
            'error' => $error

        ]);
    }

    public static function crear(Router $router)
    {

        $usuario = new Usuario;
        $alertas = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            // Revisar que alertas este vacio 
            if (empty($alertas)) {
                // Verificar que el usuario no este ya registrado por medio del email 
                $resultado = $usuario->validarUsuario();

                if ($resultado->num_rows) {

                    $alertas = Usuario::getAlertas();
                } else {
                    // Hashear Password
                    $usuario->hashPassword();

                    // Crear Token Unico
                    $usuario->crearToken();

                    // Enviar email de confirmación de cuenta por token
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);

                    $email->enviarConfirmacion();

                    // Crear el Usuario
                    $resultado = $usuario->guardar();
                    if ($resultado) {
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

    public static function mensaje(Router $router)
    {
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router)
    {

        $alertas = [];

        // // Sanitizar la entrada al HTML
        // $token = s($_GET['token']);

        // debuguear($token);

        // $usuario = Usuario::where('token', $token);

        // if (empty($usuario) || $usuario->token === '') {

        //     //mostrar mensaje de error
        //     Usuario::setAlerta('error', 'Token no válido...');
        // } else {

        //     //cambiar valor de columna confirmado
        //     $usuario->confirmado = '1';
        //     //eliminar token
        //     $usuario->token = '';
        //     //Guardar y Actualizar 
        //     $usuario->guardar();
        //     //mostrar mensaje de exito
        //     Usuario::setAlerta('exito', 'Cuenta verificada exitosamente...');
        // }

        // // Renderizar la Vista
        // $alertas = Usuario::getAlertas();

        // Obtener Alertas
        $router->render('auth/confirmarCuenta', [
            'alertas' => $alertas
        ]);
    }
}
