<?php

namespace Model;



class Usuario extends ActiveRecord
{
    // Base de Datos 
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }   

    // Mensajes de Validacion para la Creación de una cuenta
    public function validarNuevaCuenta()
    {        
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }
        if (!$this->apellido) {
            self::$alertas['error'][] = 'El apellido es obligatorio';
        }
        if (!$this->telefono) {
            self::$alertas['error'][] = 'El telefono es obligatorio';
        }
        if (!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'El password es obligatorio';
        }
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El password debe contener al menso 6 caracteres';
        }
        return self::$alertas;
    }

    public function validarLogin()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if (!$this->password) {
            self::$alertas['error'][] = 'El password es obligatorio';
        }
        return self::$alertas;
    }

    public function validarEmail()
    {
        if (!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }
    }
    
    public function validarPassword()
    {
        if (!$this->password) {
            self::$alertas['error'][] = 'El password es obligatorio';
        }
        if (strlen($this->password) < 6) {
            self::$alertas['error'][] = 'Password de 6 caracteres mínimo';
        }
        return self::$alertas;
    }

    public function validarUsuario()
    {
        // Revisa si el usuario ya existe
        $query = " SELECT * FROM " . static::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1 ";

        $resultado = self::$db->query($query);

        if ($resultado->num_rows) {

            self::$alertas['error'][] = 'Usuario ya registrado';
        }

        return $resultado;
    }

    public function hashPassword()
    {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken()
    {
        $this->token = uniqid();
    }

    public function comprobarYVerificarPassword($password)
    {

        $resultado = password_verify($password, $this->password);

        if (!$resultado || !$this->confirmado) {

            self::$alertas['error'][] = 'Password incorrecto o cuenta sin confirmar aun';
        } else {

            return true;
        }
    }
}

$ip = $_SERVER['REMOTE_ADD'];
$captcha =  $_POST['g-recaptcha-response'];
$secretkey = '6LeOwN8iAAAAAPxAZRj4Xfa_EWxcmA6tM52t6V4q';

$respuesta = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$captacha&remoteip=$ip');

$atributos = json_decode($respuesta, TRUE);

if (!$atributos['success']) {
    self::$alertas['error'][] = 'Verifica el Captcha';
}