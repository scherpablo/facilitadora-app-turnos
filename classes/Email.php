<?php

namespace Classes;

// use PDO;
use PHPMailer\PHPMailer\PHPMailer;

// require __DIR__ . '/../vendor/autoload.php';

class Email
{

    public $nombre;
    public $email;    
    public $token;

    // public function __construct($email, $nombre, $token)
    public function __construct($nombre, $email, $token)
    {

        $this->nombre = $nombre;
        $this->email = $email;        
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {
        // Crear el objeto del mail
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->Username = 'appdeturnos@gmail.com';
        $mail->Password = 'tpvwtlnspyrkstd';
        $mail->SMTPSecure = 'tls';

        $mail->setFrom('appdeturnos@gmail.com');
        $mail->addAddress($this->email);
        $mail->Subject = 'Confirma tu Registración';

        // Utilizamos HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has creado tu cuenta en Facilitadora App de Turnos,
        solo debes confirmarla haciendo click en el siguiente enlace.</p>";
        // $contenido .= "<p>Presiona aquí: <a href= 'https://facilitadora-app-de-turnos.herokuapp.com/confirmarCuenta?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Presiona aquí: <a href= 'http://localhost:3000/confirmarCuenta?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje.</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        // Enviar el mail
        $mail->send();
    }

    public function enviarInstrucciones() {

        // Crear el objeto del mail
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Port = 587;
        $mail->Username = 'appdeturnos@gmail.com';
        $mail->Password = 'tpvwtlnspyrkstd';
        $mail->SMTPSecure = 'tls';

        $mail->setFrom('appdeturnos@gmail.com');
        $mail->addAddress($this->email);
        $mail->Subject = 'Reestablece tu password';

        // Utilizamos HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . "</strong> Has solicitado reestablecer tu password, sigue el siguiente enlace para hacerlo</p>";
        // $contenido .= "<p>Presiona aquí: <a href= 'http://facilitadora-app-de-turnos.herokuapp.com/recuperar?token=" . $this->token . "'>Reestablecer Password</a></p>";
        $contenido .= "<p>Presiona aquí: <a href= 'http://localhost:3000/recuperar?token=" . $this->token . "'>Reestablecer Password</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta acción, puedes ignorar el mensaje.</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido;

        // Enviar el mail
        $mail->send();
    }
}
